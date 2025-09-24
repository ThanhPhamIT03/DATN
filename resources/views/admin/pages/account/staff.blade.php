@extends('admin.layouts.master')

@section('title', 'Quản lý tài khoản nhân viên')

@section('script')
    <script type="module">
        $(document).ready(function() {
            // Xử lý ô tìm kiếm
            var $input = $('#keywordInput');
            var $clear = $('.clear-btn');

            function toggleClear() {
                if ($input.val().length > 0) {
                    $clear.show();
                } else {
                    $clear.hide();
                }
            }

            toggleClear();

            $input.on('input', toggleClear);

            $clear.click(function() {
                $input.val('');
                $clear.hide();
                $input.focus();
                $('#keywordForm').submit();
            });

            // Thu hồi quyền
            $(document).on('click', '.btn-remove-permission', function() {
                let id = $(this).data('id');
                let url = $(this).data('url');

                Swal.fire({
                    title: "Bạn có chắc muốn thu hồi quyền của nhân viên này?",
                    text: "Hành động này không thể hoàn tác!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#6c757d",
                    confirmButtonText: "Thu hồi",
                    cancelButtonText: "Huỷ"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            method: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id
                            },
                            success: function(res) {
                                if (res.success) {
                                    Swal.fire("Đã thu hồi!", res.message, "success").then(
                                        () => {
                                            location.reload();
                                        });
                                } else {
                                    Swal.fire("Lỗi", res.message, "error");
                                }
                            },
                            error: function() {
                                Swal.fire("Lỗi", "Lỗi hệ thống!", "error");
                            }
                        });
                    }
                });
            });
        });
    </script>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Quản lý tài khoản</a></li>
    <li class="breadcrumb-item" aria-current="page">Tài khoản nhân viên</li>
@stop

@section('content')
    <div class="container mt-2 pb-4 d-flex justify-content-between align-items-center">
        <h3 class="mb-4">Quản lý tài khoản nhân viên</h3>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addStaffModal">
            <i class="bi bi-person-plus"></i> Thêm nhân viên
        </button>
    </div>

    {{-- Form tìm kiếm --}}
    <form id="keywordForm" method="GET" action="{{ route('admin.account.staff.index') }}">
        <div class="row mb-3">
            <div class="col-md-4 input-clear-wrapper">
                <input type="text" name="keyword" id="keywordInput" class="form-control"
                    placeholder="Tìm theo mã nhân viên..." value="{{ request('keyword') }}">
                <button type="button" class="clear-btn">&times;</button>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i>
                    Tìm kiếm</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th style="text-align: center;" scope="col">Mã nhân viên</th>
                <th style="text-align: center;" scope="col">Họ tên</th>
                <th style="text-align: center;" scope="col">Số điện thoại</th>
                <th style="text-align: center;" scope="col">Email</th>
                <th style="text-align: center;" scope="col" style="width: 150px;">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($staffs as $staff)
                <tr>
                    <td class="text-center">{{ $staff->code ?? 'N/A' }}</td>
                    <td class="text-center">{{ $staff->name ?? 'N/A' }}</td>
                    <td class="text-center">{{ $staff->phone ?? 'N/A' }}</td>
                    <td class="text-center">{{ $staff->email ?? 'N/A' }}</td>
                    <td class="text-center">
                        <button type="button" data-id="{{ $staff->id }}"
                            data-url="{{ route('admin.account.staff.remove') }}"
                            class="btn btn-sm btn-danger btn-remove-permission">Gỡ quyền</button>
                    </td>
                </tr>
            @empty
                <td colspan="5" class="text-center text-danger">Không có nhân viên!</td>
            @endforelse
        </tbody>
    </table>

    <!-- Modal Thêm nhân viên -->
    <div class="modal fade" id="addStaffModal" tabindex="-1" aria-labelledby="addStaffModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addStaffModalLabel">
                        <i class="bi bi-person-plus"></i> Thêm nhân viên mới
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Đóng"></button>
                </div>
                <form action="{{ route('admin.account.staff.add') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Họ tên</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="text" name="phone" id="phone" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">Mật khẩu</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Phân trang --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $staffs->onEachSide(1)->links() }}
    </div>

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
