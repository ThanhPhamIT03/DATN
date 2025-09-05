{{-- Lịch sử mua hàng --}}
<div class="card shadow-sm p-2 d-none" id="bought-history">
    <div class="d-flex align-items-center">
        <h5 class="pt-2 ps-2">Lịch sử mua hàng</h5>
    </div>
    <div class="d-flex align-items-center justify-content-center mt-3">
        <span class="status" id="status-all">Tất cả</span>
        <span class="status" id="status-processing">Đang xử lý</span>
        <span class="status" id="status-delivery">Đang giao hàng</span>
        <span class="status" id="status-delivered">Đã giao</span>
        <span class="status" id="status-cancel">Đã hủy</span>
    </div>
    <div class="d-flex align-items-center justify-content-center mt-3">
        <label for="date-from" class="me-2">Từ:</label>
        <input type="date" id="date-from" class="form-control form-control-sm w-auto">
        <label for="date-to" class="ms-3 me-2">Đến:</label>
        <input type="date" id="date-to" class="form-control form-control-sm w-auto">
        <button class="btn btn-sm btn-primary ms-3" id="filter-date">Lọc</button>
    </div>
    <div class="p-2 mt-2">
        <!-- Đơn hàng -->
        <div class="card mb-2 p-2">
            <div class="d-flex">
                <img src="{{ asset('./images/iphone-16-pro-max.webp') }}"
                    class="rounded me-3 img-fluid" style="max-width:80px; object-fit:contain;"
                    alt="watch" />
                <div class="flex-grow-1">
                    <div><strong>Đơn hàng: #WB0302766348</strong></div>
                    <div class="text-muted small">Ngày đặt hàng: 08/04/2025</div>
                    <div class="fw-bold">Đồng hồ thông minh Xiaomi Redmi Watch 5 Active - Đen</div>
                    <div>
                        <span class="fw-bold text-danger">655.000đ</span>
                        <span class="text-muted text-decoration-line-through small">890.000đ</span>
                    </div>
                </div>
                <div class="text-end">
                    <span class="badge bg-light text-danger">Đã hủy</span>
                    <div class="fw-bold text-danger"><span class="text-dark small">Tổng thanh toán:
                        </span>655.000đ</div>
                    <a href="#" class="small text-decoration-none">Xem chi tiết <i
                            class="bi bi-chevron-right"></i></a>
                </div>
            </div>
        </div>
        <div class="card mb-2 p-2">
            <div class="d-flex">
                <img src="{{ asset('./images/iphone-16-pro-max.webp') }}"
                    class="rounded me-3 img-fluid" style="max-width:80px; object-fit:contain;"
                    alt="watch" />
                <div class="flex-grow-1">
                    <div><strong>Đơn hàng: #WB0302766348</strong></div>
                    <div class="text-muted small">Ngày đặt hàng: 08/04/2025</div>
                    <div class="fw-bold">Đồng hồ thông minh Xiaomi Redmi Watch 5 Active - Đen</div>
                    <div>
                        <span class="fw-bold text-danger">655.000đ</span>
                        <span class="text-muted text-decoration-line-through small">890.000đ</span>
                    </div>
                </div>
                <div class="text-end">
                    <span class="badge bg-light text-warning">Đang xử lý</span>
                    <div class="fw-bold text-danger"><span class="text-dark small">Tổng thanh toán:
                        </span>655.000đ</div>
                    <a href="#" class="small text-decoration-none">Xem chi tiết <i
                            class="bi bi-chevron-right"></i></a>
                </div>
            </div>
        </div>
        <div class="card mb-2 p-2">
            <div class="d-flex">
                <img src="{{ asset('./images/iphone-16-pro-max.webp') }}"
                    class="rounded me-3 img-fluid" style="max-width:80px; object-fit:contain;"
                    alt="watch" />
                <div class="flex-grow-1">
                    <div><strong>Đơn hàng: #WB0302766348</strong></div>
                    <div class="text-muted small">Ngày đặt hàng: 08/04/2025</div>
                    <div class="fw-bold">Đồng hồ thông minh Xiaomi Redmi Watch 5 Active - Đen</div>
                    <div>
                        <span class="fw-bold text-danger">655.000đ</span>
                        <span class="text-muted text-decoration-line-through small">890.000đ</span>
                    </div>
                </div>
                <div class="text-end">
                    <span class="badge bg-light text-success">Đã giao hàng</span>
                    <div class="fw-bold text-danger"><span class="text-dark small">Tổng thanh toán:
                        </span>655.000đ</div>
                    <a href="#" class="small text-decoration-none">Xem chi tiết <i
                            class="bi bi-chevron-right"></i></a>
                </div>
            </div>
        </div>
        <div class="card mb-2 p-2">
            <div class="d-flex">
                <img src="{{ asset('./images/iphone-16-pro-max.webp') }}"
                    class="rounded me-3 img-fluid" style="max-width:80px; object-fit:contain;"
                    alt="watch" />
                <div class="flex-grow-1">
                    <div><strong>Đơn hàng: #WB0302766348</strong></div>
                    <div class="text-muted small">Ngày đặt hàng: 08/04/2025</div>
                    <div class="fw-bold">Đồng hồ thông minh Xiaomi Redmi Watch 5 Active - Đen</div>
                    <div>
                        <span class="fw-bold text-danger">655.000đ</span>
                        <span class="text-muted text-decoration-line-through small">890.000đ</span>
                    </div>
                </div>
                <div class="text-end">
                    <span class="badge bg-light text-info">Đang giao hàng</span>
                    <div class="fw-bold text-danger"><span class="text-dark small">Tổng thanh toán:
                        </span>655.000đ</div>
                    <a href="#" class="small text-decoration-none">Xem chi tiết <i
                            class="bi bi-chevron-right"></i></a>
                </div>
            </div>
        </div>
        <div class="card mb-2 p-2">
            <div class="d-flex">
                <img src="{{ asset('./images/iphone-16-pro-max.webp') }}"
                    class="rounded me-3 img-fluid" style="max-width:80px; object-fit:contain;"
                    alt="watch" />
                <div class="flex-grow-1">
                    <div><strong>Đơn hàng: #WB0302766348</strong></div>
                    <div class="text-muted small">Ngày đặt hàng: 08/04/2025</div>
                    <div class="fw-bold">Đồng hồ thông minh Xiaomi Redmi Watch 5 Active - Đen</div>
                    <div>
                        <span class="fw-bold text-danger">655.000đ</span>
                        <span class="text-muted text-decoration-line-through small">890.000đ</span>
                    </div>
                </div>
                <div class="text-end">
                    <span class="badge bg-light text-success">Đã giao hàng</span>
                    <div class="fw-bold text-danger"><span class="text-dark small">Tổng thanh toán:
                        </span>655.000đ</div>
                    <a href="#" class="small text-decoration-none">Xem chi tiết <i
                            class="bi bi-chevron-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>