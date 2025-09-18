<?php

namespace App\Http\Controllers\Web\Payment;

// Core
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

// Helpers
use Illuminate\Support\Facades\Auth;
use App\Http\Helpers\Helper;

// Models
use App\Models\User;
use App\Models\Category\Category;
use App\Models\Products\Product;
use App\Models\Products\ProductVariant;
use App\Models\Cart\Cart;
use App\Models\Order\Order;
use App\Models\Order\OrderItem;
use App\Models\Search;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $categories = Category::all()->where('status', 1);
        if ($user) {
            $countCartItem = Cart::where('user_id', $user->id)->count();
        } else {
            $countCartItem = 0;
        }

        $cartIds = collect(session('cart_ids', []))->toArray();
        if (empty($cartIds)) {
            return redirect()->route('web.cart.index')->with('error', 'Có lỗi trong quá trình xử lý!');
        }

        $orderInfo = collect([]);
        foreach ($cartIds as $item) {
            $cart = Cart::find($item['id']);
            if (!$cart) {
                return redirect()->route('web.cart.index')->with('error', 'Có lỗi trong quá trình xử lý!');
            }

            $variant = ProductVariant::find($cart->product_variant_id);
            if (!$variant) {
                return redirect()->route('web.cart.index')->with('error', 'Có lỗi trong quá trình xử lý!');
            }

            $product = $variant->product;
            if (!$product) {
                return redirect()->route('web.cart.index')->with('error', 'Có lỗi trong quá trình xử lý!');
            }
            $orderInfo->push([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'thumbnail' => $variant->thumbnail,
                'quantity' => $cart->quantity,
                'price' => $item['price'],
                'variant' => [
                    'variant_id' => $variant->id,
                    'color' => $variant->color,
                    'ram' => $variant->storage['ram'],
                    'rom' => $variant->storage['rom']
                ],
                'total_price' => $item['price'] * $cart->quantity
            ]);
        }

        $orders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $searchHistories = Search::where('user_id', $user->id)->take(4)->orderBy('created_at', 'desc')->get();

        return view('web.pages.payment', [
            'user' => $user,
            'categories' => $categories,
            'countCartItem' => $countCartItem,
            'orderInfo' => $orderInfo,
            'orders' => $orders,
            'searchHistories' => $searchHistories
        ]);
    }

    public function cod(Request $request)
    {
        $data = $request->all();
        if($data['customer_name'] == '' || $data['customer_email'] == '' || $data['customer_phone'] == '' || $data['customer_address'] == '') {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng nhập đầy đủ thông tin!',
                'redirect' => route('web.payment.index')
            ]);
        }
        $user = User::find($data['customer_id']);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy thông tin khách hàng!',
                'redirect' => route('web.payment.index')
            ]);
        }

        $orderCode = Helper::genOrderCode($data['customer_id']);

        $newOrder = new Order();
        $newOrder->order_code = $orderCode;
        $newOrder->user_id = $user->id;
        $newOrder->customer_info = [
            'customer_name' => $data['customer_name'],
            'customer_phone' => $data['customer_phone'],
            'customer_address' => $data['customer_address']
        ];
        $newOrder->payment_method = $data['payment_method'];
        $newOrder->status = 'processing';
        $newOrder->save();

        foreach ($data['order_info'] as $item) {
            $cart = Cart::find($item['cart_id']);
            if (!$cart) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy thông tin giỏ hàng!',
                    'redirect' => route('web.payment.index')
                ]);
            }

            $product = Product::find($item['product_id']);
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy thông tin sản phẩm!',
                    'redirect' => route('web.payment.index')
                ]);
            }

            $variant = ProductVariant::find($item['variant']['variant_id']);
            if (!$variant) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy thông tin sản phẩm!',
                    'redirect' => route('web.payment.index')
                ]);
            }

            $newOrder->orderItems()->create([
                'product_id' => $product->id,
                'product_variant_id' => $variant->id,
                'product_name' => $product->name,
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'variant' => [
                    'color' => $item['variant']['color'],
                    'ram' => $item['variant']['ram'],
                    'rom' => $item['variant']['rom']
                ],
                'total_price' => $item['total_price'],
            ]);

            $variant->quantity = $variant->quantity - $cart->quantity;
            $variant->save();

            $cart->delete();
        }

        session()->forget('cart');

        return response()->json([
            'success' => true,
            'message' => 'Đặt hàng thành công!',
            'redirect' => route('web.cart.index')
        ]);
    }

    public function online()
    {

    }
}