@extends('web.layouts.master-empty')

@section('script')
    <script type="module"></script>
@stop

@section('title', 'Thông tin cá nhân')

@section('content')
    <div style="background-color: var(--bgr-gray); height: 100vh;">
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
                        <li class="info-menu-item active">
                            <a href="#" class="info-menu-link active">
                                <i class="bi bi-house me-3"></i> Tổng quan <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li class="info-menu-item">
                            <a href="#" class="info-menu-link">
                                <i class="bi bi-cart me-3"></i> Lịch sử mua hàng <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li class="info-menu-item">
                            <a href="#" class="info-menu-link">
                                <i class="bi bi-person me-3"></i> Thông tin cá nhân <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li class="info-menu-item">
                            <a href="#" class="info-menu-link">
                                <i class="bi bi-search me-3"></i> Tra cứu bảo hành <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li class="info-menu-item">
                            <a href="#" class="info-menu-link">
                                <i class="bi bi-shield-check me-3"></i> Chính sách bảo hành <i
                                    class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li class="info-menu-item">
                            <a href="#" class="info-menu-link">
                                <i class="bi bi-chat-dots me-3"></i> Góp ý - Phản hồi - Hỗ trợ <i
                                    class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li class="info-menu-item">
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

                </div>
            </div>
        </div>
    </div>
    <style>

    </style>
@stop
