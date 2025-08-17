<?php

namespace App\Http\Controllers\Web\Search;

use Illuminate\Http\Request;

class SearchController
{
    public function index()
    {
        return view('web.pages.search-result');
    }
}
