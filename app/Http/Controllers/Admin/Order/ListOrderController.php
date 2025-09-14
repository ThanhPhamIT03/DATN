<?php

namespace App\Http\Controllers\Admin\Order;

// Core
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

// Helpers
use Illuminate\Support\Facades\Auth;

// Models
use App\Models\Order\Order;

class ListOrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = Order::orderBy('created_at', 'desc');

        if($request->filled('order_code')) {
            $query->where('order_code', $request->order_code);
        }

        if($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('admin.pages.orders.list-order', [
            'user' => $user,
            'orders' => $orders
        ]);
    }

    public function status(Request $request)
    {
        $order = Order::find($request->id);
        if(!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy đơn hàng!'
            ]);
        }
        $order->status = $request->status;
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái đơn hàng thành công!'
        ], 200);
    }

    public function detail(Request $request)
    {
        
    }
} 