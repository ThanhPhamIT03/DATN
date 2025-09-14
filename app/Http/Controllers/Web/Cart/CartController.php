<?php

namespace App\Http\Controllers\Web\Cart;

// Core
use Illuminate\Http\Request;

// Helpers
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

// Models
use App\Models\Category\Category;
use App\Models\Cart\Cart;
use App\Models\Products\ProductVariant;
use App\Models\Order\Order;

class CartController
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('auth.login.index')->with('error', 'Vui lòng đăng nhập để thực hiện chức năng này!');
        }

        $categories = Category::all()->where('status', 1);
        $carts = Cart::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($user) {
            $countCartItem = Cart::where('user_id', $user->id)->count();
        } else {
            $countCartItem = 0;
        }

        $orders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('web.pages.cart', [
            'user' => $user,
            'categories' => $categories,
            'carts' => $carts,
            'countCartItem' => $countCartItem,
            'orders' => $orders
        ]);
    }

    public function add(Request $request)
    {
        $variant = ProductVariant::find($request->variant_id);
        if (!$variant) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm!'
            ], 404);
        }

        $product = $variant->product;
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm!'
            ], 404);
        }

        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để thực hiện chức năng này!'
            ]);
        }

        $checkCart = Cart::where('user_id', $user->id)
            ->where('product_variant_id', $variant->id)
            ->first();
        if ($checkCart) {
            $checkCart->quantity = $checkCart->quantity + $request->quantity;
            $checkCart->save();
        } else {
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'product_variant_id' => $variant->id,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'info' => $request->info
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Thêm vào giỏ hàng thành công!'
        ], 200);
    }

    public function delete(Request $request)
    {
        $cart = Cart::find($request->id);
        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy thông tin!'
            ]);
        }

        $cart->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xoá sản phẩm khỏi giỏ hàng thành công!'
        ]);
    }

    public function addQuantity(Request $request)
    {
        $cart = Cart::find($request->id);
        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy thông tin!'
            ]);
        }

        $cart->quantity = $request->quantity;
        $cart->save();
    }

    public function minusQuantity(Request $request)
    {
        $cart = Cart::find($request->id);
        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy thông tin!'
            ]);
        }

        $cart->quantity = $request->quantity;
        $cart->save();
    }

    public function collect(Request $request)
    {
        $items = $request->items;
        if (empty($items)) {
            return response()->json([
                'success' => false,
                'message' => 'Không có thông tin!'
            ]);
        }

        session(['cart_ids' => $items]);
        session()->save();

        return response()->json([
            'success' => true,
            'message' => 'Lấy thông tin thành công!',
            'redirect' => route('web.payment.index')
        ]);
    }
}
