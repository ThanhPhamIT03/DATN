@extends('admin.layouts.master')

@section('title', 'Tổng quan | Trang quản trị')

@section('script')
    <script type="module">
        $(function() {
            // Biểu đồ doanh số theo tháng
            const salesData = @json($salesData);
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
                        data: salesData,
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
                                callback: function(value) {
                                    return value.toLocaleString('vi-VN') + ' đ';
                                }
                            }
                        }
                    }
                }
            });

            // Biểu đồ khách hàng
            const customerData = @json($customerData);
            const customerCtx = document.getElementById('customerChart').getContext('2d');
            new Chart(customerCtx, {
                type: 'pie',
                data: {
                    labels: ['Khách hàng mới', 'Khách hàng cũ'],
                    datasets: [{
                        data: [customerData.new, customerData.old],
                        backgroundColor: [
                            'rgba(28, 200, 138, 0.8)',
                            'rgba(54, 185, 204, 0.8)'
                        ],
                        borderColor: [
                            'rgba(28, 200, 138, 1)',
                            'rgba(54, 185, 204, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        });
    </script>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
    <li class="breadcrumb-item" aria-current="page">Tổng quan</li>
@stop

@section('content')

    <div class="container mt-2 pb-4">
        <h3 class="mb-4 fw-bold">Tổng quan</h3>

        <div class="row g-4">
            <!-- Cột 1: Tổng số khách hàng -->
            <div class="col-md-3 d-flex">
                <div class="card shadow-sm border-0 rounded-4 p-4 w-100 d-flex flex-column justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-primary bg-opacity-10 text-primary me-3">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-2">Tổng khách hàng</h5>
                            <p class="fs-5 mb-0 text-muted">{{ $totalCustomer }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cột 2: Tổng số sản phẩm -->
            <div class="col-md-3 d-flex">
                <div class="card shadow-sm border-0 rounded-4 p-4 w-100 d-flex flex-column justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-success bg-opacity-10 text-success me-3">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-2">Tổng sản phẩm</h5>
                            <p class="fs-5 mb-0 text-muted">{{ $totalProduct }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cột 3: Tổng số đơn hàng -->
            <div class="col-md-3 d-flex">
                <div class="card shadow-sm border-0 rounded-4 p-4 w-100 d-flex flex-column justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-warning bg-opacity-10 text-warning me-3">
                            <i class="bi bi-receipt-cutoff"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-2">Tổng đơn hàng</h5>
                            <p class="fs-5 mb-0 text-muted">{{ $totalOrder }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cột 4: Doanh số theo tháng -->
            <div class="col-md-3 d-flex">
                <div class="card shadow-sm border-0 rounded-4 p-4 w-100 d-flex flex-column justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-danger bg-opacity-10 text-danger me-3">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-2">Doanh số tháng</h5>
                            <p class="fs-5 mb-0 text-danger">{{ number_format($monthSales, 0, ',', '.') }}đ</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-2">
            <!-- Cột trái: Biểu đồ đường -->
            <div class="col-8">
                <div class="card shadow-sm border-0 rounded-4 p-4">
                    <h5 class="fw-bold mb-3">Doanh số theo tháng</h5>
                    <canvas id="salesChart" height="330"></canvas>
                </div>
            </div>

            <!-- Cột phải: Biểu đồ tròn -->
            <div class="col-4">
                <div class="card shadow-sm border-0 rounded-4 p-4">
                    <h5 class="fw-bold mb-3">Khách hàng</h5>
                    <canvas id="customerChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <style>
        .icon-box {
            width: 55px;
            height: 55px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
        }
    </style>


    @if (session('error'))
        <script>
            window.LaravelSwalMessage = {
                type: 'error',
                message: '{{ session('error') }}'
            };
        </script>
    @endif

    @if (session('success'))
        <script>
            window.LaravelSwalMessage = {
                type: 'success',
                message: '{{ session('success') }}'
            };
        </script>
    @endif
@stop
