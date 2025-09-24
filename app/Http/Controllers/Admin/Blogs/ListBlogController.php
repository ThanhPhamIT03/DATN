<?php

namespace App\Http\Controllers\Admin\Blogs;

// Core
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

// Helpers
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Helpers\Helper;

// Models
use App\Models\Blog\Blog;
use App\Models\Blog\BlogContainer;
use Illuminate\Support\Facades\Storage;

class ListBlogController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Blog::orderBy('created_at', 'desc');

        if ($request->filled('keyword')) {
            $query->where('title', 'like', '%' . $request->keyword . '%');
        }

        $blogs = $query->paginate(10)->withQueryString();

        return view('admin.pages.blogs.list-blog', [
            'user' => $user,
            'blogs' => $blogs
        ]);
    }

    public function viewEdit($id)
    {
        $user = Auth::user();
        $blog = Blog::find($id);

        return view('admin.pages.blogs.blog-detail', [
            'user' => $user,
            'blog' => $blog
        ]);
    }

    public function editTitle(Request $request)
    {
        $blog = Blog::find($request->id);
        if (!$blog) {
            return back()->with('error', 'Bài viết không tồn tại!');
        }

        if ($request->title == '') {
            return back()->with('error', 'Vui lòng nhập tiêu đề bài viết!');
        }

        $blog->title = $request->title;
        $slug = Helper::genSlug($request->title);
        $blog->slug = $slug;
        if ($request->hasFile('thumbnail')) {
            if ($blog->thumbnail && Storage::disk('public')->exists($blog->thumbnail)) {
                Storage::disk('public')->delete($blog->thumbnail);
            }
            $date = Carbon::now()->format('Ymd');
            $blog->thumbnail = $request->file('thumbnail')->store("upload/blogs/$date", 'public');
        }
        $blog->save();

        return back()->with('success', 'Chỉnh sửa tiêu đề thành công!');
    }

    public function editContent(Request $request)
    {
        $content = BlogContainer::find($request->id);
        if (!$content) {
            return back()->with('error', 'Nội dung không tồn tại!');
        }

        if ($request->title == '' || $request->content == '') {
            return back()->with('error', 'Vui lòng nhập đầy đủ thông tin!');
        }

        if ($request->hasFile('thumbnail')) {
            if ($content->thumbnail && Storage::disk('public')->exists($content->thumbnail)) {
                Storage::disk('public')->delete($content->thumbnail);
            }
            $date = Carbon::now()->format('Ymd');
            $content->thumbnail = $request->file('thumbnail')->store("upload/blogs/$date", 'public');
        }

        $content->title = $request->title;
        $content->content = $request->content;
        $content->save();

        return back()->with('success', 'Cập nhật thành công!');
    }

    public function delete(Request $request)
    {
        $blog = Blog::find($request->id);
        if (!$blog) {
            return response()->json([
                'success' => false,
                'message' => 'Bài viết không tồn tại!'
            ], 404);
        }

        if ($blog->imthumbnailage && Storage::disk('public')->exists($blog->thumbnail)) {
            Storage::disk('public')->delete($blog->thumbnail);
        }

        $blog->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xoá bài viết thành công!'
        ], 200);
    }
}