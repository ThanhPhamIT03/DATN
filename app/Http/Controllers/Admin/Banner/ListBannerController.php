<?php

namespace App\Http\Controllers\Admin\Banner;

// Core
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

// Helpers
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

// Models
use App\Models\Banner\Banner;

class ListBannerController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $banners = Banner::all();

        return view('admin.pages.banners.list-banner', [
            'user' => $user,
            'banners' => $banners
        ]);
    }

    public function status(Request $request)
    {
        $banner = Banner::find($request->id);

        if (!$banner) {
            return response()->json([
                'success' => false,
                'message' => 'Banner không tồn tại!'
            ], 404);
        }

        $banner->status = $request->status;
        $banner->save();

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái banner thành công!'
        ], 200);
    }

    public function edit(Request $request)
    {
        $banner = Banner::find($request->id);
        if (!$banner) {
            return response()->json([
                'success' => false,
                'message' => 'Banner không tồn tại!'
            ], 404);
        }
        $banner->title = $request->title;
        $banner->description = $request->description;
        $banner->link = $request->link;
        if ($request->hasFile('image')) {
            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }
            $banner->image = $request->file('image')->store('upload/banner', 'public');
        }
        $banner->save();

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật banner thành công!'
        ], 200);
    }

    public function delete(Request $request)
    {
        $banner = Banner::find($request->id);
        if (!$banner) {
            return response()->json([
                'success' => false,
                'message' => 'Banner không tồn tại!'
            ], 404);
        }
        if($banner->image && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();
        return response()->json([
            'success' => true,
            'message' => 'Xoá banner thành công!'
        ], 200);
    }
}