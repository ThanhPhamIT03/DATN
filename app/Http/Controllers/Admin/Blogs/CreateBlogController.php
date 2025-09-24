<?php

namespace App\Http\Controllers\Admin\Blogs;

// Core
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

// Helpers
use Illuminate\Support\Facades\Auth;
use App\Http\Helpers\Helper;
use Carbon\Carbon;

// Models
use App\Models\Blog\Blog;
use App\Models\Blog\BlogContainer;

class CreateBlogController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('admin.pages.blogs.create-blog', [
            'user' => $user
        ]);
    }

    public function add(Request $request)
    {
        $user = Auth::user();

        $newBlog = new Blog();
        $newBlog->author = $user->name;
        $newBlog->title = $request->title;

        $slug = Helper::genSlug($request->title);
        $newBlog->slug = $slug;

        $date = Carbon::now()->format('Ymd');
        $path = null;
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store("upload/blogs/$date", 'public');
        }
        $newBlog->thumbnail = $path;
        $newBlog->save();

        if ($request->filled('blocks')) {
            foreach ($request->blocks as $index => $item) {
                $newBlock = new BlogContainer();
                $newBlock->new_id = $newBlog->id;
                $newBlock->title = $item['title'] ?? null;
                $newBlock->content = $item['content'] ?? null;

                $path = null;
                if ($request->hasFile("blocks.$index.image")) {
                    $path = $request->file("blocks.$index.image")
                        ->store("upload/blogs/$date", 'public');
                }

                $newBlock->thumbnail = $path;
                $newBlock->save();
            }
        }

        return back()->with('success', 'Thêm bài viết thảnh công!');

    }
}