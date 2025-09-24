<?php


namespace App\Http\Controllers\Admin\Order;

// Core
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

// Helpers
use Illuminate\Support\Facades\Auth;
use App\Http\Helpers\Helper;

// Models
use App\Models\User;
use App\Models\Products\Product;
use App\Models\Products\ProductVariant;
use App\Models\Order\Order;

class CreateOrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('admin.pages.orders.create-order', [
            'user' => $user
        ]);
    }

    public function searchUser(Request $request)
    {
        $user = User::where('code', $request->user_code)->first();
        if(!$user) {
            return response()->json(null);
        }

        return response()->json($user);
    }

    public function searchProduct(Request $request)
    {
        $products = Product::where('name', 'like', '%' . $request->keyword . '%')
                    ->where('status', '1')
                    ->get();
        return response()->json($products);
    }

    public function searchVariant(Request $request)
    {
        $variants = ProductVariant::where('product_id', $request->product_id)
                ->where('status', 1)
                ->where('quantity', '>', 0)    
                ->get();
        return response()->json($variants);
    }

    public function store(Request $request)
    {
        $user = User::find($request->customer_id);
        if(!$user) {
            return back()->with('error', 'Không tìm thấy thông tin khách hàng');
        }

        $orderCode = Helper::genOrderCode($user->id);

        $newOrder = new Order();
        $newOrder->order_code = $orderCode;
        $newOrder->user_id = $user->id;
        $newOrder->customer_info = [
            'customer_name' => $user->name,
            'customer_phone' => $user->phone,
            'customer_address' => $user->default_address
        ];
        $newOrder->payment_method = 'cod';
        $newOrder->status = 'processing';
        $newOrder->payment_status = 'wait_paid';
        $newOrder->save();

        $product = Product::find($request->product_id);
        if(!$product) {
            return back()->with('error', 'Không tìm thấy sản phẩm!');
        }
        $variant = ProductVariant::find($request->variant_id);
        if(!$variant) {
            return back()->with('error', 'Không tìm thấy phiên bản!');
        }

        $newOrder->orderItems()->create([
            'product_id' => $product->id,
            'product_variant_id' => $variant->id,
            'product_name' => $product->name,
            'price' => $variant->sale_price,
            'quantity' => 1,
            'variant' => [
                'color' => $variant->color,
                'ram' => $variant->storage['ram'],
                'rom' => $variant->storage['rom']
            ],
            'total_price' => $variant->sale_price
        ]);

        $variant->quantity = $variant->quantity - 1;
        $variant->save();

        return back()->with('success', 'Tạo đơn hàng thành công!');
    }
}