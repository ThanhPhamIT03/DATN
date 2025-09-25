<?php

namespace App\Http\Controllers\Web\Info;

// Core

use App\Http\Helpers\Helper;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

// Helpers
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

// Models
use App\Models\Order\Order;
use App\Models\Order\OrderPending;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Order::orderBy('created_at', 'desc')
            ->where('user_id', $user->id);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $dateFrom = Carbon::parse($request->date_from)->startOfDay();
            $dateTo = Carbon::parse($request->date_to)->endOfDay();
            $query->whereBetween('created_at', [$dateFrom, $dateTo]);
        }

        $orders = $query->paginate(5)->withQueryString();

        return view('web.pages.information.buy-history', [
            'user' => $user,
            'orders' => $orders
        ]);
    }

    public function cancel(Request $request)
    {
        $order = Order::find($request->id);
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy đơn hàng!'
            ]);
        }

        $bill = $order->bill;
        if (!$bill && $order->status == 'processing') {
            $orderItems = $order->orderItems;
            foreach ($orderItems as $item) {
                $variant = $item->hasVariant;
                $variant->quantity += $item->quantity;
                $variant->save();
            }
            $order->status = 'cancel';
            $order->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Hủy đơn thành công!'
            ]);
        }
        else {
            $orderPending = OrderPending::where('order_id', $order->id)->first();
            if($orderPending) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn đã gửi yêu cầu hủy cho đơn hàng này!'
                ]);
            }

            $pending = OrderPending::create([
                'user_id' => Auth::user()->id,
                'order_id' => $order->id,
                'reason' => $request->reason,
                'status' => 'pending',
                'order_code' => $order->order_code
            ]);

            Helper::sendNotification($pending, 'request');

            return response()->json([
                'success' => true,
                'message' => 'Yêu cầu hủy đơn thành công!'
            ]);
        }
    }
}