<?php

namespace App\Http\Controllers\Admin\Revenue;

// Core
use Illuminate\Routing\Controller;

// Helpers
use Illuminate\Support\Facades\Auth;

// Models


class RevenueController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('admin.pages.revenue.revenue', [
            'user' => $user
        ]);
    }

    public function export()
    {
        
    }
}