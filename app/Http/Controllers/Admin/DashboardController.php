<?php

namespace App\Http\Controllers\Admin;

// Core
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

// Helpers
use Illuminate\Support\Facades\Auth;

// Models
use App\Models\User;
use App\Models\Products\Product;
use App\Models\Order\Order;
use App\Models\Order\OrderItem;
use App\Models\Order\OrderPending;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalCustomer = User::where('role', 'user')
            ->count();

        $totalProduct = Product::all()->count();

        $totalOrder = Order::all()->count();

        $monthSales = OrderItem::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('total_price');

        // Lấy dữ liệu ghi vào biểu đồ
        $newCustomers = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $oldCustomers = User::where('created_at', '<', now()->startOfMonth())->count();

        $salesByMonth = OrderItem::selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('total', 'month');

        $salesData = [];
        for ($m = 1; $m <= 12; $m++) {
            $salesData[] = $salesByMonth[$m] ?? 0;
        }

        return view('admin.pages.dashboard', [
            'user' => $user,
            'totalCustomer' => $totalCustomer,
            'totalProduct' => $totalProduct,
            'totalOrder' => $totalOrder,
            'monthSales' => $monthSales,
            'customerData' => [
                'new' => $newCustomers,
                'old' => $oldCustomers,
            ],
            'salesData' => $salesData,
        ]);
    }
}
