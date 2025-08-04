<?php

namespace App\Http\Controllers\Web\Auth;

use Illuminate\Http\Request;

class RegisterController
{
    public function index()
    {
        return view('web.pages.register');
    }
}
