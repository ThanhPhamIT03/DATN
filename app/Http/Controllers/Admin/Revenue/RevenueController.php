<?php

namespace App\Http\Controllers\Admin\Revenue;

// Core
use Illuminate\Routing\Controller;

// Helpers
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// Models
use App\Models\Order\OrderItem;
use App\Models\User;
use App\Models\Order\Order;

class RevenueController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $salesByMonth = OrderItem::selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('total', 'month');

        $salesData = [];
        for ($m = 1; $m <= 12; $m++) {
            $salesData[] = $salesByMonth[$m] ?? 0;
        }

        $newCustomers = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $oldCustomers = User::where('created_at', '<', now()->startOfMonth())->count();

        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(5)
            ->with('product')
            ->get();

        $labels = $topProducts->pluck('product.name')->toArray();
        $data = $topProducts->pluck('total_qty')->toArray();


        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // 1. Doanh thu tháng (sum quantity * price từ order_items)
        $monthlyRevenue = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'success')
            ->whereYear('orders.created_at', $currentYear)
            ->whereMonth('orders.created_at', $currentMonth)
            ->sum(DB::raw('order_items.quantity * order_items.price'));

        // 2. Số đơn hàng trong tháng
        $monthlyOrders = Order::where('status', 'success')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->count();

        // 3. Số khách hàng mua trong tháng (distinct user_id)
        $monthlyCustomers = Order::where('status', 'success')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->distinct('user_id')
            ->count('user_id');

        // 4. AOV – giá trị trung bình / đơn
        $avgOrderValue = $monthlyOrders > 0 ? $monthlyRevenue / $monthlyOrders : 0;

        return view('admin.pages.revenue.revenue', [
            'user' => $user,
            'salesData' => $salesData,
            'customerData' => [
                'new' => $newCustomers,
                'old' => $oldCustomers,
            ],
            'labels' => $labels,
            'data' => $data,
            'monthlyRevenue' => $monthlyRevenue,
            'monthlyOrders' => $monthlyOrders,
            'monthlyCustomers' => $monthlyCustomers,
            'avgOrderValue' => $avgOrderValue
        ]);
    }

    public function export()
    {

    }
}