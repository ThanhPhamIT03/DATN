<?php

namespace App\Http\Controllers\Web\Info;

// Core
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

// Helpers
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

// Models
use App\Models\Order\Order;
use App\Models\User;


class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $orders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(3);

        return view('web.pages.information.account', [
            'user' => $user,
            'orders' => $orders
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if ($request->name == '' || $request->phone == '' || $request->email == '' || $request->birthday == '' || $request->default_address == '') {
            return back()->with('error', 'Vui lòng cập nhật đầy đủ thông tin.');
        }

        $date = $request->birthday;
        $date = str_replace('-', '', Carbon::now()->format('Ymd'));
        $shortPhone = substr($request->phone, -3);
        $code = $date . $shortPhone;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->birthday = $request->birthday;
        $user->code = $code;
        $user->save();

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }

    public function addAddress(Request $request)
    {
        if ($request->address == '') {
            return back()->with('error', 'Vui lòng nhập địa chỉ!');
        }

        $user = Auth::user();

        if ($request->filled('is_default')) {
            $addressList = $user->address ?? [];
            $addressList = collect($addressList);
            $addressList->push($request->address);
            $user->address = $addressList;
            $user->default_address = $request->address;
            $user->save();

            return back()->with('success', 'Thêm địa chỉ mới thành công!');
        } else {
            $addressList = $user->address ?? [];
            $addressList = collect($addressList);
            $addressList->push($request->address);
            $user->address = $addressList;
            $user->save();

            return back()->with('success', 'Thêm địa chỉ mới thành công!');
        }
    }

    public function deleteAddress(Request $request)
    {
        $user = Auth::user();
        $key = $request->key;

        $addressList = $user->address ?? [];

        if (isset($addressList[$key])) {
            unset($addressList[$key]);

            $addressList = array_values($addressList);

            $user->address = $addressList;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Xóa địa chỉ thành công',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Địa chỉ không tồn tại',
        ]);
    }
}