<?php

namespace App\Http\Controllers\Web\Info;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        return view('web.components.information.bought-history');
    }
}