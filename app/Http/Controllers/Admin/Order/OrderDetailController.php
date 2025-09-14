<?php

namespace App\Http\Controllers\Admin\Order;

// Core
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

// Helpers
use Illuminate\Support\Facades\Auth;

// Models
use App\Models\Order\Order;

class OrderDetailController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $order = Order::find($request->id);
        if(!$order) {
            return redirect()->route('admin.order.list.index')->with('error', 'Không tìm thấy đơn hàng!');
        }

        

        return view('admin.pages.orders.order-detail', [
            'user' => $user
        ]);
    }
}