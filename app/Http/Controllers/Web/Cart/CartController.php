<?php

namespace App\Http\Controllers\Web\Cart;

use Illuminate\Http\Request;

class CartController
{
    public function index()
    {
        return view('web.pages.cart');
    }
}
