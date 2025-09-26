<?php

namespace App\Http\Controllers\Admin\Revenue;

// Core
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

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
    // public function index()
    // {
    //     $user = Auth::user();

    //     $salesByMonth = OrderItem::selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
    //         ->whereYear('created_at', now()->year)
    //         ->groupBy('month')
    //         ->pluck('total', 'month');

    //     $salesData = [];
    //     for ($m = 1; $m <= 12; $m++) {
    //         $salesData[] = $salesByMonth[$m] ?? 0;
    //     }

    //     $newCustomers = User::whereMonth('created_at', now()->month)
    //         ->whereYear('created_at', now()->year)
    //         ->count();
    //     $oldCustomers = User::where('created_at', '<', now()->startOfMonth())->count();

    //     $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_qty'))
    //         ->groupBy('product_id')
    //         ->orderByDesc('total_qty')
    //         ->take(5)
    //         ->with('product')
    //         ->get();

    //     $labels = $topProducts->pluck('product.name')->toArray();
    //     $data = $topProducts->pluck('total_qty')->toArray();


    //     $currentMonth = Carbon::now()->month;
    //     $currentYear = Carbon::now()->year;

    //     // 1. Doanh thu tháng (sum quantity * price từ order_items)
    //     $monthlyRevenue = DB::table('order_items')
    //         ->join('orders', 'order_items.order_id', '=', 'orders.id')
    //         ->where('orders.status', 'success')
    //         ->whereYear('orders.created_at', $currentYear)
    //         ->whereMonth('orders.created_at', $currentMonth)
    //         ->sum(DB::raw('order_items.quantity * order_items.price'));

    //     // 2. Số đơn hàng trong tháng
    //     $monthlyOrders = Order::where('status', 'success')
    //         ->whereYear('created_at', $currentYear)
    //         ->whereMonth('created_at', $currentMonth)
    //         ->count();

    //     // 3. Số khách hàng mua trong tháng (distinct user_id)
    //     $monthlyCustomers = Order::where('status', 'success')
    //         ->whereYear('created_at', $currentYear)
    //         ->whereMonth('created_at', $currentMonth)
    //         ->distinct('user_id')
    //         ->count('user_id');

    //     // 4. AOV – giá trị trung bình / đơn
    //     $avgOrderValue = $monthlyOrders > 0 ? $monthlyRevenue / $monthlyOrders : 0;

    //     return view('admin.pages.revenue.revenue', [
    //         'user' => $user,
    //         'salesData' => $salesData,
    //         'customerData' => [
    //             'new' => $newCustomers,
    //             'old' => $oldCustomers,
    //         ],
    //         'labels' => $labels,
    //         'data' => $data,
    //         'monthlyRevenue' => $monthlyRevenue,
    //         'monthlyOrders' => $monthlyOrders,
    //         'monthlyCustomers' => $monthlyCustomers,
    //         'avgOrderValue' => $avgOrderValue
    //     ]);
    // }
    public function index(Request $request)
    {
        $user = Auth::user();

        $from = $request->input('from');
        $to = $request->input('to');

        // Nếu có from/to thì lọc theo khoảng ngày, ngược lại giữ theo năm hiện tại
        $salesByMonthQuery = OrderItem::selectRaw('MONTH(orders.created_at) as month, SUM(order_items.total_price) as total')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'success');

        if ($from && $to) {
            $salesByMonthQuery->whereBetween('orders.created_at', [$from, $to]);
        } else {
            $salesByMonthQuery->whereYear('orders.created_at', now()->year);
        }

        $salesByMonth = $salesByMonthQuery
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $salesData = [];
        for ($m = 1; $m <= 12; $m++) {
            $salesData[] = $salesByMonth[$m] ?? 0;
        }

        // Khách hàng
        if ($from && $to) {
            $newCustomers = User::whereBetween('created_at', [$from, $to])->count();
            $oldCustomers = User::where('created_at', '<', $from)->count();
        } else {
            $newCustomers = User::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();
            $oldCustomers = User::where('created_at', '<', now()->startOfMonth())->count();
        }

        // Top sản phẩm
        $topProductsQuery = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(5)
            ->with('product');

        if ($from && $to) {
            $topProductsQuery->whereBetween('created_at', [$from, $to]);
        }

        $topProducts = $topProductsQuery->get();
        $labels = $topProducts->pluck('product.name')->toArray();
        $data = $topProducts->pluck('total_qty')->toArray();

        // Doanh thu, đơn hàng, khách hàng, AOV
        $queryOrders = Order::where('status', 'success');
        $queryOrderItems = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'success');

        if ($from && $to) {
            $queryOrders->whereBetween('created_at', [$from, $to]);
            $queryOrderItems->whereBetween('orders.created_at', [$from, $to]);
        } else {
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;

            $queryOrders->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $currentMonth);

            $queryOrderItems->whereYear('orders.created_at', $currentYear)
                ->whereMonth('orders.created_at', $currentMonth);
        }

        $monthlyRevenue = $queryOrderItems->sum(DB::raw('order_items.quantity * order_items.price'));
        $monthlyOrders = $queryOrders->count();
        $monthlyCustomers = $queryOrders->distinct('user_id')->count('user_id');
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
            'avgOrderValue' => $avgOrderValue,
            'from' => $from,
            'to' => $to,
        ]);
    }


    public function export(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $queryOrders = Order::with(['user', 'orderItems.product'])
            ->where('status', 'success');

        if ($from && $to) {
            $queryOrders->whereBetween('created_at', [$from, $to]);
        } else {
            $queryOrders->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month);
        }

        $orders = $queryOrders->get();

        $monthlyRevenue = $orders->sum(
            fn($o) => $o->orderItems->sum(fn($i) => $i->quantity * $i->price)
        );
        $monthlyOrders = $orders->count();
        $monthlyCustomers = $orders->pluck('user_id')->unique()->count();
        $avgOrderValue = $monthlyOrders > 0 ? $monthlyRevenue / $monthlyOrders : 0;

        $month = $from ? Carbon::parse($from)->format('m') : now()->month;
        $year = $from ? Carbon::parse($from)->format('Y') : now()->year;
        $filename = "revenue_report_{$year}_{$month}.csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($orders, $monthlyRevenue, $monthlyOrders, $monthlyCustomers, $avgOrderValue, $month, $year) {
            $file = fopen('php://output', 'w');

            // Thông tin tổng quan
            fputcsv($file, ["BÁO CÁO DOANH THU (Tháng $month/$year)"]);
            fputcsv($file, ["Tổng doanh thu", $monthlyRevenue]);
            fputcsv($file, ["Số lượng đơn hàng", $monthlyOrders]);
            fputcsv($file, ["Số khách hàng mua hàng", $monthlyCustomers]);
            fputcsv($file, ["AOV (Average Order Value)", $avgOrderValue]);
            fputcsv($file, []); // dòng trống

            // Danh sách đơn hàng
            fputcsv($file, ["ID", "Khách hàng", "Ngày tạo", "Tổng tiền", "Trạng thái", "Sản phẩm"]);

            foreach ($orders as $order) {
                $total = $order->orderItems->sum(fn($i) => $i->quantity * $i->price);

                // Ghép tên sản phẩm + số lượng
                $products = $order->orderItems->map(function ($item) {
                    return $item->product?->name . " x" . $item->quantity;
                })->implode(', ');

                fputcsv($file, [
                    $order->id,
                    $order->user?->name,
                    $order->created_at->format('Y-m-d'),
                    $total,
                    $order->status,
                    $products,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }


}