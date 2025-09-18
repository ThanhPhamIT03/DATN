<?php

namespace App\Http\Controllers\Web\Product;

// Core
use Illuminate\Http\Request;

// Helpers
use Illuminate\Support\Facades\Auth;

// Models
use App\Models\Category\Category;
use App\Models\Products\Product;
use App\Models\Cart\Cart;
use App\Models\Order\Order;
use App\Models\Search;

class ProductController
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $categories = Category::all()->where('status', 1);
        $product = Product::find($request->id);
        if (!$product) {
            return back()->with('error', 'Sản phẩm không tồn tại');
        }

        $variants = $product->variants()
            ->where('status', 1)
            ->get();

        $relatedProduct = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('brand_id', $product->brand_id)
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        if ($user) {
            $countCartItem = Cart::where('user_id', $user->id)->count();
            $orders = Order::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
            $searchHistories = Search::where('user_id', $user->id)->take(4)->orderBy('created_at', 'desc')->get();
        } else {
            $countCartItem = 0;
            $orders = [];
            $searchHistories = [];
        }


        return view('web.pages.product-detail', [
            'user' => $user,
            'categories' => $categories,
            'product' => $product,
            'variants' => $variants,
            'relatedProduct' => $relatedProduct,
            'countCartItem' => $countCartItem,
            'orders' => $orders,
            'searchHistories' => $searchHistories
        ]);
    }
}
