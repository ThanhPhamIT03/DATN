<?php

namespace App\Http\Controllers\Admin\Category;

// Core

use App\Models\Banner\Category as BannerCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

// Helpers
use Illuminate\Support\Facades\Auth;
use App\Http\Helpers\Helper;

// Models
use App\Models\Category\Category;

class AddCategoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('admin.pages.categories.add-category', [
            'user' => $user
        ]);
    }

    public function add(Request $request)
    {
        if ($request->name == '' || $request->description == '' || $request->type == '') {
            return back()->with('error', 'Vui lòng nhập đầy đủ thông tin!');
        }
        if ($request->image == '') {
            return back()->with('error', 'Vui lòng chọn ảnh danh mục!');
        }

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('upload/category', 'public');
        }

        $slug = Helper::genSlug($request->name);

        Category::create([
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description,
            'image' => $path,
            'slug' => $slug,
            'status' => 0,
            'info' => null
        ]);

        return back()->with('success', 'Thêm danh mục thành công!');
    }
}