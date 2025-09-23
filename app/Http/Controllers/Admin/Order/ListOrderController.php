<?php

namespace App\Http\Controllers\Admin\Order;

// Core
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

// Helpers
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use App\Services\MailService;

// Models
use App\Models\Order\Order;
use App\Models\Order\Bill;

class ListOrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Order::orderBy('created_at', 'desc');

        if ($request->filled('order_code')) {
            $query->where('order_code', $request->order_code);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('status')) {
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
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy đơn hàng!'
            ]);
        }
        $order->status = $request->status;
        $order->save();

        // Chuẩn bị dữ liệu gửi mail
        $toEmail = $order->user->email;
        $subject = 'Trạng thái đơn hàng';
        $view = 'email.status-order';
        if($order->status == 'processing') {
            $status = 'Đang xử lý';
        }
        elseif($order->status == 'shipping') {
            $status = 'Đang giao';
        }
        elseif($order->status == 'success') {
            $status = 'Đã giao';
        }
        else {
            $status = 'Đã hủy';
        }
        $data = [
            'order_code' => $order->order_code,
            'status' => $status
        ];
        $attachment = null;

        MailService::sendMail($toEmail, $subject, $view, $data, $attachment);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái đơn hàng thành công. Thông báo sẽ dược gửi đến email của khách hàng!'
        ], 200);
    }

    public function export(Request $request)
    {
        $order = Order::with(['user', 'orderItems'])->find($request->order_id);

        if (!$order) {
            return back()->with('error', 'Không tìm thấy đơn hàng!');
        }

        $bill = Bill::where('order_id', $order->id)->first();
        if ($bill) {
            return back()->with('error', 'Hoá đơn đã được tạo!');
        } else {
            $customerInfo = [
                'name' => $order->customer_info['customer_name'] ?? '',
                'phone' => $order->customer_info['customer_phone'] ?? '',
                'email' => $order->user->email ?? '',
                'address' => $order->customer_info['customer_address'] ?? ''
            ];

            $orderItems = $order->orderItems;

            $total = $orderItems->sum(fn($item) => (int) $item->total_price);

            $dir = storage_path('/app/public/upload/bills');
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0777, true, true);
            }

            $fileName = 'bill_' . $order->order_code . '.pdf';

            // Link public
            $fileUrl = asset('storage/upload/bills/' . $fileName);

            $newBill = new Bill();
            $newBill->bill_code = 'HD' . $order->order_code . ' - ' . Carbon::now()->format('d/m/Y');
            $newBill->user_id = $order->user->id;
            $newBill->order_id = $order->id;
            $newBill->path = $fileUrl;
            $newBill->save();

            $pdf = Pdf::loadView('pdf.bill', [
                'billCode' => $newBill->bill_code,
                'order' => $order,
                'customerInfo' => $customerInfo,
                'orderItems' => $orderItems,
                'total' => $total
            ]);

            $order->status = 'shipping';
            $order->save();

            // Lưu file
            $pdf->save($dir . '/' . $fileName);

            // Chuẩn bị dữ liệu gửi mail
            $toEmail = $order->user->email;
            $subject = 'Thông báo đơn hàng';
            $view = 'email.email-order';
            $data = [
                'order_code' => $order->order_code,
            ];
            $attachment = $fileUrl;

            MailService::sendMail($toEmail, $subject, $view, $data, $attachment);

            return back()->with('success', 'Tạo hoá đơn thành công. Thông báo sẽ được gửi đến email của khách hàng!');
        }

        // Tải file
        // return response()->download($path . '/' . $fileName);
    }
}