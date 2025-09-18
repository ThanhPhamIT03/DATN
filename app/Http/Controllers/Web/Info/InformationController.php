<?php

namespace App\Http\Controllers\Web\Info;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order\Order;


class InformationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $orders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(3);

        return view('web.pages.information.information', [
            'user' => $user,
            'orders' => $orders
        ]);
    }
}