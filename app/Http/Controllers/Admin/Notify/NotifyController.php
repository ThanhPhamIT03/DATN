<?php

namespace App\Http\Controllers\Admin\Notify;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotifyController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $notifications = Notification::orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.pages.notify.notify', [
            'user' => $user,
            'notifications' => $notifications
        ]);
    }

    public function read(Request $request)
    {
        $notify = Notification::find($request->id);
        if (!$notify) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy thông báo!',
                'redirect' => $request->redirect
            ]);
        }

        $notify->is_read = true;
        $notify->save();

        return response()->json([
            'success' => true,
            'message' => 'Đã đọc thông báo!',
            'redirect' => $request->redirect
        ]);
    }

    public function markAllRead(Request $request)
    {
        $allNotify = Notification::where('is_read', 0)
            ->get();
            
        foreach ($allNotify as $noti) {
            $noti->is_read = 1;
            $noti->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Đã đọc tất cả thông báo!'
        ]);
    }
}