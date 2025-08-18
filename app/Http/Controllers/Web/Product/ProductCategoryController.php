<?php

namespace App\Http\Controllers\Web\Product;

use Illuminate\Http\Request;

class ProductCategoryController
{
    public function index()
    {
        return view('web.pages.product-category');
    }
}
