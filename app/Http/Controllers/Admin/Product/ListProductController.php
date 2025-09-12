<?php

namespace App\Http\Controllers\Admin\Product;

// Core
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

// Helpers
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

// Models
use App\Models\Products\Product;
use App\Models\Category\Category;
use App\Models\Products\Brand;

class ListProductController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Product::with(['category', 'brand'])->orderBy('created_at', 'desc');

        if ($request->filled('keyword')) {
            $query->where('name', 'LIKE', '%' . $request->keyword . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->filled('condition')) {
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

    public function status(Request $request)
    {
        $product = Product::find($request->id);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm không tồn tại!'
            ], 404);
        }

        $product->status = $request->status;
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái sản phẩm thành công!'
        ], 200);
    }

    public function edit(Request $request)
    {
        $product = Product::find($request->id);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm không tồn tại'
            ], 404);
        }

        if (
            $request->name == '' || $request->model == '' || $request->description == '' || $request->price == ''
            || $request->discount == ''
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng nhập đầy đủ thông tin sản phẩm!'
            ], 422);
        }

        if (!is_numeric($request->price) || !is_numeric($request->discount)) {
            return response()->json([
                'success' => false,
                'message' => 'Giá và giảm giá phải là số!'
            ], 422);
        }

        $product->name = $request->name;
        $product->model = $request->model;
        $product->description = $request->description;
        $product->display_price = $request->price;
        $product->discount = $request->discount;
        $product->slug = Str::slug($request->name, '-');
        if ($request->hasFile('thumbnail')) {
            if ($product->thumbnail && Storage::disk('public')->exists($product->thumbnail)) {
                Storage::disk('public')->delete($product->thumbnail);
            }
            $product->thumbnail = $request->file('thumbnail')->store('upload/products', 'public');
        }
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật sản phẩm thành công!'
        ], 200);
    }

    public function delete(Request $request)
    {
        $product = Product::find($request->id);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm không tồn tại!'
            ], 404);
        }

        if ($product->thumbnail && Storage::disk('public')->exists($product->thumbnail)) {
            Storage::disk('public')->delete($product->thumbnail);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xoá sản phẩm thành công!'
        ], 200);
    }
}