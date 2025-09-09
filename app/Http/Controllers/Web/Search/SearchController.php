<?php

namespace App\Http\Controllers\Web\Search;

// Core
use Illuminate\Http\Request;

// Helpers
use Illuminate\Support\Facades\Auth;

// Models
use App\Models\Category\Category;


class SearchController
{
    public function index()
    {
        $user = Auth::user();
        $categories = Category::all()->where('status', 1);

        return view('web.pages.search-result', [
            'user' => $user,
            'categories' => $categories
        ]);
    }
}
