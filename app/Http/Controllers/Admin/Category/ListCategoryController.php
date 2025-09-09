<?php

namespace App\Http\Controllers\Admin\Category;

// Core
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

// Helpers
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Helpers\Helper;

// Models
use App\Models\Category\Category;

class ListCategoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $categories = Category::all();

        return view('admin.pages.categories.list-category', [
            'user' => $user,
            'categories' => $categories
        ]);
    }

    public function status(Request $request)
    {
        $category = Category::find($request->id);
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Danh mục không tồn tại!'
            ], 404);
        }

        $category->status = $request->status;
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái danh mục thành công!'
        ], 200);
    }

    public function edit(Request $request)
    {
        $category = Category::find($request->id);
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Danh mục không tồn tại!'
            ], 404);
        }
        $category->name = $request->name;
        $category->description = $request->description;
        $category->slug = Helper::genSlug($request->name);
        if ($request->hasFile('image')) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }
            $category->image = $request->file('image')->store('upload/category', 'public');
        }
        $category->save();
        return response()->json([
            'success' => true,
            'message' => 'Cập nhật danh mục thành công!'
        ], 200);
    }

    public function delete(Request $request)
    {
        $category = Category::find($request->id);
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Danh mục không tồn tại!'
            ], 404);
        }
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();
        return response()->json([
            'success' => true,
            'message' => 'Xoá danh mục thành công!'
        ], 200);
    }
}