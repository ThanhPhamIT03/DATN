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

class AddBannerController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('admin.pages.banners.add-banner', [
            'user' => $user
        ]);
    }

    public function add(Request $request)
    {
        if($request->title == '' || $request->description == '' || $request->link == '') {
            return back()->with('error', 'Vui lòng nhập đầy đủ thông tin!');
        }
        if($request->image == '') {
            return back()->with('error', 'Vui lòng chọn ảnh banner!');
        }

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('upload/banner', 'public');
        }
        
        Banner::create([
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
            'image' => $path,
            'status' => 0
        ]);

        return back()->with('success', 'Thêm banner thành công!');
    }
}