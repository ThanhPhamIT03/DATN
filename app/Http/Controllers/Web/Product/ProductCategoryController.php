<?php

namespace App\Http\Controllers\Web\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductCategoryController
{
    public function index()
    {
        $user = Auth::user();
        return view('web.pages.product-category', [
            'user' => $user
        ]);
    }
}
