<div class="row g-3 align-items-stretch">
    <!-- Cột 1: Thông tin cá nhân -->
    <div class="col-md-4">
        <div class="card shadow-sm p-2 h-100">
            <div class="d-flex align-items-center">
                <img src="{{ asset('images/default-avatar.png') }}" class="rounded-circle me-3 img-fluid"
                    alt="Ảnh đại diện" style="width:80px; height:80px; object-fit:cover;">
                <div>
                    <h5 class="mb-1 usr-name">{{ $user->name }}</h5>
                    <p class="mb-1 usr-phone">{{ $user->phone }}</p>
                    <p class="mb-1 usr-phone">Mã KH: <span class="text-danger">{{ $user->code }}</span></p>
                    <p class="mb-1 usr-role">{{ $user->role }}</p>
                    <small class="text-muted">Cập nhật: {{ $user->created_at }}</small>
                    <br>
                    <a href="{{ route('home.index') }}" class="btn btn-outline-primary mt-4">
                        <i class="bi bi-arrow-left"></i> Trở về trang mua hàng
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Cột 2: Tổng số đơn hàng -->
    <div class="col-md-4">
        <div class="card shadow-sm p-2 text-center h-100 d-flex flex-column justify-content-center">
            <div class="mb-1">
                <i class="bi bi-bag-check fs-1 text-primary"></i>
            </div>
            <h6 class="mb-1">Tổng đơn hàng</h6>
            <p class="fs-5 fw-bold text-success mb-0">{{ $user->orders->count() }}</p>
        </div>
    </div>

    <!-- Cột 3: Tổng số tiền đã chi tiêu -->
    <div class="col-md-4">
        <div class="card shadow-sm p-2 text-center h-100 d-flex flex-column justify-content-center">
            <div class="mb-1">
                <i class="bi bi-cash-stack fs-1 text-warning"></i>
            </div>
            <h6 class="mb-1">Tổng chi tiêu</h6>
            @php
                $totalPrice = 0;
                foreach ($user->orders as $order) {
                    foreach ($order->orderItems as $item) {
                        $totalPrice += $item->total_price;
                    }
                }
            @endphp
            <p class="fs-5 fw-bold text-danger mb-0">{{ number_format($totalPrice, 0, ',', '.') }}đ</p>
        </div>
    </div>
</div>
