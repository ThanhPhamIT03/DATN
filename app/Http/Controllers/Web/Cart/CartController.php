<?php

namespace App\Http\Controllers\Web\Cart;

// Core
use Illuminate\Http\Request;

// Helpers
use Illuminate\Support\Facades\Auth;

// Models
use App\Models\Category\Category;

class CartController
{
    public function index()
    {
        $user = Auth::user();
        $categories = Category::all()->where('status', 1);

        return view('web.pages.cart', [
            'user' => $user,
            'categories' => $categories,
        ]);
    }
}
