@extends('web.layouts.master-empty')

@section('script')
    {{-- <script type="module">
        
    </script> --}}
    <script src="{{ asset('./js/profile/menu.js') }}"></script>
    <script src="{{ asset('./js/profile/history.js') }}"></script>
@stop

@section('title', 'Thông tin cá nhân')

@section('content')
    <div style="background-color: var(--bgr-gray); height: auto;">
        <div class="container-xl mt-4 pb-4">
            <div class="row g-3">
                <!-- Cột 1: Thông tin cá nhân -->
                <div class="col-md-4">
                    <div class="card shadow-sm p-2">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('images/default-avatar.png') }}" class="rounded-circle me-3 img-fluid"
                                alt="Ảnh đại diện" style="width:60px; height:60px; object-fit:cover;">
                            <div>
                                <h5 class="mb-1 usr-name">Phạm Văn Thành</h5>
                                <p class="mb-1 usr-phone">0123 456 789</p>
                                <p class="mb-1 usr-role">Thành viên</p>
                                <small class="text-muted">Cập nhật: 24/08/2025</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cột 2: Tổng số đơn hàng -->
                <div class="col-md-4">
                    <div class="card shadow-sm p-2 text-center">
                        <div class="mb-1">
                            <i class="bi bi-bag-check fs-2 text-primary"></i>
                        </div>
                        <h6 class="mb-1">Tổng đơn hàng</h6>
                        <p class="fs-5 fw-bold text-success mb-0">120</p>
                    </div>
                </div>

                <!-- Cột 3: Tổng số tiền đã chi tiêu -->
                <div class="col-md-4">
                    <div class="card shadow-sm p-2 text-center">
                        <div class="mb-1">
                            <i class="bi bi-cash-stack fs-2 text-warning"></i>
                        </div>
                        <h6 class="mb-1">Tổng chi tiêu</h6>
                        <p class="fs-5 fw-bold text-danger mb-0">50,000,000₫</p>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-4 info-menu">
                    <ul class="info-menu-list">
                        <li class="info-menu-item" id="over-view-btn">
                            <a href="#" class="info-menu-link">
                                <i class="bi bi-house me-3"></i> Tổng quan <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li class="info-menu-item" id="bought-history-btn">
                            <a href="#" class="info-menu-link">
                                <i class="bi bi-cart me-3"></i> Lịch sử mua hàng <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li class="info-menu-item" id="info-btn">
                            <a href="#" class="info-menu-link">
                                <i class="bi bi-person me-3"></i> Thông tin cá nhân <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li class="info-menu-item" id="warranty-btn">
                            <a href="#" class="info-menu-link">
                                <i class="bi bi-search me-3"></i> Tra cứu bảo hành <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li class="info-menu-item" id="warranty-policy-btn">
                            <a href="#" class="info-menu-link">
                                <i class="bi bi-shield-check me-3"></i> Chính sách bảo hành <i
                                    class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li class="info-menu-item" id="support-btn">
                            <a href="#" class="info-menu-link">
                                <i class="bi bi-chat-dots me-3"></i> Góp ý - Phản hồi - Hỗ trợ <i
                                    class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li class="info-menu-item" id="policy-btn">
                            <a href="#" class="info-menu-link">
                                <i class="bi bi-file-earmark-text me-3"></i> Điều khoản sử dụng <i
                                    class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li class="info-menu-item logout-item">
                            <!-- Logout bằng form -->
                            <form method="POST" action="/logout" class="logout-form">
                                <button type="submit" class="info-menu-link logout-btn">
                                    <i class="bi bi-box-arrow-right me-3"></i> Đăng xuất <i class="bi bi-chevron-right"></i>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>

                <div class="col-md-8">
                    {{-- Trang tổng quan --}}
                    <div class="card shadow-sm p-2 d-block" id="over-view">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="pt-2 ps-2">Đơn hàng gần đây</h5>
                            <a href="#" class="text-decoration-none">Xem tất cả <i
                                    class="bi bi-chevron-right"></i></a>
                        </div>
                        <div class="p-2">
                            <!-- Đơn hàng -->
                            <div class="card mb-2 p-2">
                                <div class="d-flex">
                                    <img src="{{ asset('./images/iphone-16-pro-max.webp') }}" class="rounded me-3 img-fluid"
                                        style="max-width:80px; object-fit:contain;" alt="watch" />
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
                                        <span class="badge bg-light text-warning">Đang giao</span>
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
                                        <span class="badge bg-light text-success">Đã giao</span>
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
                                        <span class="badge bg-light text-success">Đã giao</span>
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
                                        <span class="badge bg-light text-success">Đã giao</span>
                                        <div class="fw-bold text-danger"><span class="text-dark small">Tổng thanh toán:
                                            </span>655.000đ</div>
                                        <a href="#" class="small text-decoration-none">Xem chi tiết <i
                                                class="bi bi-chevron-right"></i></a>
                                    </div>
                                </div>
                            </div>

                            <!-- Thêm nhiều đơn hàng khác giống trên -->
                        </div>
                    </div>

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
                                        <span class="badge bg-light text-warning">Đang giao</span>
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
                                        <span class="badge bg-light text-success">Đã giao</span>
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
                                        <span class="badge bg-light text-success">Đã giao</span>
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
                                        <span class="badge bg-light text-success">Đã giao</span>
                                        <div class="fw-bold text-danger"><span class="text-dark small">Tổng thanh toán:
                                            </span>655.000đ</div>
                                        <a href="#" class="small text-decoration-none">Xem chi tiết <i
                                                class="bi bi-chevron-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>

    </style>
@stop
