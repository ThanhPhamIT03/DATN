<?php

namespace App\Http\Controllers\Web\Product;

use Illuminate\Http\Request;

class ProductController
{
    public function index()
    {
        return view('web.pages.product-detail');
    }
}
