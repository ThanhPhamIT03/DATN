@extends('web.layouts.master-no-footer')

@section('title', 'Giỏ hàng')

@section('script')
    <script type="module">
        $(document).ready(function () {
            const $selectAll = $('#selectAllCheckbox');
            const $selectAllLabel = $('#selectAllLabel');
            const $deselectAllLabel = $('#deselectAllLabel');
            const $productCheckboxes = $('.product-checkbox');

            // Tăng/giảm số lượng sản phẩm
            $('.btn-plus').on('click', function () {
                const $wrapper = $(this).closest('.card-body');
                const $quantity = $wrapper.find('.quantity');
                let qty = parseInt($quantity.text(), 10);
                qty++;
                $quantity.text(qty);
                updateCartTotal();
            });

            $('.btn-minus').on('click', function () {
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
            });

            // Khi click checkbox "Chọn tất cả"
            $selectAll.on('change', function () {
                const isChecked = $(this).is(':checked');
                $productCheckboxes.prop('checked', isChecked);
                toggleLabels(isChecked);
                updateBuyNowButton();
                updateCartTotal();
            });

            // Khi click từng checkbox sản phẩm
            $productCheckboxes.on('change', function () {
                const checkedCount = $productCheckboxes.filter(':checked').length;

                if (checkedCount > 0) {
                    $selectAll.prop('checked', true);
                    toggleLabels(true);
                } else {
                    $selectAll.prop('checked', false);
                    toggleLabels(false);
                }

                updateBuyNowButton();
                updateCartTotal();
            });

            function toggleLabels(isChecked) {
                $selectAllLabel.toggleClass('d-none', isChecked);
                $deselectAllLabel.toggleClass('d-none', !isChecked);
            }

            function updateBuyNowButton() {
                const selectedCount = $productCheckboxes.filter(':checked').length;
                const $buyNowBtn = $('#buyNowBtn');

                if (selectedCount > 0) {
                    $buyNowBtn.removeClass('disabled').attr('aria-disabled', 'false').text(`Mua ngay (${selectedCount})`);
                } else {
                    $buyNowBtn.addClass('disabled').attr('aria-disabled', 'true').text('Mua ngay');
                }
            }

            function updateCartTotal() {
                let total = 0;

                $productCheckboxes.each(function () {
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
    </script>
@stop

@section('content')
    <div class="container">
        <div class="row justify-content-center cart-container">
            {{-- Dã đăng nhập --}}
            <div class="col-md-8">
                <div class="position-relative py-3 border-bottom mb-4">
                    <a href="{{ route('home.index') }}" class="position-absolute top-50 start-0 translate-middle-y ms-3 text-dark">
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
                    <a href="#" id="deleteAllProduct">Xoá sản phẩm đã chọn</a> 
                </div>
                <div class="card mb-3">
                    <div class="card-body d-flex align-items-center">
                        <input type="checkbox" class="form-check-input me-3 product-checkbox">
                        <img src="{{ asset('./images/iphone-16-pro-max.webp') }}" class="img-fluid me-3" alt="iPhone 16" style="width: 80px; height: auto;">
                        <div class="flex-grow-1">
                            <h6 class="mb-1">iPhone 16 Pro Max 256GB | Chính hãng VN/A - Titan Đen</h6>
                            <div>
                                <span class="text-danger fw-bold product-price" data-price="29542000">29.542.000₫</span>
                                <span class="text-muted text-decoration-line-through ms-2">34.990.000₫</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-light border px-2 btn-minus">-</button>
                            <span class="ms-2 me-2 quantity">1</span>
                            <button class="btn btn-light border px-2 btn-plus">+</button>
                        </div>
                        <a  href="#" class="btn btn-link text-danger ms-3">
                            <i class="bi bi-trash"></i> 
                        </a>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body d-flex align-items-center">
                        <input type="checkbox" class="form-check-input me-3 product-checkbox">
                        <img src="{{ asset('./images/iphone-16-pro-max.webp') }}" class="img-fluid me-3" alt="iPhone 16" style="width: 80px; height: auto;">
                        <div class="flex-grow-1">
                            <h6 class="mb-1">iPhone 16 Pro Max 256GB | Chính hãng VN/A - Titan Đen</h6>
                            <div>
                                <span class="text-danger fw-bold product-price" data-price="29542000">29.542.000₫</span>
                                <span class="text-muted text-decoration-line-through ms-2">34.990.000₫</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-light border px-2 btn-minus">-</button>
                            <span class="ms-2 me-2 quantity">1</span>
                            <button class="btn btn-light border px-2 btn-plus">+</button>
                        </div>
                        <a  href="#" class="btn btn-link text-danger ms-3">
                            <i class="bi bi-trash"></i> 
                        </a>
                    </div>
                </div>

                <div class="bg-white border-top ps-3 pe-3 pt-4 pb-4 shadow-sm cart-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="fw-bold fs-5">
                            Tạm tính: <span class="text-danger" id="cartTotal">0₫</span>
                        </div>
                        <a href="#" id="buyNowBtn" class="btn btn-danger px-4 py-2 disabled" aria-disabled="true">
                            Mua ngay
                        </a>
                    </div>
                </div>
            </div>
            {{-- Giỏ hàng trống --}}
            <div class="col-md-8">
                
            </div>
        </div>
    </div>

    <!-- Toast thông báo -->
    <div class="position-fixed top-0 end-0 p-4" style="z-index: 9999">
        <div
            id="minQtyToast"
            class="toast text-bg-danger border-0 fs-6"
            role="alert"
            aria-live="assertive"
            aria-atomic="true"
            data-bs-delay="3000"
            data-bs-autohide="true"
        >
            <div class="d-flex">
                <div class="toast-body">
                    <div class="fw-bold mb-1">Thông báo <i class="bi bi-bell"></i></div>
                    <div class="small text-white">Số lượng tối thiểu là 1</div>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Đóng"></button>
            </div>
        </div>
    </div>
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
