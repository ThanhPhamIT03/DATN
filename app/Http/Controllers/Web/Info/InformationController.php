<?php

namespace App\Http\Controllers\Web\Info;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class InformationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('web.pages.information', [
            'user' => $user
        ]);
    }

    public function add(Request $request)
    {
        dd($request->json());
    }
}