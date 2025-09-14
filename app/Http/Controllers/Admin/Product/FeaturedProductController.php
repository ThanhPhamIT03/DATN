<?php

namespace App\Http\Controllers\Admin\Product;

// Core
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

// Helpers
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

// Models
use App\Models\Category\Category;
use App\Models\Products\Brand;
use App\Models\Products\Product;


class FeaturedProductController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Product::with(['category', 'brand'])
            ->where('is_featured', 1);
        $products = $query->paginate(10)->withQueryString();

        $productsIsFeatured = Product::where('is_featured', 0)
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->pluck('name', 'id');

        return view('admin.pages.products.featured-product', [
            'user' => $user,
            'products' => $products,
            'productsIsFeatured' => $productsIsFeatured
        ]);
    }

    public function status(Request $request)
    {
        $product = Product::find($request->id);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm không tồn tại!'
            ], 404);
        }

        $product->is_featured = $request->is_featured;
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái sản phẩm thành công!'
        ], 200);
    }

    public function add(Request $request)
    {
        $product = Product::find($request->id);
        if (!$product) {
            return back()->with('error', 'Sản phẩm không tồn tại');
        }

        $product->is_featured = 1;
        $product->save();

        return back()->with('success', 'Thêm sản phẩm nổi bật thành công');
    }
}