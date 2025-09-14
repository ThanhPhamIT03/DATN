@extends('admin.layouts.master')

@section('title', 'Danh sách đơn hàng')

@section('script')
    <script type="module">
        // Show info của sản phẩm
        $('.show-info-btn').click(function() {
            var info = $(this).data('info');
            var prettyInfo = JSON.stringify(info, null, 4);
            $('#categoryInfoJson').text(prettyInfo);
            var modal = new bootstrap.Modal(document.getElementById('showInfoModal'));
            modal.show();
        });

        // Trạng thái đơn hàng
        $('.order-status').change(function() {
            $.ajax({
                url: "{{ route('admin.order.list.status') }}",
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

        // Xử lý ô tìm kiếm
        $(document).ready(function() {
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
        });

        // Xử lý phần filter
        $(document).ready(function() {
            $('.auto-submit').on('change', function() {
                $('#filterForm').submit();
            });
        });

        // Xử lý nút Xem chi tiết
        $(document).ready(function() {
            $('.detail-order').on('click', function(e) {
                e.preventDefault();

                var productId = $(this).data('id');
                var detailUrl = $(this).data('detail');

                window.location.href = detailUrl + '?id=' + productId;
            });
        });
    </script>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Đơn hàng</a></li>
    <li class="breadcrumb-item" aria-current="page">Danh sách đơn hàng</li>
@stop

@section('content')
    <div class="container mt-2 pb-4">
        <h3 class="mb-4">
            Danh sách đơn hàng
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

        {{-- Bộ lọc  --}}
        <form id="filterForm" method="GET" action="#">
            <div class="row mb-3">
                <!-- Lọc theo phương thức thanh toán -->
                <div class="col-md-4">
                    <label for="payment_method" class="form-label">Phương thức thanh toán</label>
                    <select name="payment_method" class="form-select auto-submit">
                        <option value="">-- Tất cả --</option>
                        <option value="cod" {{ request('payment_method') == 'cod' ? 'selected' : '' }}>Thanh toán khi
                            nhận hàng</option>
                        <option value="online" {{ request('payment_method') == 'online' ? 'selected' : '' }}>Thanh toán
                            Online</option>
                    </select>
                </div>

                {{-- Lọc theo trạng thái đơn hàng --}}
                <div class="col-md-4">
                    <label for="status" class="form-label">Trạng thái đơn hàng</label>
                    <select name="status" class="form-select auto-submit">
                        <option value="">-- Tất cả --</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Đang xử lý
                        </option>
                        <option value="shipping" {{ request('status') == 'shipping' ? 'selected' : '' }}>Đang giao
                        </option>
                        <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Đã giao</option>
                        <option value="cancel" {{ request('status') == 'cancel' ? 'selected' : '' }}>Đã huỷ</option>
                    </select>
                </div>
            </div>
        </form>

        {{-- Bảng danh sách đơn hàng --}}
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th style="text-align: center;" scope="col">Mã đơn hàng</th>
                    <th style="text-align: center;" scope="col">Tên khách hàng</th>
                    <th style="text-align: center;" scope="col">Thông tin khách hàng</th>
                    <th style="text-align: center;" scope="col">Phương thức thanh toán</th>
                    <th style="text-align: center;" scope="col">Trạng thái đơn hàng</th>
                    <th style="text-align: center;" scope="col">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td class="text-center text-truncate" style="max-width: 200px;">
                            {{ $order->order_code }}
                        </td>
                        <td style="text-align: center;">{{ $order->user->name ?? 'N/A' }}</td>
                        <td style="text-align: center">
                            <button type="button" class="btn btn-sm btn-primary show-info-btn"
                                data-info='@json($order->customer_info)'>
                                <i class="bi bi-info-circle-fill"></i>
                            </button>
                        </td>
                        <td style="text-align: center;">{{ $order->payment_method ?? 'N/A' }}</td>
                        <td style="text-align: center;">
                            <select class="form-select form-select-sm order-status" data-id="{{ $order->id }}">
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử
                                    lý</option>
                                <option value="shipping" {{ $order->status == 'shipping' ? 'selected' : '' }}>Đang giao
                                </option>
                                <option value="success" {{ $order->status == 'success' ? 'selected' : '' }}>Đã giao
                                </option>
                                <option value="cancel" {{ $order->status == 'cancel' ? 'selected' : '' }}>Đã huỷ</option>
                            </select>
                        </td>
                        <td style="text-align: center">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown">
                                    Hành động
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item text-success detail-order" href="javascript:void(0);"
                                            data-id="{{ $order->id }}"
                                            data-detail="{{ route('admin.order.list.detail.index') }}">
                                            Xem chi tiết
                                        </a>
                                    </li>
                                </ul>
                            </div>
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

        {{-- Phân trang --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $orders->onEachSide(1)->links() }}
        </div>
    </div>
@stop
