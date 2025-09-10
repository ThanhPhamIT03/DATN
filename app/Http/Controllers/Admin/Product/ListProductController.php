<?php

namespace App\Http\Controllers\Admin\Product;

// Core
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

// Helpers
use Illuminate\Support\Facades\Auth;

// Models
use App\Models\Products\Product;
use App\Models\Category\Category;
use App\Models\Products\Brand;

class ListProductController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Product::with(['category', 'brand']);

        if ($request->filled('keyword')) {
            $query->where('name', 'LIKE', '%' . $request->keyword . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        if($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        $products = $query->paginate(10)->withQueryString();

        $categories = Category::where('status', 1)
            ->where('type', 'product')->get();
        $brands = Brand::where('status', 1)->get();

        return view('admin.pages.products.list-product', [
            'user' => $user,
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands
        ]);
    }

    public function status()
    {

    }

    public function edit()
    {

    }

    public function delete()
    {

    }
}