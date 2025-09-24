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
use App\Models\Products\Review;

class ProductController
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $categories = Category::where('status', 1)
            ->whereNotIn('slug', ['tin-cong-nghe', 'khuyen-mai', 'thu-cu-doi-moi'])
            ->get();
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
                ->take(4)
                ->get();
            $searchHistories = Search::where('user_id', $user->id)->take(4)->orderBy('created_at', 'desc')->get();

            // Check xem người dùng đã mua sản phẩm chưa, nếu chưa mua không cho đánh giá
            $check = false;
            $orders = $user->orders;
            foreach ($orders as $order) {
                $orderId = $order->id;
                $orderItems = $order->orderItems;
                foreach ($orderItems as $item) {
                    if ($item->product_id == $product->id) {
                        $check = true;
                        break 2;
                    }
                }
            }

            // Check người dùng chỉ đánh giá một lần
            $isReview = false;
            $review = Review::where('user_id', $user->id)
                ->where('product_id', $product->id)
                ->first();
            if ($review) {
                $isReview = true;
            }
        } else {
            $countCartItem = 0;
            $orders = [];
            $searchHistories = [];
            $check = false;
            $orderId = null;
            $isReview = false;
        }

        $reviews = Review::where('product_id', $product->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('web.pages.product-detail', [
            'user' => $user,
            'categories' => $categories,
            'product' => $product,
            'variants' => $variants,
            'relatedProduct' => $relatedProduct,
            'countCartItem' => $countCartItem,
            'orders' => $orders,
            'searchHistories' => $searchHistories,
            'check' => $check,
            'orderId' => $orderId ?? null,
            'reviews' => $reviews,
            'isReview' => $isReview
        ]);
    }

    public function review(Request $request)
    {
        $user = Auth::user();

        Review::create([
            'user_id' => $user->id,
            'order_id' => $request->order_id,
            'product_id' => $request->product_id,
            'content' => $request->review_text
        ]);

        return back()->with('success', 'Gửi đánh giá thành công!');
    }
}
