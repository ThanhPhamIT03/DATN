@extends('web.layouts.master')

@section('title', 'Thanh toán')

@section('script')
    <script type="module">
        // Xử lý khi bấm vào nút thanh toán khi nhận hàng
        $(document).on('click', '.cod-button', function() {
            let url = $(this).data('url');
            let method = $(this).data('method');
            let orderInfo = $(this).data('order');

            paymentProcess(url, method, orderInfo);
        });

        // Xử lý khi bấm vào nút thanh toán online
        $(document).on('click', '.online-button', function() {
            let url = $(this).data('url');
            let method = $(this).data('method');
            let orderInfo = $(this).data('order');

            paymentProcess(url, method, orderInfo);
        });

        function paymentProcess(url, method, orderInfo) {
            let payload = {
                _token: "{{ csrf_token() }}",
                customer_id: $('#customer_id').val(),
                customer_name: $('#customer_name').val(),
                customer_phone: $('#customer_phone').val(),
                customer_email: $('#customer_email').val(),
                customer_address: $('#customer_address').val(),
                payment_method: method,
                order_info: orderInfo
            };

            $.ajax({
                url: url,
                method: "POST",
                data: payload,
                success: function(res) {
                    if (res.success) {
                        Swal.fire('Thành công', res.message, 'success').then(() => {
                            console.log(res.redirect);
                            window.location.href = res.redirect;
                        });
                    } else {
                        Swal.fire('Lỗi', res.message, 'error').then(() => {
                            window.location.href = res.redirect;
                        });
                    }
                },
                error: function() {
                    Swal.fire('Lỗi', 'Có lỗi trong quá trình xử lý thanh toán!', 'error').then(() => {
                        window.location.href = res.redirect;
                    });
                }
            });
        }
    </script>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
    <li class="breadcrumb-item"><a href="{{ route('web.cart.index') }}">Giỏ hàng</a></li>
    <li class="breadcrumb-item" aria-current="page">Thanh toán</li>
@stop

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">Thanh toán hoá đơn.</h2>

        {{-- Bảng sản phẩm --}}
        <div class="card mb-4">
            <div class="card-body p-0">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Thông tin đơn hàng</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-primary">
                                    <tr>
                                        <th scope="col">Sản phẩm</th>
                                        <th scope="col">Phiên bản</th>
                                        <th scope="col" class="text-center">Số lượng</th>
                                        <th scope="col" class="text-end">Giá</th>
                                        <th scope="col" class="text-end">Tổng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $grandTotal = 0; @endphp
                                    @foreach ($orderInfo as $item)
                                        @php $grandTotal += $item['total_price']; @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('storage/' . $item['thumbnail']) }}"
                                                        alt="{{ $item['product_name'] }}" class="me-2 rounded"
                                                        style="width: 60px; height: 60px; object-fit: cover;">
                                                    <span>{{ $item['product_name'] }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">Màu:
                                                    {{ $item['variant']['color'] }}</span><br>
                                                <span class="badge bg-light text-dark">RAM:
                                                    {{ $item['variant']['ram'] }}</span><br>
                                                <span class="badge bg-light text-dark">ROM:
                                                    {{ $item['variant']['rom'] }}</span>
                                            </td>
                                            <td class="text-center">{{ $item['quantity'] }}</td>
                                            <td class="text-end">{{ number_format($item['price'], 0, ',', '.') }}đ</td>
                                            <td class="text-end fw-bold text-danger">
                                                {{ number_format($item['total_price'], 0, ',', '.') }}đ
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="4" class="text-end">Tổng cộng:</th>
                                        <th class="text-end text-danger h5">{{ number_format($grandTotal, 0, ',', '.') }}đ
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form thông tin giao hàng --}}
        <div class="card mb-4">
            <div class="card-header">
                <strong>Thông tin giao hàng</strong>
            </div>
            <div class="card-body">
                <div id="checkout-form">
                    @csrf
                    <input type="hidden" id="customer_id" value="{{ $user->id }}">
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name"
                            value="{{ old('customer_name', $user->name ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="customer_phone" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="customer_phone" name="customer_phone"
                            value="{{ old('customer_phone', $user->phone ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="customer_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="customer_email" name="customer_email"
                            value="{{ old('customer_email', $user->email ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="customer_address" class="form-label">Địa chỉ</label>
                        <input class="form-control" id="customer_address" name="customer_address"
                            value="{{ old('customer_address', $user->default_address ?? '') }}" required>
                    </div>

                    {{-- Nút thanh toán --}}
                    <div class="d-flex gap-3">
                        <button type="button" class="btn btn-success px-4 cod-button"
                            data-url="{{ route('web.payment.cod') }}" data-method="cod"
                            data-order='@json($orderInfo)'>
                            Thanh toán khi nhận hàng
                        </button>
                        <button type="button" class="btn btn-momo px-4 d-flex align-items-center gap-2 online-button"
                            data-url="{{ route('web.payment.online') }}" data-method="online"
                            data-order='@json($orderInfo)'>
                            <img src="{{ asset('./images/default/momo.png')}}" alt="MoMo"
                                style="height:20px; width:auto;">
                            Thanh toán MOMO
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
