<?php

namespace App\Http\Controllers\Admin\Blogs;

// Core
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

// Helpers
use Illuminate\Support\Facades\Auth;

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