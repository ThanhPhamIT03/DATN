@extends('web.layouts.master-empty')

@section('script')
    <script type="module"></script>
@stop

@section('title', 'Thông tin cá nhân')

@section('content')
    <div class="container-xl mt-4">
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

        <div class="row">
            <div class="col-md-4">

            </div>
            <div class="col-md-8">
                
            </div>
        </div>
    </div>
    <style>
        .usr-name {
            color: var(--text-heading-color);
            font-weight: 600;
        }
        .usr-phone {
            font-size: 14px;
            font-weight: 500;
            color: #666;
        }
        .usr-role {
            background-color: var(--primary-color);
            width: 60%;
            text-align: center;
            border-radius: 8px;
            color: #fff;
            padding: 2px 0;
            font-weight: 600;
            font-size: 14px;
        }
    </style>
@stop
