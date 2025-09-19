{{-- Lịch sử mua hàng --}}
<div class="card shadow-sm p-2">
    <div class="d-flex align-items-center">
        <h5 class="pt-2 ps-2">Lịch sử mua hàng</h5>
    </div>
    <form id="filterForm" method="GET" action="#">
        <div class="row mb-3">
            @csrf
            <!-- Lọc trạng thái đơn hàng -->
            <div class="col-md-4">
                <label for="status" class="form-label">Trạng thái đơn hàng</label>
                <select name="status" class="form-select auto-submit">
                    <option value="">-- Tất cả --</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Đang xử lý
                    </option>
                    <option value="shipping" {{ request('status') == 'shipping' ? 'selected' : '' }}>Đang giao hàng
                    </option>
                    <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Đã giao</option>
                    <option value="cancel" {{ request('status') == 'cancel' ? 'selected' : '' }}>Đã hủy</option>
                </select>
            </div>

            <!-- Lọc theo khoảng ngày -->
            <div class="col-md-4">
                <label for="date_from" class="form-label">Từ ngày</label>
                <input type="date" name="date_from" id="date_from" class="form-control"
                    value="{{ request('date_from') }}">
            </div>

            <div class="col-md-4">
                <label for="date_to" class="form-label">Đến ngày</label>
                <input type="date" name="date_to" id="date_to" class="form-control"
                    value="{{ request('date_to') }}">
            </div>
        </div>

        <div class="row">
            <div class="col text-end">
                <button type="button" id="btn-fillter" class="btn btn-primary w-25">
                    <i class="bi bi-funnel"></i>
                    Lọc</button>
            </div>
        </div>
    </form>

    <div class="p-2 mt-2">
        <!-- Đơn hàng -->
        <div class="card">
            @forelse($orders as $item)
                @foreach ($item->orderItems as $variant)
                    <div class="d-flex pt-2 pb-2">
                        <img src="{{ asset('storage/' . $variant->hasVariant->thumbnail) }}"
                            class="rounded me-3 img-fluid" style="max-width:80px; object-fit:contain;" alt="watch" />
                        <div class="flex-grow-1">
                            <div><strong>Đơn hàng: #{{ $variant->order->order_code }}</strong></div>
                            <div class="text-muted small">Ngày đặt hàng: {{ $variant->order->created_at }}</div>
                            <div class="fw-bold">{{ $variant->product_name }}</div>
                            <div>
                                <span
                                    class="fw-bold text-danger">{{ number_format($variant->price, 0, ',', '.') }}</span>
                                <span
                                    class="text-muted text-decoration-line-through small">{{ number_format($variant->hasVariant->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="text-end">
                            @if ($variant->order->status == 'processing')
                                <span class="badge bg-light text-warning">Đang xử lý</span>
                            @elseif($variant->order->status == 'shipping')
                                <span class="badge bg-light text-primary">Đang giao</span>
                            @elseif($variant->order->status == 'success')
                                <span class="badge bg-light text-success">Đã giao</span>
                            @elseif($variant->order->status == 'cancel')
                                <span class="badge bg-light text-danger">Đã hủy</span>
                            @endif
                            <div class="fw-bold text-danger"><span class="text-dark small">Tổng thanh toán:
                                </span>{{ number_format($variant->price, 0, ',', '.') }}</div>
                            @if ($item->bill)
                                <a href="{{ asset($item->bill->path) }}" target="_blank"
                                    class="small text-decoration-none">Xem chi tiết
                                    <i class="bi bi-chevron-right"></i></a>
                            @else
                                <a href="javascript:void(0);" class="small text-decoration-none text-muted"
                                    onclick="new bootstrap.Toast(document.getElementById('invoiceToast')).show();">
                                    Xem chi tiết <i class="bi bi-chevron-right"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            @empty
                <div class="text-center p-5">
                    <i class="bi bi-bag-x fs-1 text-muted"></i>
                    <p class="mt-3 mb-0 text-muted">Bạn chưa có đơn hàng nào</p>
                    <a href="{{ route('home.index') }}" class="btn btn-primary btn-sm mt-3">
                        Mua sắm ngay
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Phân trang --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $orders->onEachSide(1)->links() }}
    </div>
</div>

<div class="position-fixed top-0 end-0 p-4" style="z-index: 9999">
    <div id="invoiceToast" class="toast text-bg-warning border-0 fs-6" role="alert" aria-live="assertive"
        aria-atomic="true" data-bs-delay="3000" data-bs-autohide="true">
        <div class="d-flex">
            <div class="toast-body">
                <div class="fw-bold mb-1">Thông báo! <i class="bi bi-bell"></i></div>
                <div class="small text-dark">Hóa đơn chưa được tạo</div>
            </div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Đóng"></button>
        </div>
    </div>
</div>
