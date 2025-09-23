<?php

namespace App\Http\Helpers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\MailService;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;

// Models
use App\Models\Order\Order;
use App\Models\Order\Bill;

class Helper
{
    public static function genSlug($name)
    {
        $slug = mb_strtolower($name, 'UTF-8');

        $unicode = [
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd' => 'đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
        ];

        foreach ($unicode as $nonUnicode => $uni) {
            $slug = preg_replace("/($uni)/i", $nonUnicode, $slug);
        }

        $slug = preg_replace('/[^a-z0-9]+/i', '-', $slug);

        $slug = trim($slug, '-');

        return $slug;
    }

    public static function genOrderCode($userId)
    {
        $currentDate = Carbon::now()->format('Ymd');
        $currentTime = Carbon::now()->format('Hms');
        $code = 'ORD' . $currentDate . $currentTime . $userId;

        return $code;
    }

    public static function exportPdf($orderId)
    {
        $order = Order::with(['user', 'orderItems'])->find($orderId);

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
    }
}