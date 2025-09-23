@extends('web.layouts.master-no-footer')

@section('title', 'Giỏ hàng')

@section('script')
    <script type="module">
        $(document).ready(function() {
            const $selectAll = $('#selectAllCheckbox');
            const $selectAllLabel = $('#selectAllLabel');
            const $deselectAllLabel = $('#deselectAllLabel');
            const $productCheckboxes = $('.product-checkbox');

            // Tăng/giảm số lượng sản phẩm
            $('.btn-plus').on('click', function() {
                const $wrapper = $(this).closest('.card-body');
                const $quantity = $wrapper.find('.quantity');
                let qty = parseInt($quantity.text(), 10);
                qty++;
                $quantity.text(qty);
                updateCartTotal();

                let id = $(this).data('id');
                let addQuantityUrl = $(this).data('add_quantity_url');
                $.ajax({
                    url: addQuantityUrl,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        quantity: qty
                    },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire('Thành công', res.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            console.log(res.message);
                        }
                    },
                    error: function() {
                        Swal.fire('Lỗi', 'Không thể cập nhật số lượng!', 'error');
                    }
                });
            });

            $('.btn-minus').on('click', function() {
                const $wrapper = $(this).closest('.card-body');
                const $quantity = $wrapper.find('.quantity');
                let qty = parseInt($quantity.text(), 10);
                if (qty > 1) {
                    qty--;
                    $quantity.text(qty);
                    updateCartTotal();
                } else {
                    const toast = new bootstrap.Toast(document.getElementById('minQtyToast'));
                    toast.show();
                }

                let id = $(this).data('id');
                let minusQuantityUrl = $(this).data('minus_quantity_url');
                $.ajax({
                    url: minusQuantityUrl,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        quantity: qty
                    },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire('Thành công', res.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            console.log(res.message);
                        }
                    },
                    error: function() {
                        Swal.fire('Lỗi', 'Không thể cập nhật số lượng!', 'error');
                    }
                });
            });

            // Hàm lấy tất cả sản phẩm đang được chọn
            function getSelectedItems() {
                let items = [];
                $productCheckboxes.each(function() {
                    if ($(this).is(':checked')) {
                        items.push({
                            id: $(this).data('id'),
                            price: $(this).data('price')
                        });
                    }
                });
                return items;
            }

            // Hàm cập nhật trạng thái checkbox "Chọn tất cả" và nhãn
            function updateSelectAllStatus() {
                const checkedCount = $productCheckboxes.filter(':checked').length;
                const allChecked = checkedCount === $productCheckboxes.length;
                $selectAll.prop('checked', allChecked);
                toggleLabels(checkedCount > 0);
            }

            // Khi click checkbox "Chọn tất cả"
            $selectAll.on('change', function() {
                const isChecked = $(this).is(':checked');
                $productCheckboxes.prop('checked', isChecked);
                updateSelectAllStatus();
                updateBuyNowButton();
                updateCartTotal();

                const selectedItems = getSelectedItems();
                console.log('Selected items:', selectedItems);
            });

            // Khi click từng checkbox sản phẩm
            $productCheckboxes.on('change', function() {
                updateSelectAllStatus();
                updateBuyNowButton();
                updateCartTotal();

                const selectedItems = getSelectedItems();
                console.log('Selected items:', selectedItems);
            });


            function toggleLabels(isChecked) {
                $selectAllLabel.toggleClass('d-none', isChecked);
                $deselectAllLabel.toggleClass('d-none', !isChecked);
            }

            function updateBuyNowButton() {
                const selectedCount = $productCheckboxes.filter(':checked').length;
                const $buyNowBtn = $('#buyNowBtn');

                if (selectedCount > 0) {
                    $buyNowBtn.removeClass('disabled').attr('aria-disabled', 'false').text(
                        `Mua ngay (${selectedCount})`);
                } else {
                    $buyNowBtn.addClass('disabled').attr('aria-disabled', 'true').text('Mua ngay');
                }
            }


            // Khi click nút Mua ngay
            $('#buyNowBtn').on('click', function(e) {
                e.preventDefault();

                const selectedItems = getSelectedItems();

                if (selectedItems.length === 0) {
                    const toast = new bootstrap.Toast(document.getElementById('minSelectToast'));
                    toast.show();
                    return;
                }

                let url = $(this).data('url');

                $.ajax({
                    url: url,
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        items: selectedItems
                    },
                    success: function(res) {
                        if (res.success) {
                            window.location.href = res.redirect;
                        } else {
                            Swal.fire('Có lỗi xảy ra', res.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Lỗi', 'Không thể mua hàng!', 'error');
                    }
                });
            });

            // Hiển thị toast message
            function updateCartTotal() {
                let total = 0;

                $productCheckboxes.each(function() {
                    if ($(this).is(':checked')) {
                        const $card = $(this).closest('.card-body');
                        const price = parseInt($card.find('.product-price').data('price'), 10);
                        const qty = parseInt($card.find('.quantity').text(), 10);
                        total += price * qty;
                    }
                });

                const formattedTotal = new Intl.NumberFormat('vi-VN').format(total) + '₫';
                $('#cartTotal').text(formattedTotal);
            }
        });

        // Xoá sản phẩm ra khỏi giỏ hàng
        $(document).on('click', '#cart-delete', function() {
            let id = $(this).data('id');
            let deleteUrl = $(this).data('delete');

            Swal.fire({
                title: "Bạn có chắc muốn xoá?",
                text: "Hoạt động này không thể hoàn tác!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Xoá",
                cancelButtonText: "Huỷ"
            }).then((res) => {
                if (res.isConfirmed) {
                    $.ajax({
                        url: deleteUrl,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id
                        },
                        success: function(res) {
                            if (res.success) {
                                Swal.fire("Đã xoá!", res.message, "success").then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire("Lỗi", res.message, "error");
                            }
                        },
                        error: function() {
                            Swal.fire("Lỗi", "Không thể xoá sản phẩm!", "error");
                        }
                    });
                }
            });
        });

        // Xử lý khi bấm vào nút xóa tất cả sản phẩm đã chọn
        $(document).on('click', '#deleteAllProduct', function(e) {
            e.preventDefault();

            let itemChecked = document.querySelectorAll('.product-checkbox:checked');
            let ids = Array.from(itemChecked).map(el => parseInt(el.getAttribute('data-id')));
            let url = $(this).data('url');

            $.ajax({
                url: url,
                method: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}",
                    ids: ids
                },
                success: function(res) {
                    if (res.success) {
                        Swal.fire('Thành công', res.message, 'success').then(function() {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Thất bại', res.message, 'error');
                    }
                },
                error: function() {
                    new bootstrap.Toast(document.getElementById('systemError')).show();
                    return;
                }
            });
        });

        // Lấy trạng thái thanh toán
        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);
            const orderId = urlParams.get('orderId');
            const resultCode = urlParams.get('resultCode');

            $.ajax({
                url: "{{ route('web.payment.momo.ipn') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    order_code: orderId,
                    resultCode: resultCode
                },
                success: function(res) {
                    if(res.success) {
                        console.log(res.message);
                        window.location.href=res.redirect;
                    }
                    else {
                        console.log(res.message);
                    }
                },
                error: function() {
                    console.log('Không thể cập nhật trạng thái thanh toán!');
                }
            });
        });
    </script>
@stop

@section('content')
    <div class="container">
        <div class="row justify-content-center cart-container">
            {{-- Đã đăng nhập --}}
            @auth
                <div class="col-md-8">
                    <div class="position-relative py-3 border-bottom mb-4">
                        <a href="{{ route('home.index') }}"
                            class="position-absolute top-50 start-0 translate-middle-y ms-3 text-dark">
                            <i class="bi bi-arrow-left fs-5"></i>
                        </a>
                        <h4 class="text-center m-0">Giỏ hàng của bạn</h4>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="d-flex align-items-center">
                            <input type="checkbox" id="selectAllCheckbox" class="form-check-input me-2 mt-0 ">

                            <span id="selectAllLabel">Chọn tất cả</span>
                            <span id="deselectAllLabel" class="d-none">Bỏ chọn tất cả</span>
                        </div>
                        <a href="#" id="deleteAllProduct" data-url="{{ route('web.cart.delete.all') }}">Xoá sản phẩm đã
                            chọn</a>
                    </div>
                    @forelse($carts as $cart)
                        <div class="card mb-3">
                            <div class="card-body d-flex align-items-center">
                                <input type="checkbox" class="form-check-input me-3 product-checkbox"
                                    data-id="{{ $cart->id }}" data-price="{{ $cart->price }}" id="select-item">
                                <img src="{{ asset('storage/' . $cart->variant->thumbnail) }}" class="img-fluid me-3"
                                    alt="iPhone 16" style="width: 80px; height: auto;">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $cart->product->name }} - {{ $cart->variant->storage['rom'] }} -
                                        {{ $cart->variant->color }}</h6>
                                    <div>
                                        <span class="text-danger fw-bold product-price" data-price="{{ $cart->price }}">
                                            {{ number_format($cart->price, 0, ',', '.') }}₫
                                        </span>
                                        <span class="text-muted text-decoration-line-through ms-2">
                                            {{ number_format($cart->variant->price, 0, ',', '.') }}₫
                                        </span>
                                    </div>
                                    <div>
                                        @if ($cart->variant->quantity > 0)
                                            <span class="text-success fst-italic">Còn hàng</span>
                                        @else
                                            <span class="text-danger fst-italic">Hết hàng</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <button data-minus_quantity_url="{{ route('web.cart.minus.quantity') }}"
                                        data-id="{{ $cart->id }}" class="btn btn-light border px-2 btn-minus">-</button>
                                    <span class="ms-2 me-2 quantity">{{ $cart->quantity }}</span>
                                    <button data-add_quantity_url="{{ route('web.cart.add.quantity') }}"
                                        data-id="{{ $cart->id }}" class="btn btn-light border px-2 btn-plus">+</button>
                                </div>
                                <a href="#" id="cart-delete" class="btn btn-link text-danger ms-3"
                                    data-delete="{{ route('web.cart.delete') }}" data-id="{{ $cart->id }}">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="card text-center p-5 shadow-sm">
                            <div class="card-body">
                                <h3 class="mb-3">🛒 Giỏ hàng của bạn đang trống</h3>
                                <p class="text-muted">Hãy tiếp tục mua sắm và thêm sản phẩm vào giỏ hàng nhé!</p>
                                <a href="{{ url('/') }}" class="btn btn-primary mt-3">
                                    <i class="bi bi-arrow-left"></i> Quay lại mua sắm
                                </a>
                            </div>
                        </div>
                    @endforelse
                    <div class="bg-white border-top ps-3 pe-3 pt-4 pb-4 shadow-sm cart-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="fw-bold fs-5">
                                Tạm tính: <span class="text-danger" id="cartTotal">0₫</span>
                            </div>
                            <a href="#" id="buyNowBtn" class="btn btn-danger px-4 py-2 disabled" aria-disabled="true"
                                data-url="{{ route('web.cart.collect') }}">
                                Mua ngay
                            </a>
                        </div>
                    </div>
                </div>
            @endauth

            {{-- Chưa đăng nhập --}}
            @guest
                <div class="col-md-8 pt-4">
                    <div class="card text-center p-5 shadow-sm">
                        <div class="card-body">
                            <h3 class="mb-3">🔒 Vui lòng đăng nhập để xem giỏ hàng</h3>
                            <p class="text-muted">Bạn cần có tài khoản để quản lý và đặt hàng.</p>
                            <div class="d-flex justify-content-center gap-3 mt-4">
                                <a href="{{ route('auth.login.index') }}" class="btn btn-primary px-4">
                                    Đăng nhập
                                </a>
                                <a href="{{ route('auth.register.index') }}" class="btn btn-outline-primary px-4">
                                    Đăng ký
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endguest
        </div>
    </div>

    <!-- Toast thông báo khi xoá sản phẩm dưới 1-->
    <div class="position-fixed top-0 end-0 p-4" style="z-index: 9999">
        <div id="minQtyToast" class="toast text-bg-danger border-0 fs-6" role="alert" aria-live="assertive"
            aria-atomic="true" data-bs-delay="3000" data-bs-autohide="true">
            <div class="d-flex">
                <div class="toast-body">
                    <div class="fw-bold mb-1">Thông báo! <i class="bi bi-bell"></i></div>
                    <div class="small text-white">Số lượng tối thiểu là 1</div>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Đóng"></button>
            </div>
        </div>
    </div>

    {{-- Toast thông báo khi chưa chọn sản phẩm --}}
    <div class="position-fixed top-0 end-0 p-4" style="z-index: 9999">
        <div id="minSelectToast" class="toast text-bg-danger border-0 fs-6" role="alert" aria-live="assertive"
            aria-atomic="true" data-bs-delay="3000" data-bs-autohide="true">
            <div class="d-flex">
                <div class="toast-body">
                    <div class="fw-bold mb-1">Thông báo! <i class="bi bi-bell"></i></div>
                    <div class="small text-white">Vui lòng chọn một sản phẩm</div>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Đóng"></button>
            </div>
        </div>
    </div>

    {{-- Toast thông báo khi lỗi hệ thống --}}
    <div class="position-fixed top-0 end-0 p-4" style="z-index: 9999">
        <div id="systemError" class="toast text-bg-danger border-0 fs-6" role="alert" aria-live="assertive"
            aria-atomic="true" data-bs-delay="3000" data-bs-autohide="true">
            <div class="d-flex">
                <div class="toast-body">
                    <div class="fw-bold mb-1">Thông báo! <i class="bi bi-bell"></i></div>
                    <div class="small text-light">Có lỗi xảy ra, vui lòng thử lại sau!</div>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Đóng"></button>
            </div>
        </div>
    </div>

    <div class="overlay" style="display: none;"></div>

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
    <style>
        #deleteAllProduct {
            text-decoration: none;
            color: var(--text-color);
        }

        #deleteAllProduct:hover {
            cursor: pointer;
            text-decoration: underline;
            color: red;
        }

        .cart-container {
            min-height: 100vh;
            position: relative;
        }

        .cart-list {
            padding-bottom: 100px;
        }

        .cart-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            max-width: 854px;
            margin: 0 auto;
            z-index: 1050;
        }
    </style>
@stop
