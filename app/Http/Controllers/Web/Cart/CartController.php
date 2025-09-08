<?php

namespace App\Http\Controllers\Web\Cart;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController
{
    public function index()
    {
        $user = Auth::user();
        return view('web.pages.cart', [
            'user' => $user
        ]);
    }
}
