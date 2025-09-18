<?php

namespace App\Http\Controllers\Web\Search;

// Core
use Illuminate\Http\Request;

// Helpers
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// Models
use App\Models\Category\Category;
use App\Models\Cart\Cart;
use App\Models\Order\Order;
use App\Models\Products\Product;
use App\Models\Search;

class SearchController
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $categories = Category::all()->where('status', 1);

        if ($user) {
            $countCartItem = Cart::where('user_id', $user->id)->count();
        } else {
            $countCartItem = 0;
        }

        if ($user) {
            $orders = Order::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

            Search::create([
                'user_id' => $user->id,
                'keyword' => $request->keyword
            ]);

            $searchHistories = Search::where('user_id', $user->id)->take(4)->orderBy('created_at', 'desc')->get();
        }
        else {
            $orders = [];
            $searchHistories = [];
        }

        $keyword = $request->keyword;

        $query = Product::where('products.status', 1)
            ->where('products.name', 'like', '%' . $keyword . '%');

        // Sort theo giá dựa vào variants
        if ($request->sort == 'price_asc') {
            $query->join('product_variants', 'product_variants.product_id', '=', 'products.id')
                ->select('products.*', DB::raw('MIN(product_variants.sale_price) as min_price'))
                ->groupBy('products.id')
                ->orderBy('min_price', 'asc');
        } elseif ($request->sort == 'price_desc') {
            $query->join('product_variants', 'product_variants.product_id', '=', 'products.id')
                ->select('products.*', DB::raw('MAX(product_variants.sale_price) as max_price'))
                ->groupBy('products.id')
                ->orderBy('max_price', 'desc');
        } else {
            $query->orderBy('products.created_at', 'desc');
        }

        // Phân trang
        $searchResults = $query->paginate(10)->withQueryString();

        return view('web.pages.search-result', [
            'user' => $user,
            'categories' => $categories,
            'countCartItem' => $countCartItem,
            'orders' => $orders,
            'searchResults' => $searchResults,
            'keyword' => $keyword,
            'searchHistories' => $searchHistories
        ]);
    }

    public function delete(Request $request)
    {
        $user = Auth::user();
        if(!$user) {
            return back()->with('error', 'Vui lòng đăng nhập!');
        }

        $searchHistories = $user->searchHistory;

        foreach($searchHistories as $item) {
            $item->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Xóa lịch sử tìm kiếm thành công!'
        ]);
    }
}
