<?php

namespace App\Http\Controllers\Web\Info;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function index()
    {
        return view('web.pages.information');
    }

    public function add(Request $request)
    {
        dd($request->json());
    }
}