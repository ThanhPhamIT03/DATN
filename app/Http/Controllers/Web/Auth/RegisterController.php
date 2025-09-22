<?php

namespace App\Http\Controllers\Web\Auth;

// Request
use Illuminate\Http\Request;

// Model
use App\Models\User;

// Helpers
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;


class RegisterController extends Controller
{
    public function index()
    {
        return view('web.pages.register');
    }

    public function store(Request $request)
    {
        if($request->name == '' || $request->date == '' || 
            $request->phone == '' || $request->password == '' || $request->password_confirm == '') 
        {
            return redirect()->back()->with('error', 'Vui lòng điền đầy đủ thông tin');
        }

        if($request->password != $request->password_confirm) {
           return redirect()->back()->with('error', 'Mật khẩu không khớp');
        }

        $date = str_replace('-', '', Carbon::now()->format('Ymd'));
        $shortPhone = substr($request->phone, -3);
        $code = $date . $shortPhone;

        $user = User::create([
            'name' => $request->name,
            'code' => $code,
            'promo_register' => $request->has('regis_promo') ? 1 : 0,
            'birthday' => $request->date,   
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'address' => [],
            'default_address' => null
        ]);

        return redirect()->route('auth.login.index')->with('success', 'Đăng ký thành công - Chuyển đến trang đăng nhập!')
                         ->with('phone', $request->phone);
    }
}
