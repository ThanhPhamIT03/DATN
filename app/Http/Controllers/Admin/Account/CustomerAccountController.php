<?php

namespace App\Http\Controllers\Admin\Account;

// Core
use Illuminate\Routing\Controller;

// Helpers
use Illuminate\Support\Facades\Auth;

class CustomerAccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('admin.pages.account.customer', [
            'user' => $user
        ]);
    }
}