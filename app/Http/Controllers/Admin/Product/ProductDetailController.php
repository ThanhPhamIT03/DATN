<?php

namespace App\Http\Controllers\Admin\Product;

// Core
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

// Helpers
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

// Models
use App\Models\Products\Product;
use App\Models\Products\ProductVariant;
use App\Models\Category\Category;
use App\Models\Products\Brand;
use App\Models\Cart\Cart;

class ProductDetailController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $categories = Category::where('type', 'product')
            ->where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();

        $parentProduct = Product::find($request->id);
        if (!$parentProduct) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm không tồn tại!'
            ], 404);
        }

        $productVariants = ProductVariant::where('product_id', $parentProduct->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.pages.products.product-detail', [
            'user' => $user,
            'categories' => $categories,
            'brands' => $brands,
            'parentProduct' => $parentProduct,
            'productVariants' => $productVariants,
        ]);
    }

    public function add(Request $request)
    {
        // if (
        //     !$request->product_id || !$request->code || !$request->color || !$request->storage_rom || !$request->storage_ram ||
        //     !$request->price || !$request->quantity || !$request->operating_system || !$request->screen_size || !$request->screen_technology ||
        //     !$request->front_camera || !$request->rear_camera || !$request->chip ||
        //     !$request->battery || !$request->cpu_type
        // ) {
        //     return back()->with('error', 'Vui lòng nhập đầy đủ thông tin')->withInput();
        // }

        if (!is_numeric($request->price) || !is_numeric($request->quantity)) {
            return back()->with('error', 'Giá và số lượng phải là số');
        }

        if ($request->thumbnail == '') {
            return back()->with('error', 'Vui lòng chọn ảnh đại diện sản phẩm');
        }

        $product = Product::find($request->product_id);
        if (!$product) {
            return back()->with('error', 'Sản phẩm không tồn tại');
        }

        $pathImg = null;
        if ($request->hasFile('thumbnail')) {
            $pathImg = $request->file('thumbnail')->store('upload/products/variants', 'public');
        }

        $info = [
            'operating_system' => $request->operating_system ?? 'Đang cập nhật',
            'screen_size' => $request->screen_size ?? 'Đang cập nhật',
            'screen_technology' => $request->screen_technology ?? 'Đang cập nhật',
            'front_camera' => $request->front_camera ?? 'Đang cập nhật',
            'rear_camera' => $request->rear_camera ?? 'Đang cập nhật',
            'chip' => $request->chip ?? 'Đang cập nhật',
            'rom' => $request->storage_rom . 'GB' ?? 'Đang cập nhật',
            'ram' => $request->storage_ram . 'GB' ?? 'Đang cập nhật',
            'battery' => $request->battery ?? 'Đang cập nhật',
            'cpu_type' => $request->cpu_type ?? 'Đang cập nhật'
        ];

        ProductVariant::create([
            'product_id' => $product->id,
            'code' => $request->code,
            'color' => $request->color,
            'storage' => [
                'rom' => $request->storage_rom . 'GB',
                'ram' => $request->storage_ram . 'GB'
            ],
            'price' => $request->price,
            'sale_price' => $request->price - ($request->price * $product->discount / 100),
            'quantity' => $request->quantity,
            'thumbnail' => $pathImg,
            'status' => 0,
            'info' => $info
        ]);

        return back()->with('success', 'Thêm sản phẩm thành công');
    }

    public function status(Request $request)
    {
        $variant = ProductVariant::find($request->id);
        if (!$variant) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy biến thể!'
            ], 404);
        }

        $variant->status = $request->status;
        $variant->save();

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái thành công!'
        ], 200);
    }

    public function edit(Request $request)
    {
        $variant = ProductVariant::find($request->id);
        if (!$variant) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy biến thể!'
            ], 404);
        }

        if (
            !$request->code || !$request->color || !$request->rom || !$request->ram ||
            !$request->price || !$request->quantity || !$request->operating_system || !$request->screen_size || !$request->screen_technology ||
            !$request->front_camera || !$request->rear_camera || !$request->chip ||
            !$request->battery || !$request->cpu_type
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng nhập đầy đủ thông tin!'
            ], 422);
        }

        if (!is_numeric($request->price) || !is_numeric($request->quantity)) {
            return response()->json([
                'success' => false,
                'message' => 'Giá và số lượng phải là số!'
            ], 422);
        }

        $variant->code = $request->code;
        $variant->color = $request->color;
        $variant->storage = [
            'rom' => $request->rom . 'GB',
            'ram' => $request->ram . 'GB'
        ];
        $variant->price = $request->price;
        $variant->sale_price = $request->price - ($request->price * $variant->product->discount / 100);
        $variant->quantity = $request->quantity;
        $variant->info = [
            'ram' => $request->ram . 'GB',
            'rom' => $request->rom . 'GB',
            'operating_system' => $request->operating_system,
            'screen_size' => $request->screen_size,
            'screen_technology' => $request->screen_technology,
            'front_camera' => $request->front_camera,
            'rear_camera' => $request->rear_camera,
            'chip' => $request->chip,
            'battery' => $request->battery,
            'cpu_type' => $request->cpu_type
        ];

        if ($request->hasFile('thumbnail')) {
            if ($variant->thumbnail && Storage::disk('public')->exists($variant->thumbnail)) {
                Storage::disk('public')->delete($variant->thumbnail);
            }
            $variant->thumbnail = $request->file('thumbnail')->store('upload/products/variants', 'public');
        }

        $variant->save();

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật biến thể thành công!'
        ], 200);
    }

    public function delete(Request $request)
    {
        $variant = ProductVariant::find($request->id);
        if (!$variant) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy biến thể!'
            ], 404);
        }

        if ($variant->thumbnail && Storage::disk('public')->exists($variant->thumbnail)) {
            Storage::disk('public')->delete($variant->thumbnail);
        }

        $variant->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xoá biến thể thành công!'
        ], 200);
    }
}