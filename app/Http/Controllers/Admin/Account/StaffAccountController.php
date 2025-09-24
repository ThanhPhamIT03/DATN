<?php

namespace App\Http\Controllers\Admin\Account;

// Core
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

// Helpers
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

// Models
use App\Models\User;

class StaffAccountController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = User::where('role', 'admin')->orderBy('created_at', 'desc');

        if ($request->filled('keyword')) {
            $query->where('code', $request->keyword);
        }

        $staffs = $query->paginate(10)->withQueryString();

        return view('admin.pages.account.staff', [
            'user' => $user,
            'staffs' => $staffs
        ]);
    }

    public function add(Request $request)
    {
        if ($request->name == '' || $request->phone == '' || $request->email == '' || $request->password == '') {
            return back()->with('error', 'Vui lòng điền đầy đủ thông tin!');
        }

        $date = str_replace('-', '', Carbon::now()->format('Ymd'));
        $shortPhone = substr($request->phone, -3);
        $code = $date . $shortPhone;

        $user = User::create([
            'name' => $request->name,
            'code' => $code,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'address' => [],
            'default_address' => null
        ]);

        return back()->with('success', 'Thêm nhân viên mới thành công!');
    }

    public function remove(Request $requets)
    {
        $staff = User::find($requets->id);
        if(!$staff) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy nhân viên!'
            ]);
        }

        $staff->role = 'user';
        $staff->save();

        return response()->json([
            'success' => true,
            'message' => 'Đã thu hồi'
        ]);
    }
}