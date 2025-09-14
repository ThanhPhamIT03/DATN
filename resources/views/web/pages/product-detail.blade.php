@extends('web.layouts.master')

@section('title', 'Chi tiết sản phẩm')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
    <li class="breadcrumb-item"><a href="#">Sản phẩm</a></li>
    <li class="breadcrumb-item" aria-current="page">Chi tiết sản phẩm</li>
@endsection

@section('script')
    <script type="module">
        $(document).ready(function() {
            $("#toggle-specs").click(function() {
                $("#extra-specs").slideToggle(300);
                if ($("#extra-specs").is(":visible")) {
                    $("#toggle-text").text("Thu gọn");
                    $("#toggle-icon").removeClass("bi-chevron-down").addClass("bi-chevron-up");
                } else {
                    $("#toggle-text").text("Xem chi tiết");
                    $("#toggle-icon").removeClass("bi-chevron-up").addClass("bi-chevron-down");
                }
            });
        });

        function updateProductDetails(versionEl) {
            let price = parseInt(versionEl.data("price"), 10) || 0;
            let installment = parseFloat(versionEl.data("installment")) || 0;

            // Nếu chọn bảo hành thì cộng thêm
            if ($("#care").is(":checked")) {
                let carePrice = parseInt($("#product-care").data("care"), 10) || 0;
                price += carePrice;
                installment += carePrice / 12;
            }

            // Update giá
            $("#product-price").text(new Intl.NumberFormat('vi-VN').format(price) + "₫");
            $("#product-installment").text(
                new Intl.NumberFormat('vi-VN').format(Math.round(installment)) + "₫/tháng"
            );

            // Update thông số
            $("#screen").text(versionEl.data("screen_size") + ", " + versionEl.data("screen_technology"));
            $("#operating_system").text(versionEl.data("operating_system"));
            $("#cpu_type").text(versionEl.data("chip") + ", " + versionEl.data("cpu_type"));
            $("#ram").text(versionEl.data("ram"));
            $("#rom").text(versionEl.data("rom"));
            $("#rear_camera").text(versionEl.data("rear_camera"));
            $("#front_camera").text(versionEl.data("front_camera"));
            $("#battery").text(versionEl.data("battery"));
        }

        // Khi click chọn phiên bản
        $(document).on("click", ".version-option", function() {
            $(".version-option").removeClass("active");
            $(this).addClass("active");
            updateProductDetails($(this));
        });

        // Khi bật/tắt bảo hành cũng update lại phiên bản đang active
        $("#care").on("change", function() {
            let activeVersion = $(".version-option.active");
            if (activeVersion.length) {
                updateProductDetails(activeVersion);
            }
        });

        // Xử lý nút thêm giỏ hàng

        $(document).on("click", "#add-to-cart", function(e) {
            e.preventDefault();

            let activeVersion = $(".version-option.active");

            if (!activeVersion.length) {
                alert("Vui lòng chọn phiên bản trước khi thêm vào giỏ!");
                return;
            }

            // Lấy dữ liệu từ phiên bản
            let variantId = activeVersion.data("id");
            let price = parseInt(activeVersion.data("price"), 10) || 0;

            // Nếu có bảo hành thì cộng thêm
            if ($("#care").is(":checked")) {
                let carePrice = parseInt($("#product-care").data("care"), 10) || 0;
                price += carePrice;
            }

            // Các thông số khác (nếu muốn lưu vào cột info JSON)
            let info = {
                screen: activeVersion.data("screen_size") + ", " + activeVersion.data("screen_technology"),
                operating_system: activeVersion.data("operating_system"),
                chip: activeVersion.data("chip"),
                cpu_type: activeVersion.data("cpu_type"),
                ram: activeVersion.data("ram"),
                rom: activeVersion.data("rom"),
                rear_camera: activeVersion.data("rear_camera"),
                front_camera: activeVersion.data("front_camera"),
                battery: activeVersion.data("battery"),
                care: $("#care").is(":checked") ? 1 : 0
            };

            // Gửi AJAX thêm giỏ hàng
            let addToCartUrl = $("#add-to-cart").data("url");
            $.ajax({
                url: addToCartUrl,
                method: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                    variant_id: variantId,
                    quantity: 1,
                    price: price,
                    info: info
                },
                success: function(res) {
                    if (res.success) {
                        Swal.fire('Thành công', res.message, 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Lỗi', res.message, 'error');
                    }
                },
                error: function() {
                    Swal.fire('Lỗi', 'Bạn cần đăng nhập!', 'error');
                }
            });
        });
    </script>
@stop

@section('content')
    <div class="container-xl">
        <div class="row">
            {{-- Cột 1 --}}
            <div class="col-md-6">
                <div id="productCarousel" class="carousel slide position-relative" data-bs-ride="carousel">
                    {{-- Ảnh sản phẩm --}}
                    <div class="carousel-inner">
                        @foreach ($variants as $variant)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $variant->thumbnail) }}" class="d-block mx-auto"
                                    alt="{{ $product->name }}">
                            </div>
                        @endforeach
                    </div>

                    {{-- Nút prev/next --}}
                    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel"
                        data-bs-slide="prev">
                        <i class="bi bi-chevron-left icon-prev"></i>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel"
                        data-bs-slide="next">
                        <i class="bi bi-chevron-right icon-next"></i>
                        <span class="visually-hidden">Next</span>
                    </button>

                    {{-- Indicator sinh động theo variants --}}
                    <div class="carousel-indicators">
                        @foreach ($variants as $index => $variant)
                            <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="{{ $index }}"
                                class="{{ $loop->first ? 'active' : '' }}"
                                aria-current="{{ $loop->first ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}">
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="p-3 mt-4 rounded-4 my-2 bg-white text-center border">
                    <p class="fs-13px mb-0">
                        Sản phẩm chính hãng mới 100% nguyên seal. Phụ kiện chính hãng gồm: hộp trùng imei, cable, sách hướng
                        dẫn
                    </p>
                </div>

                <div id="product-related" class="d-block">
                    <div class="mb-3 mb-lg-0">
                        <div class="mb-2 mt-1">
                            <h4 class="mt-4 mb-4 text-dark text-uppercase">Sản phẩm liên quan</h4>
                        </div>
                        <div class="block-product">
                            <div class="row">
                                @forelse($relatedProduct as $related)
                                    <div class="col-md-4 mb-3"> <a href="#" class="text-decoration-none text-dark">
                                            <div class="card h-100 shadow-sm overflow-hidden pt-2"> <img
                                                    src="{{ asset('storage/' . $related->thumbnail) }}" class="card-img-top"
                                                    alt="Sản phẩm 1">
                                                <div class="card-body">
                                                    <h6 class="card-title text-truncate" style="max-width: 100%;">
                                                        {{ $related->name }}</h6>
                                                    <p class="card-text text-danger fw-bold">
                                                        {{ number_format($related->variants->first()->sale_price, 0, ',', '.') }}₫</p>
                                                    <a href="#" class="btn btn-primary btn-sm mt-2">Mua ngay</a>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @empty
                                    <div class="col-12 d-flex align-items-center justify-content-center m-4">
                                        <span class="text-danger fw-bold fst-italic">Không có sản phẩm liên quan nào.</span>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Côt 2 --}}
            <div class="col-md-6 d-flex flex-column">
                <div id="product-info">
                    <h1 class="product-title fs-3 fw-bolder mb-2">{{ $product->name }}</h1>
                </div>

                {{-- Giá --}}
                <div class="product-price">
                    <div class="price-box">
                        <div
                            class="price_container d-flex flex-row flex-wrap align-items-center justify-content-between mt-2">
                            <div class="me-2">
                                <strong id="product-price" class="fs-4 pt-0 d-inline price_val text-danger">
                                    {{ number_format($variants->first()->sale_price, 0, ',', '.') }}₫
                                </strong>
                            </div>
                            <div class="fs-14px text-end">
                                <span>Trả góp từ: </span>
                                <strong id="product-installment" class="price2_val text-danger d-inline fs-14px pt-0">
                                    {{ number_format(round($variant->sale_price / 12), 0, ',', '.') }}₫/tháng
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Phiên bản -->
                <div id="product-version" class="mt-4">
                    <div class="align-items-center flex-wrap">
                        <div class="me-4 fw-bold mb-2">Phiên bản:</div>
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            @foreach ($variants as $index => $variant)
                                <div class="border rounded px-3 py-2 small version-option {{ $loop->first ? 'active' : '' }}"
                                    data-id="{{ $variant->id }}" data-price="{{ $variant->sale_price }}"
                                    data-installment="{{ $variant->sale_price / 12 }}" data-color="{{ $variant->color }}"
                                    data-storage="{{ $variant->storage['ram'] }}-{{ $variant->storage['rom'] }}"
                                    data-opearing_system="{{ $variant->info['operating_system'] }}"
                                    data-screen_size="{{ $variant->info['screen_size'] }}"
                                    data-screen_technology="{{ $variant->info['screen_technology'] }}"
                                    data-front_camera="{{ $variant->info['front_camera'] }}"
                                    data-rear_camera="{{ $variant->info['rear_camera'] }}"
                                    data-chip="{{ $variant->info['chip'] }}" data-ram="{{ $variant->info['ram'] }}"
                                    data-rom="{{ $variant->info['rom'] }}" data-battery="{{ $variant->info['battery'] }}"
                                    data-cpu_type="{{ $variant->info['cpu_type'] }}">
                                    {{ $variant->color }} - {{ $variant->storage['ram'] }}/{{ $variant->storage['rom'] }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="p-3 mt-4 rounded-4 my-2 bg-white border d-flex align-items-center justify-content-between">
                    <!-- Trái: ảnh + nội dung -->
                    <div class="d-flex align-items-center">
                        <!-- Hình ảnh -->
                        <img src="{{ asset('images/bhv-icon.webp') }}" alt="ST Care Care" class="me-3 img-fluid w-25">

                        <!-- Text + Giá -->
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <p class="mb-1 fw-semibold">
                                    Gói bảo hành ST Care
                                </p>
                                <p class="mb-0 text-muted small">Bảo hành 1 đổi 1 nguyên seal 30 ngày</p>
                            </div>
                            <p id="product-care" data-care="350000" class="mb-0 fw-bold text-danger">
                                +350.000 ₫
                            </p>
                        </div>
                    </div>
                    <!-- Toggle (Bootstrap 5 Switch) -->
                    <div class="form-check form-switch m-0">
                        <input id="care"class="form-check-input" type="checkbox" role="switch">
                    </div>
                </div>

                {{-- Commit --}}
                <div id="product-commit" class="mt-3">
                    <ul class="list-unstyled">
                        <li class="d-flex align-items-start mb-2">
                            <i class="bi bi-check-circle-fill me-2 icon-commit"></i>
                            <span>Sản phẩm chính hãng mới 100% nguyên seal</span>
                        </li>
                        <li class="d-flex align-items-start mb-2">
                            <i class="bi bi-check-circle-fill me-2 icon-commit"></i>
                            <span>Giá đã bao gồm VAT</span>
                        </li>
                        <li class="d-flex align-items-start mb-2">
                            <i class="bi bi-check-circle-fill me-2 icon-commit"></i>
                            <span>Bảo hành 12 tháng chính hãng</span>
                        </li>
                        <li class="d-flex align-items-start mb-2">
                            <i class="bi bi-check-circle-fill me-2 icon-commit"></i>
                            <span>Giảm giá 10% khi mua phụ kiện kèm theo</span>
                        </li>
                    </ul>
                </div>

                {{-- Product Button --}}
                <div id="product-button" class="mt-4">
                    <!-- Nút mua ngay -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <a href="#"
                                class="btn btn-primary btn-lg w-100 d-flex flex-column align-items-center justify-content-center">
                                <div class="fw-bolder fs-5 text-uppercase">MUA NGAY</div>
                                <div class="small fw-normal fs-6 text-light">Giao hàng tận nơi hoặc nhận tại cửa hàng</div>
                            </a>
                        </div>
                    </div>

                    <!-- Nút giỏ hàng + trả góp -->
                    <div class="row">
                        <div class="col-6 mb-2">
                            <a href="#" id="add-to-cart" data-url="{{ route('web.cart.add') }}"
                                class="btn btn-warning btn-lg w-100 d-flex flex-column align-items-center justify-content-center text-white">
                                <div class="fw-bolder fs-5 text-uppercase">
                                    <i class="bi bi-cart-plus"></i> THÊM VÀO GIỎ
                                </div>
                                <div class="small fs-6 fw-normal text-light">Chọn thêm món đồ khác</div>
                            </a>
                        </div>
                        <div class="col-6 mb-2">
                            <a href="#"
                                class="btn btn-danger btn-lg w-100 d-flex flex-column align-items-center justify-content-center">
                                <div class="fw-bolder fs-5 text-uppercase">
                                    <i class="bi bi-credit-card-2-front-fill"></i> MUA TRẢ GÓP
                                </div>
                                <div class="small fs-6 fw-normal text-light">Thủ tục đơn giản & nhanh chóng</div>
                            </a>
                        </div>
                    </div>
                </div>

                <div id="product-" class="mt-4">
                    <ul class="list-unstyled">
                        <li class="d-flex align-items-start mb-2">
                            <i class="bi bi-laptop-fill me-2"></i>
                            <span>Dùng thử 10 ngày miễn phí đổi máy (Sản phẩm Like New).</span>
                        </li>
                        <li class="d-flex align-items-start mb-2">
                            <i class="bi bi-box-seam-fill me-2"></i>
                            <span>Lỗi 1 Đổi 1 trong 30 ngày đầu (Sản phẩm Like New).</span>
                        </li>
                        <li class="d-flex align-items-start mb-2">
                            <i class="bi bi-rocket-takeoff-fill me-2"></i>
                            <span>Giao hàng tận nhà toàn quốc.</span>
                        </li>
                        <li class="d-flex align-items-start mb-2">
                            <i class="bi bi-hand-thumbs-up-fill me-2"></i>
                            <span>Thanh toán khi nhận hàng (nội thành Hà Nội).</span>
                        </li>
                        <li class="d-flex align-items-start mb-2">
                            <i class="bi bi-telephone-inbound-fill me-2"></i>
                            <span class="hotline-text">
                                Gọi
                                <a href="tel:0337005347" class="hotline-link">
                                    0337.005.347
                                </a>
                                để được tư vấn mua hàng (Miễn phí).
                            </span>
                        </li>
                    </ul>
                </div>

                <div id="product-specs" class="p-3 mt-4 rounded-4 my-2 bg-white border">
                    <h5 class="mb-3 text-dark">Thông số kỹ thuật</h5>
                    <table class="table table-striped">
                        <!-- 3 dòng hiển thị mặc định -->
                        <tbody>
                            <tr>
                                <th scope="row">Màn hình</th>
                                <td id="screen">{{ $variants->first()->info['screen_size'] }},
                                    {{ $variants->first()->info['screen_technology'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Hệ điều hành</th>
                                <td id="operating_system">{{ $variants->first()->info['operating_system'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row">CPU</th>
                                <td id="cpu_type">{{ $variants->first()->info['chip'] }},
                                    {{ $variants->first()->info['cpu_type'] }}</td>
                            </tr>
                        </tbody>

                        <!-- Các dòng còn lại ẩn -->
                        <tbody id="extra-specs" style="display: none;">
                            <tr>
                                <th scope="row">RAM</th>
                                <td id="ram">{{ $variants->first()->storage['ram'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Bộ nhớ trong</th>
                                <td id="rom">{{ $variants->first()->storage['rom'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Camera chính</th>
                                <td id="rear_camera">{{ $variants->first()->info['rear_camera'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Camera trước</th>
                                <td id="front_camera">{{ $variants->first()->info['front_camera'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Pin</th>
                                <td id="battery">{{ $variants->first()->info['battery'] }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="text-center mt-3">
                        <button id="toggle-specs" class="btn btn-sm btn-outline-secondary">
                            <span id="toggle-icon" class="bi bi-chevron-down"></span> <span id="toggle-text">Xem chi
                                tiết</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Đánh giá sản phẩm --}}
        <div class="row pb-4">
            <div class="col-12">
                <h4 class="mb-3">Đánh giá sản phẩm</h4>

                <!-- Form thêm đánh giá -->
                <div class="card p-3 mb-4">
                    <h5>Thêm đánh giá của bạn</h5>
                    <form id="review-form">
                        <div class="mb-2">
                            <textarea id="review-text" class="form-control" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                    </form>
                </div>

                <!-- Danh sách đánh giá -->
                <div id="reviews-list" class="mb-4">

                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="fw-bold">Nguyễn Văn A</div>
                            <p class="mb-1 mt-2">Sản phẩm chất lượng, giao hàng nhanh. Rất hài lòng!</p>
                            <div class="text-muted" style="font-size: 0.85rem;">Đã mua sản phẩm ngày: 2025-08-01</div>
                        </div>
                    </div>

                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="fw-bold">Trần Thị B</div>
                            <p class="mb-1 mt-2">Rất đẹp và bền. Sẽ ủng hộ lần sau!</p>
                            <div class="text-muted" style="font-size: 0.85rem;">Đã mua sản phẩm ngày: 2025-07-25</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="overlay" style="display: none;"></div>
    <style>
        .version-option {
            border: 1px solid #dbdbdb !important;
        }

        .version-option:hover {
            cursor: pointer;
            border-color: var(--primary-color) !important;
        }

        .version-option.active {
            border-color: var(--primary-color) !important;
        }
    </style>
@stop
