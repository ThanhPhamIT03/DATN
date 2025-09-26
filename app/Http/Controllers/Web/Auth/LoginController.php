<?php

namespace App\Http\Controllers\Web\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

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


    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function googleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // tìm user theo email hoặc social_id
            $user = User::where('social_id', $googleUser->id)
                ->first();

            if (!$user) {
                $phone = substr($googleUser->id, -10);
                $shortPhone = substr($googleUser->id, -3);
                $date = now()->format('Ymd');
                $code = $date . $shortPhone;

                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => Hash::make(Str::random(16)),
                    'phone' => $phone,
                    'code' => $code,
                    'address' => [],
                    'default_address' => null,
                    'birthday' => null,
                    'role' => 'user',
                    'promo_register' => 0,
                    'social_id' => $googleUser->id,
                ]);
            }

            Auth::login($user);

            return redirect()->route('home.index')->with('success', 'Đăng nhập thành công!');
        } catch (\Exception $e) {
            return redirect()->route('auth.login.index')->with('error', 'Đăng nhập Google thất bại!');
        }

    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home.index')->with('success', 'Đăng xuất thành công - Đăng nhập để xem các ưu đãi!');
    }
}
