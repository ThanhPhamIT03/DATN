<?php

namespace App\Http\Controllers\Web\Product;

// Core
use Illuminate\Http\Request;

// Helpers
use Illuminate\Support\Facades\Auth;

// Models
use App\Models\Category\Category;
use App\Models\Products\Product;
use App\Models\Products\Brand;
use App\Models\Cart\Cart;
use App\Models\Order\Order;
use App\Models\Search;

class ProductCategoryController
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Lấy danh mục & brand
        $categories = Category::where('status', 1)->get();
        $curentCategory = Category::findOrFail($request->id);
        $brands = Brand::where('status', 1)->get();

        // Query sản phẩm
        $products = Product::select('products.*')
            ->leftJoin('product_variants', 'product_variants.product_id', '=', 'products.id')
            ->selectRaw('MAX(product_variants.sale_price) as max_sale_price')
            ->where('products.category_id', $request->id)
            ->where('products.status', 1);

        if ($request->filled('brand')) {
            $products->where('products.brand_id', $request->brand);
        }

        // Thêm groupBy tất cả cột cần thiết
        $products->groupBy('products.id', 'products.name', 'products.brand_id', 'products.category_id', 'products.status', 'products.created_at', 'products.updated_at');

        // Sắp xếp
        switch ($request->sort) {
            case 'price_desc':
                $products->orderByDesc('max_sale_price');
                break;
            case 'price_asc':
                $products->orderBy('max_sale_price');
                break;
            default:
                $products->orderBy('products.created_at', 'desc');
                break;
        }

        $products = $products->paginate(10)->appends($request->all());

        if ($user) {
            $countCartItem = Cart::where('user_id', $user->id)->count();
            $orders = Order::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->take(4)
                ->get();
            $searchHistories = Search::where('user_id', $user->id)->take(4)->orderBy('created_at', 'desc')->get();
        } else {
            $countCartItem = 0;
            $orders = [];
            $searchHistories = [];
        }



        return view('web.pages.product-category', [
            'user' => $user,
            'categories' => $categories,
            'products' => $products,
            'brands' => $brands,
            'curentCategory' => $curentCategory,
            'countCartItem' => $countCartItem,
            'orders' => $orders,
            'searchHistories' => $searchHistories
        ]);
    }
}
