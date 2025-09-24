@extends('admin.layouts.master')

@section('title', 'Thống kê doanh số')

@section('script')
    <script type="module">
        // Biểu đồ doanh số theo tháng
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: [
                    'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4',
                    'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8',
                    'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
                ],
                datasets: [{
                    label: 'Doanh số (VNĐ)',
                    data: [12000000, 15000000, 8000000, 20000000, 25000000,
                        30000000, 18000000, 22000000, 27000000,
                        32000000, 28000000, 35000000
                    ],
                    borderColor: 'rgba(78, 115, 223, 1)',
                    backgroundColor: 'rgba(78, 115, 223, 0.1)',
                    tension: 0.3,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: 'rgba(78, 115, 223, 1)'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => value.toLocaleString('vi-VN') + ' đ'
                        }
                    }
                }
            }
        });

        // Biểu đồ tỷ lệ khách hàng
        const customerCtx = document.getElementById('customerChart').getContext('2d');
        new Chart(customerCtx, {
            type: 'pie',
            data: {
                labels: ['Khách hàng mới', 'Khách hàng cũ'],
                datasets: [{
                    data: [350, 650],
                    backgroundColor: [
                        'rgba(28, 200, 138, 0.8)',
                        'rgba(54, 185, 204, 0.8)'
                    ]
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Biểu đồ top sản phẩm
        const productCtx = document.getElementById('topProductChart').getContext('2d');
        new Chart(productCtx, {
            type: 'bar',
            data: {
                labels: ['Sản phẩm A', 'Sản phẩm B', 'Sản phẩm C', 'Sản phẩm D', 'Sản phẩm E'],
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: [50000000, 35000000, 28000000, 15000000, 10000000],
                    backgroundColor: 'rgba(255, 193, 7, 0.8)'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => value.toLocaleString('vi-VN') + ' đ'
                        }
                    }
                }
            }
        });
    </script>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Thống kê</a></li>
    <li class="breadcrumb-item" aria-current="page">Thống kê doanh số</li>
@stop

@section('content')
    <div class="container mt-3 pb-4">
        <h3 class="mb-4">Thống kê doanh số</h3>

        {{-- Bộ lọc thời gian --}}
        <form method="GET" action="" class="row g-3 mb-4">
            <div class="col-md-3">
                <label class="form-label">Từ ngày</label>
                <input type="date" name="from" class="form-control" value="{{ request('from') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Đến ngày</label>
                <input type="date" name="to" class="form-control" value="{{ request('to') }}">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-funnel me-2"></i>Lọc</button>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <a href="{{ route('admin.revenue.export', ['from' => request('from'), 'to' => request('to')]) }}"
                    class="btn btn-success w-100">
                    <i class="bi bi-file-earmark-excel"></i> Xuất báo cáo
                </a>
            </div>
        </form>

        {{-- Các chỉ số tổng hợp --}}
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <h6 class="card-title">Doanh thu</h6>
                        <h4 class="fw-bold text-success">120.000.000 đ</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <h6 class="card-title">Đơn hàng</h6>
                        <h4 class="fw-bold text-primary">10</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <h6 class="card-title">Khách hàng</h6>
                        <h4 class="fw-bold text-info">8</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <h6 class="card-title">AOV (Giá trị TB/đơn)</h6>
                        <h4 class="fw-bold text-warning">12.000.000đ</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Biểu đồ doanh số + đơn hàng --}}
        <div class="row g-4">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header">Doanh số theo tháng</div>
                    <div class="card-body">
                        <canvas id="salesChart" height="150"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header">Tỷ lệ khách hàng</div>
                    <div class="card-body">
                        <canvas id="customerChart" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Top sản phẩm --}}
        <div class="row g-4 mt-3">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header">Top sản phẩm bán chạy</div>
                    <div class="card-body">
                        <canvas id="topProductChart" height="120"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
