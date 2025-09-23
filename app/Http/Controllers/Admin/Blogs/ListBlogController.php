<?php

namespace App\Http\Controllers\Admin\Blogs;

// Core
use Illuminate\Routing\Controller;

// Helpers
use Illuminate\Support\Facades\Auth;

// Models
use App\Models\Blog\Blog;
use App\Models\Blog\BlogContainer;

class ListBlogController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('admin.pages.blogs.list-blog', [
            'user' => $user
        ]);
    }
}