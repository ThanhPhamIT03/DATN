<?php

namespace App\Http\Controllers\Web\Home;

// Core
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

// Helpers
use Illuminate\Support\Facades\Auth;

// Models
use App\Models\Banner\Banner;
use App\Models\Category\Category;
use App\Models\Products\Product;
use App\Models\Products\Brand;
use App\Models\Cart\Cart;
use App\Models\Order\Order;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $banners = Banner::all()->where('status', 1);
        $categories = Category::all()->where('status', 1);

        $categoryPhoneId = Category::where('slug', 'dien-thoai')->value('id');
        $categoryTabletId = Category::where('slug', 'may-tinh-bang')->value('id');
        $accessoryId = Category::where('slug', 'phu-kien')->value('id');

        $featuredPhone = Product::where('is_featured', 1)
            ->where('status', 1)
            ->where('category_id', $categoryPhoneId)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $featuredTablet = Product::where('is_featured', 1)
            ->where('status', 1)
            ->where('category_id', $categoryTabletId)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $brands = Brand::where('status', 1)
            ->take(4)
            ->get();

        $accessoryFeatured = Product::where('status', 1)
            ->where('category_id', $accessoryId)
            ->orderBy('created_at', 'desc')
            ->take(12)
            ->get();

        if ($user) {
            $orders = Order::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->take(4)
                ->get();
            $countCartItem = Cart::where('user_id', $user->id)->count();
        } else {
            $countCartItem = 0;
            $orders = [];
        }

        return view('web.pages.home', [
            'user' => $user,
            'banners' => $banners,
            'categories' => $categories,
            'featuredPhone' => $featuredPhone,
            'featuredTablet' => $featuredTablet,
            'brands' => $brands,
            'accessoryFeatured' => $accessoryFeatured,
            'countCartItem' => $countCartItem,
            'orders' => $orders
        ]);
    }
}
