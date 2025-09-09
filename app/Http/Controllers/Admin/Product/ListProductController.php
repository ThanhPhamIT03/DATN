<?php

namespace App\Http\Controllers\Admin\Product;

// Core
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

// Helpers
use Illuminate\Support\Facades\Auth;

// Models

class ListProductController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('admin.pages.products.list-product', [
            'user' => $user
        ]);
    }
}