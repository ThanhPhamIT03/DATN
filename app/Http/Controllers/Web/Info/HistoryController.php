<?php

namespace App\Http\Controllers\Web\Info;

// Core
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

// Helpers
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

// Models
use App\Models\Order\Order;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Order::orderBy('created_at', 'desc');

        if($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if($request->filled('date_from') && $request->filled('date_to')) {
            $dateFrom = Carbon::parse($request->date_from)->startOfDay();
            $dateTo = Carbon::parse($request->date_to)->endOfDay();
            $query->whereBetween('created_at', [$dateFrom, $dateTo]);
        }

        $orders = $query->paginate(5)->withQueryString();

        return view('web.pages.information.buy-history', [
            'user' => $user,
            'orders' => $orders
        ]);
    }
}