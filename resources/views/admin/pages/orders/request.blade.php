@extends('admin.layouts.master')

@section('title', 'Yêu cầu hủy đơn')

@section('script')
    <script type="module">
        $(document).ready(function() {
            // Show info
            $('.show-info-btn').click(function() {
                var info = $(this).data('info');
                var prettyInfo = JSON.stringify(info, null, 4);
                $('#categoryInfoJson').text(prettyInfo);
                var modal = new bootstrap.Modal(document.getElementById('showInfoModal'));
                modal.show();
            });

            // Xử lý ô input
            var $input = $('#orderCodeInput');
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
                $('#orderCodeForm').submit();
            });

            // Xử lý phần filter
            $(document).ready(function() {
                $('.auto-submit').on('change', function() {
                    $('#filterForm').submit();
                });
            });

            // Xử lý phần trạng thái xử lý
            $('.request-status').change(function() {
                $.ajax({
                    url: "{{ route('admin.order.request.status') }}",
                    type: "POST",
                    data: {
                        id: $(this).data('id'),
                        status: $(this).val(),
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire('Thành công', res.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Thất bại', res.message, 'error').then(() => {
                                location.reload();
                            });
                        }
                    },
                    error: function() {
                        Swal.fire('Lỗi', 'Không thể cập nhật trạng thái!', 'error');
                    }
                });
            });

            // Bấm vào nút xem chi tiết
            $(document).on('click', '.btn-detail', function() {
                let reason = $(this).data('reason');
                let customerName = $(this).data('customer_name');
                let customerPhone = $(this).data('customer_phone');
                let customerEmail = $(this).data('customer_email');
                let customerAddress = $(this).data('customer_address');
                let orderItems = $(this).data('order_items');

                $('#reason').text(reason);
                $('#customerName').text(customerName);
                $('#customerPhone').text(customerPhone);
                $('#customerEmail').text(customerEmail);
                $('#customerAddress').text(customerAddress);

                let total = orderItems.reduce((sum, item) => {
                    return sum + Number(item.total_price);
                }, 0);
                $('#total').text(Number(total).toLocaleString() + ' đ');

                let container = $("#orderItems");
                container.empty();

                orderItems.forEach(item => {
                    container.append(`
                    <div class="card mb-2">
                        <div class="card-body">
                            <h6 class="card-title">${item.product_name}</h6>
                            <p class="card-text mb-1">Phiên bản: <strong>${item.variant.ram}/${item.variant.rom} - ${item.variant.color}</strong></p>
                            <p class="card-text mb-1">Số lượng: <strong>${item.quantity}</strong></p>
                            <p class="card-text mb-1">Đơn giá: ${Number(item.price).toLocaleString()} đ</p>
                            <p class="card-text">Thành tiền: <strong>${Number(item.total_price).toLocaleString()} đ</strong></p>
                        </div>
                    </div>
                `);
                });

                let myModal = new bootstrap.Modal(document.getElementById('reasonModal'));
                myModal.show();
            });

        });
    </script>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.order.list.index') }}">Đơn hàng</a></li>
    <li class="breadcrumb-item" aria-current="page">Yêu cầu hủy đơn</li>
@stop

@section('content')
    <div class="container mt-2 pb-4">
        <h3 class="mb-4">
            Yêu cầu hủy đơn
        </h3>

        {{-- Form tìm kiếm theo mã đơn hàng --}}
        <form id="orderCodeForm" method="GET" action="#">
            <div class="row mb-3">
                <div class="col-md-3 input-clear-wrapper">
                    <input type="text" name="order_code" id="orderCodeInput" class="form-control"
                        placeholder="Tìm theo mã đơn hàng..." value="{{ request('order_code') }}">
                    <button type="button" class="clear-btn">&times;</button>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
                </div>
            </div>
        </form>

        <form id="filterForm" method="GET" action="#">
            <div class="row mb-3">
                <!-- Lọc theo trạng thái xác nhận -->
                <div class="col-md-4">
                    <label for="status" class="form-label">Trạng thái xác nhận</label>
                    <select name="status" class="form-select auto-submit">
                        <option value="">-- Tất cả --</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Đã xác nhận
                        </option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Đã từ chối</option>
                    </select>
                </div>
            </div>
        </form>

        {{-- Bảng danh sách các yêu cầu --}}
        <table class="table table-bordered table-striped align-middle mt-4">
            <thead class="table-dark">
                <tr>
                    <th style="text-align: center;" scope="col">Mã đơn hàng</th>
                    <th style="text-align: center;" scope="col">Thông tin khách hàng</th>
                    <th style="text-align: center;" scope="col">Lý do hủy đơn</th>
                    <th style="text-align: center;" scope="col">Trạng thái xác nhận</th>
                    <th style="text-align: center;" scope="col">Thông tin chi tiết</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $request)
                    <tr>
                        <td class="text-center text-truncate" style="max-width: 200px;">
                            {{ $request->order_code }}
                        </td>
                        <td style="text-align: center">
                            <button type="button" class="btn btn-sm btn-primary show-info-btn"
                                data-info='@json($request->order->customer_info)'>
                                <i class="bi bi-info-circle-fill"></i>
                            </button>
                        </td>
                        <td
                            style="max-width:200px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; text-align:center;">
                            {{ $request->reason }}
                        </td>
                        <td style="text-align: center;">
                            <select class="form-select form-select-sm request-status" data-id="{{ $request->id }}">
                                <option value="pending" {{ $request->status == 'pending' ? 'selected' : '' }}>Chờ xác nhận
                                </option>
                                <option value="approved" {{ $request->status == 'approved' ? 'selected' : '' }}>Xác nhận
                                </option>
                                <option value="rejected" {{ $request->status == 'rejected' ? 'selected' : '' }}>Từ chối
                                </option>
                            </select>
                        </td>
                        <td style="text-align: center;">
                            <button type="button" class="btn btn-sm btn-primary btn-detail"
                                data-customer_name="{{ $request->order->customer_info['customer_name'] }}"
                                data-customer_phone="{{ $request->order->customer_info['customer_phone'] }}"
                                data-customer_email="{{ $request->user->email }}"
                                data-customer_address="{{ $request->order->customer_info['customer_address'] }}"
                                data-order_items='@json($request->order->orderItems)' data-reason="{{ $request->reason }}">
                                Xem chi tiết
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-danger">Không có dữ liệu</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Modal User Info -->
        <div class="modal fade" id="showInfoModal" tabindex="-1" aria-labelledby="showInfoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="showInfoModalLabel">Thông tin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <pre id="categoryInfoJson" style="white-space: pre-wrap;"></pre>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="reasonModal" tabindex="-1" aria-labelledby="reasonModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reasonModalLabel">Chi tiết yêu cầu hủy đơn</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body" id="reasonModalBody">
                        <!-- Thông tin khách hàng -->
                        <h6 class="mb-3">Thông tin khách hàng</h6>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="card-title">Khách hàng</h6>
                                <p class="card-text mb-1">Tên khách hàng: <strong id="customerName"></strong></p>
                                <p class="card-text mb-1">Số điện thoại: <strong id="customerPhone"></strong></p>
                                <p class="card-text mb-1">Email: <strong id="customerEmail"></strong></p>
                                <p class="card-text">Địa chỉ: <strong id="customerAddress"></strong></p>
                            </div>
                        </div>
                        <!-- Thông tin đơn hàng -->
                        <h6 class="mt-4 mb-3">Thông tin đơn hàng</h6>
                        <div id="orderItems"></div>

                        {{-- Tổng tiền đơn hàng --}}
                        <div class="d-flex align-items-center justify-content-between">
                            <h4 class="mt-4 mb-3 text-primary">Tổng tiền:</h4>
                            <strong id="total" class="mb-0 text-danger"></strong>
                        </div>

                        {{-- Lý do hủy đơn --}}
                        <h6 class="mt-4 mb-3">Lý do hủy đơn</h6>
                        <div class="card mb-3">
                            <div class="card-body">
                                <strong id="reason"></strong>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>

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
