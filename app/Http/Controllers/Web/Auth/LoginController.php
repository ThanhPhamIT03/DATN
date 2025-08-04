<?php

namespace App\Http\Controllers\Web\Auth;

use Illuminate\Http\Request;

class LoginController
{
    public function index()
    {
        return view('web.pages.login');
    }
}
