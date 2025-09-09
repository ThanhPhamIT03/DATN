<?php

namespace App\Http\Controllers\Admin\Product;

// Core
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

// Helpers
use Illuminate\Support\Facades\Auth;

// Models
use App\Models\Category\Category;
use App\Models\Products\Brand;

class AddProductController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $categories = Category::all()->where('type', 'product');
        $brands = Brand::all()->where('status', 1);

        return view('admin.pages.products.add-product', [
            'user' => $user,
            'categories' => $categories,
            'brands' => $brands
        ]);
    }
}