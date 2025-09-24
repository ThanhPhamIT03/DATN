@extends('admin.layouts.master')

@section('title', 'Tạo đơn hàng')

@section('script')
    <script type="module">
        $(document).ready(function() {
            // Hàm render list gợi ý
            function renderList($container, data, type) {
                $container.empty().show();
                if (data.length > 0) {
                    data.forEach(item => {
                        let html = `<li class="list-group-item list-item" data-id="${item.id}" data-name="${item.name}">
                                    ${type === 'customer' ? (item.name + ' - ' + item.code) : item.name}
                                </li>`;
                        $container.append(html);
                    });
                } else {
                    $container.append('<li class="list-group-item">Không tìm thấy</li>');
                }
            }

            // Tìm kiếm khách hàng
            $('#searchCustomer').on('keyup', function() {
                let user_code = $(this).val();
                if (user_code.length < 2) {
                    $('#customerList').hide();
                    return;
                }

                $.ajax({
                    url: "{{ route('admin.order.create.search.user') }}",
                    method: "GET",
                    data: {
                        user_code
                    },
                    success: function(res) {
                        if (res) {
                            $('#customerList')
                                .html(
                                    `<li class="list-group-item list-item" data-id="${res.id}" data-name="${res.name}" data-code="${res.code}">
                            ${res.name} - ${res.code}
                        </li>`
                                )
                                .show();
                        } else {
                            $('#customerList')
                                .html(
                                    '<li class="list-group-item text-muted">Không tìm thấy khách hàng</li>'
                                )
                                .show();
                        }
                    }
                });
            });

            // Khi click chọn 1 khách hàng
            $(document).on('click', '#customerList .list-item', function() {
                let id = $(this).data('id');
                let name = $(this).data('name');
                let code = $(this).data('code');

                // gán vào input search + hidden input
                $('#searchCustomer').val(name + ' - ' + code);
                $('#customer_id').val(id);

                // ẩn list đi
                $('#customerList').hide();
            });

            // click ra ngoài thì ẩn list
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#searchCustomer, #customerList').length) {
                    $('#customerList').hide();
                }
            });

            // Tìm kiếm sản phẩm
            $('#searchProduct').on('keyup', function() {
                let keyword = $(this).val();
                if (keyword.length < 2) {
                    $('#productList').hide();
                    return;
                }

                $.ajax({
                    url: "{{ route('admin.order.create.search.product') }}",
                    type: "GET",
                    data: {
                        keyword
                    },
                    success: function(res) {
                        renderList($('#productList'), res, 'product');
                    }
                });
            });

            // Click chọn sản phẩm
            $(document).on('click', '#productList .list-item', function() {
                let id = $(this).data('id');
                let name = $(this).data('name');

                $('#searchProduct').val(name);
                $('#product_id').val(id);
                $('#productList').hide();

                // Gọi API lấy phiên bản
                $.ajax({
                    url: "{{ route('admin.order.create.search.variant') }}",
                    type: "GET",
                    data: {
                        product_id: id
                    },
                    success: function(res) {
                        $('#variantSelect').empty().prop('disabled', false);

                        if (res.length > 0) {
                            res.forEach(item => {
                                let variantText =
                                    `${item.color} - ${item.storage.ram}/${item.storage.rom} - ${Number(item.sale_price).toLocaleString()}đ`;
                                $('#variantSelect').append(
                                    `<option value="${item.id}">${variantText}</option>`
                                );
                            });
                        } else {
                            $('#variantSelect').append(
                                '<option disabled>Không có phiên bản nào</option>');
                        }
                    }
                });
            });

            // Xử lý khi bấm tạo đơn hàng
            $(document).on('click', '.btn-create-order', function() {
                $('#create-order-form').submit();
            });
        });
    </script>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.order.list.index') }}">Đơn hàng</a></li>
    <li class="breadcrumb-item" aria-current="page">Tạo đơn hàng</li>
@stop

@section('content')
    <div class="container mt-2 pb-4">
        <h3 class="mb-4">Tạo đơn hàng</h3>
        <form id="create-order-form" method="POST" action="{{ route('admin.order.create.store') }}">
            @csrf

            <!-- Khách hàng -->
            <div class="mb-3 position-relative">
                <label for="searchCustomer" class="form-label">Mã khách hàng</label>
                <input type="text" id="searchCustomer" class="form-control" placeholder="Nhập mã khách hàng...">
                <input type="hidden" name="customer_id" id="customer_id">
                <ul id="customerList" class="list-group position-absolute w-100" style="z-index:1000; display:none;"></ul>
            </div>

            <hr>

            <!-- Sản phẩm -->
            <div class="mb-3 position-relative">
                <label for="searchProduct" class="form-label">Tìm sản phẩm</label>
                <input type="text" id="searchProduct" class="form-control" placeholder="Nhập tên sản phẩm...">
                <input type="hidden" name="product_id" id="product_id">
                <ul id="productList" class="list-group position-absolute w-100" style="z-index:1000; display:none;"></ul>
            </div>

            <!-- Phiên bản -->
            <div class="mb-3">
                <label for="variantSelect" class="form-label">Chọn phiên bản</label>
                <select id="variantSelect" name="variant_id" class="form-select" disabled required>
                    <option value="">-- Chọn phiên bản --</option>
                </select>
            </div>

            <button type="button" class="btn btn-success btn-create-order">Tạo đơn hàng</button>
        </form>
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
