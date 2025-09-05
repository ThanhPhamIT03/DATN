<?php

namespace App\Http\Controllers\Web\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController
{
    public function index()
    {
        return view('web.pages.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('phone', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home.index')
                ->with('success', 'Đăng nhập thành công!');
        }

        return redirect()->back()
            ->with('error', 'Số điện thoại hoặc mật khẩu không đúng?')
            ->withInput($request->only('phone'));
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home.index')->with('success', 'Đăng xuất thành công - Đăng nhập để xem các ưu đãi!');
    }
}
