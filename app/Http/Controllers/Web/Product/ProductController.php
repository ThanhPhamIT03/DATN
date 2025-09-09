<?php

namespace App\Http\Controllers\Web\Product;

// Core
use Illuminate\Http\Request;

// Helpers
use Illuminate\Support\Facades\Auth;

// Models
use App\Models\Category\Category;

class ProductController
{
    public function index()
    {
        $user = Auth::user();
        $categories = Category::all()->where('status', 1);

        return view('web.pages.product-detail', [
            'user' => $user,
            'categories' => $categories
        ]);
    }
}
