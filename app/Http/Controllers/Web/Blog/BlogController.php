<?php

namespace App\Http\Controllers\Web\Blog;

// Core
use Illuminate\Routing\Controller;

// Helper
use Illuminate\Support\Facades\Auth;

// Models
use App\Models\Blog\Blog;
use App\Models\Category\Category;
use App\Models\Cart\Cart;
use App\Models\Products\ProductVariant;
use App\Models\Order\Order;
use App\Models\Search;


class BlogController extends Controller
{
    public function list()
    {
        $user = Auth::user();
        $blogs = Blog::orderBy('created_at', 'desc')->paginate(10);
        $categories = Category::all()->where('status', 1);
        if ($user) {
            $countCartItem = Cart::where('user_id', $user->id)->count();

            $carts = Cart::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            $orders = Order::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->take(4)
                ->get();

            $searchHistories = Search::where('user_id', $user->id)->take(4)->orderBy('created_at', 'desc')->get();

        } else {
            $countCartItem = 0;
            $carts = [];
            $orders = [];
            $searchHistories = [];
        }

        return view('web.pages.blog', [
            'user' => $user,
            'blogs' => $blogs,
            'countCartItem' => $countCartItem,
            'carts' => $carts,
            'orders' => $orders,
            'searchHistories' => $searchHistories,
            'categories' => $categories
        ]);
    }

    public function detail($id)
    {
        $user = Auth::user();
        $blog = Blog::find($id);
        $categories = Category::all()->where('status', 1);
        if ($user) {
            $countCartItem = Cart::where('user_id', $user->id)->count();

            $carts = Cart::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            $orders = Order::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->take(4)
                ->get();

            $searchHistories = Search::where('user_id', $user->id)->take(4)->orderBy('created_at', 'desc')->get();

        } else {
            $countCartItem = 0;
            $carts = [];
            $orders = [];
            $searchHistories = [];
        }

        return view('web.pages.blog-detail', [
            'user' => $user,
            'blog' => $blog,
            'countCartItem' => $countCartItem,
            'carts' => $carts,
            'orders' => $orders,
            'searchHistories' => $searchHistories,
            'categories' => $categories
        ]);
    }
}