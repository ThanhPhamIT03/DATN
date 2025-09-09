<?php

namespace App\Http\Controllers\Admin\Product;

// Core
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

// Helpers
use Illuminate\Support\Facades\Auth;

// Models

class ListProductVariantsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('admin.pages.products.list-product-variants', [
            'user' => $user
        ]);
    }
}