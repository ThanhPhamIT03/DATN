<?php

namespace App\Http\Controllers\Admin\Order;

// Core
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

// Helpers
use Illuminate\Support\Facades\Auth;

// Models
use App\Models\Order\Order;
use App\Models\Order\Bill;
use App\Models\Order\OrderPending;

class RequestOrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = OrderPending::orderBy('created_at', 'desc');

        if($request->filled('order_code')) {
            $query->where('order_code', $request->order_code);
        }

        if($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $requests = $query->paginate(10)->withQueryString();

        return view('admin.pages.orders.request', [
            'user' => $user,
            'requests' => $requests
        ]);
    }

    public function status(Request $request)
    {
        $record = OrderPending::find($request->id);
        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy yêu cầu!'
            ]);
        }

        if($request->status == 'approved') {
            $order = $record->order;
            $order->status = 'cancel';
            $orderItems = $order->orderItems;
            foreach ($orderItems as $item) {
                $variant = $item->hasVariant;
                $variant->quantity += $item->quantity;
                $variant->save();
            }
            $order->save();
            $record->delete();

            return response()->json([
                'success' => true,
                'message' => 'Đã chấp nhận hủy đơn'
            ]);
        }
        elseif($request->status == 'rejected') {
            $record->delete();
            return response()->json([
                'success' => true,
                'message' => 'Đã từ chối hủy đơn!'
            ]);
        }
        else {
            return response()->json([
                'success' => false,
                'message' => 'Không thể cập nhật trạng thái!'
            ]);
        }
    }
}