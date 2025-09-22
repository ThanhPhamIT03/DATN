<?php

namespace App\Http\Controllers\Web\Auth;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;
use App\Services\SmsService;

class PasswordResetController extends Controller
{
    public function sendOtp(Request $request)
    {
        $otp = rand(10000, 99999);

        DB::table('password_resets_phone')->updateOrInsert(
            ['phone_number' => $request->phone],
            [
                'otp_code' => $otp,
                'expires_at' => Carbon::now()->addMinutes(5),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Gửi SMS OTP
        //SmsService::send($request->phone, "Mã OTP để đặt lại mật khẩu của bạn là: $otp");

        return response()->json([
            'success' => true,
            'message' => 'OTP đã được gửi tới số điện thoại'
        ]);
    }

    public function updatePasswordByOtp(Request $request)
    {
        $record = DB::table('password_resets_phone')
            ->where('phone_number', $request->phone)
            ->where('otp_code', $request->otp)
            ->first();

        if (!$record || Carbon::now()->gt($record->expires_at)) {
            return response()->json([
                'success' => false,
                'message' => 'OTP không hợp lệ hoặc đã hết hạn'
            ]);
        }

        $user = User::where('phone', $request->phone)->first();
        $user->password = Hash::make($request->new_password);
        $user->save();

        DB::table('password_resets_phone')->where('phone_number', $request->phone)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Đổi mật khẩu thành công'
        ]);
    }

    public function loadPageReset()
    {
        return view('web.pages.reset-password');
    }
}