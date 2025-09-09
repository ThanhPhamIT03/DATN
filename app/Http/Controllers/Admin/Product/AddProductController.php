<?php

namespace App\Http\Controllers\Admin\Product;

// Core
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

// Helpers
use Illuminate\Support\Facades\Auth;

// Models

class AddProductController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('admin.pages.products.add-product', [
            'user' => $user
        ]);
    }
}