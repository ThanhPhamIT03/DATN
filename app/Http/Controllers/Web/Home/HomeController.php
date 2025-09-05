<?php

namespace App\Http\Controllers\Web\Home;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('web.pages.home', [
            'user' => $user,
        ]);
    }
}
