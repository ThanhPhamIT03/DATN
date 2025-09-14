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


class AddProductController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $categories = Category::all()->where('type', 'product');
        $brands = Brand::all()->where('status', 1);

        return view('admin.pages.products.add-product', [
            'user' => $user,
            'categories' => $categories,
            'brands' => $brands
        ]);
    }

    public function add(Request $request)
    {
        $category = Category::find($request->category_id);
        if(!$category) {
            return back()->with('error', 'Không tìm thấy danh mục sản phẩm');
        }

        $brand = Brand::find($request->brand);
        if(!$brand) {
            return back()->with('error', 'Không tìm thấy thương hiệu');
        }

        if($request->name == '' || $request->model == '' || $request->condition == '' || $request->discount == '') {
            return back()->with('error', 'Vui lòng nhập đầy đủ thông tin');
        }

        if(!is_numeric($request->discount)) {
            return back()->with('error', 'Giảm giá phải là số');
        }

        if($request->thumbnail == '') {
            return back()->with('error', 'Vui lòng chọn ảnh đại diện sản phẩm');
        }

        if($request->condition != 'new' && $request->condition != 'used') {
            return back()->with('error', 'Vui lòng chọn trạng thái hợp lệ!');
        }

        $pathImg = null;
        if($request->hasFile('thumbnail')) {
            $pathImg = $request->file('thumbnail')->store('upload/products', 'public');
        }

        Product::create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'name' =>$request->name,
            'slug' => Str::slug($request->name, '-'),
            'model' => $request->model,
            'description' => $request->description,
            'discount' => $request->discount,
            'condition' => $request->condition,
            'is_featired' => 0,
            'status' => 0,
            'images' => null,
            'thumbnail' => $pathImg
        ]);

        return back()->with('success', 'Thêm sản phẩm thành công');
    }
}