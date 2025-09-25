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
        let exportUrl = null;
        $(document).on('click', '.detail-order', function() {
            let id = $(this).data('id');
            let customerName = $(this).data('customer_name');
            let customerPhone = $(this).data('customer_phone');
            let customerEmail = $(this).data('customer_email');
            let customerAddress = $(this).data('customer_address');
            let orderItems = $(this).data('order_items');

            $('#orderId').val(id);
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

            let modal = new bootstrap.Modal(document.getElementById('detailOrderModal'));
            modal.show();
        });

        $(document).on('click', '.show-bill', function() {
            let billUrl = $(this).data('bill');

            if (billUrl) {
                window.open(billUrl, '_blank');
            } else {
                Swal.fire('Lỗi', 'Hoá đơn chưa được tạo!', 'error');
            }
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
                    <th style="text-align: center;" scope="col">Thông tin khách hàng</th>
                    <th style="text-align: center;" scope="col">Phương thức thanh toán</th>
                    <th style="text-align: center;" scope="col">Trạng thái thanh toán</th>
                    <th style="text-align: center;" scope="col">Trạng thái đơn hàng</th>
                    <th style="text-align: center;" scope="col">Hành động</th>
                    <th style="text-align: center;" scope="col">Hoá đơn</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td class="text-center text-truncate" style="max-width: 200px;">
                            {{ $order->order_code }}
                        </td>
                        <td style="text-align: center">
                            <button type="button" class="btn btn-sm btn-primary show-info-btn"
                                data-info='@json($order->customer_info)'>
                                <i class="bi bi-info-circle-fill"></i>
                            </button>
                        </td>
                        <td style="text-align: center;">
                            @if($order->payment_method == 'cod')
                                <span class="badge bg-primary">Thanh toán khi nhận hàng</span>
                            @elseif($order->payment_method == 'online')
                                <span class="badge bg-success">Thanh toán online</span>
                            @else
                                <span class="badge bg-danger">N/A</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            @if($order->payment_status == 'paid')
                                <span class="bg-success badge">Đã thanh toán</span>
                            @elseif($order->payment_status == 'unpaid')
                                <span class="bg-secondary badge">Chưa thanh toán</span>
                            @elseif($order->payment_status == 'wait_paid')
                                <span class="bg-warning badge">Chờ thanh toán</span>
                            @else
                                <span class="bg-danger badge">Không có thông tin</span>
                            @endif
                        </td>
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
                                            data-customer_name="{{ $order->customer_info['customer_name'] }}"
                                            data-customer_phone="{{ $order->customer_info['customer_phone'] }}"
                                            data-customer_email="{{ $order->user->email }}"
                                            data-customer_address="{{ $order->customer_info['customer_address'] }}"
                                            data-order_items='@json($order->orderItems)'>
                                            Xem chi tiết
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <td style="text-align: center">
                            <button type="button" class="btn btn-sm btn-primary show-bill"
                                data-bill="{{ $order->bill ? $order->bill->path : '' }}">
                                Xem hoá đơn
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

        {{-- Modal chi tiết đơn hàng --}}
        <div class="modal fade" id="detailOrderModal" tabindex="-1" aria-labelledby="detailOrderLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <!-- Header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailOrderLabel">Chi tiết đơn hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>

                    <!-- Form -->
                    <form id="detailOrderForm" method="GET" action="{{ route('admin.order.list.export') }}">
                        @csrf
                        <div class="modal-body">
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
                            <div id="orderItems">

                            </div>

                            {{-- Tổng tiền đơn hàng --}}
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="mt-4 mb-3 text-primary">Tổng tiền:</h4>
                                <strong id="total" class="mb-0 text-danger"></strong>
                            </div>

                            <!-- Thêm hidden input để truyền ID đơn hàng -->
                            <input type="hidden" id="orderId" name="order_id">
                        </div>

                        <!-- Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary ladda-button" data-style="zoom-in" id="exportInvoiceBtn">
                                Xuất hóa đơn
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Phân trang --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $orders->onEachSide(1)->links() }}
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
