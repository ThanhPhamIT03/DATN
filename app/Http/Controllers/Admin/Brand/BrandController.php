<?php

namespace App\Http\Controllers\Admin\Brand;

// Core
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

// Helpers
use Illuminate\Support\Facades\Auth;
use App\Http\Helpers\Helper;
use Illuminate\Support\Facades\Storage;

// Models
use App\Models\Products\Brand;

class BrandController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $brands = Brand::all();

        return view('admin.pages.brand.brand', [
            'user' => $user,
            'brands' => $brands
        ]);
    }

    public function add(Request $request)
    {
        if ($request->name == '') {
            return back()->with('error', 'Vui lòng nhập đầy đủ thông tin!');
        }
        if ($request->image == '') {
            return back()->with('error', 'Vui lòng chọn ảnh thương hiệu!');
        }

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('upload/brands', 'public');
        }

        $slug = Helper::genSlug($request->name);

        Brand::create([
            'name' => $request->name,
            'slug' => $slug,
            'image' => $path,
            'status' => 0,
            'info' => null
        ]);

        return back()->with('success', 'Thêm thương hiệu thành công!');
    }

    public function status(Request $request)
    {
        $brand = Brand::find($request->id);
        if (!$brand) {
            return response()->json([
                'success' => false,
                'message' => 'Thương hiệu không tồn tại!'
            ]);
        }

        $brand->status = $request->status;
        $brand->save();

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái thương hiệu thành công!'
        ], 200);
    }

    public function edit(Request $request)
    {
        $brand = Brand::find($request->id);
        if (!$brand) {
            return response()->json([
                'success' => false,
                'message' => 'Thương hiệu không tồn tại!'
            ], 404);
        }

        if ($request->name == '') {
            return response()->json([
                'success' => false,
                'message' => 'Tên không được bỏ trống!'
            ], 422);
        }

        $brand->name = $request->name;
        $brand->slug = Helper::genSlug($request->name);
        if($request->hasFile('image')) {
            if ($brand->image && Storage::disk('public')->exists($brand->image)) {
                Storage::disk('public')->delete($brand->image);
            }
            $brand->image = $request->file('image')->store('upload/brands', 'public');
        }
        $brand->save();

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thương hiệu thành công!'
        ], 200);
    }

    public function delete(Request $request)
    {

    }
}