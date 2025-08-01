<?php

namespace App\Http\Controllers\Web\Home;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('web.pages.home');
    }
}
