<?php

namespace App\Http\Controllers\Web\Home;

// Core
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

// Helpers
use Illuminate\Support\Facades\Auth;

// Models
use App\Models\Banner\Banner;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $banners = Banner::all()->where('status', 1);

        return view('web.pages.home', [
            'user' => $user,
            'banners' => $banners
        ]);
    }
}
