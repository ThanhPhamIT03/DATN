@extends('web.layouts.master')

@section('title', 'Chi tiết sản phẩm')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
    <li class="breadcrumb-item"><a href="#">Sản phẩm</a></li>
    <li class="breadcrumb-item" aria-current="page">Chi tiết sản phẩm</li>
@endsection

@section('script')
    <script type="module">
        $(document).on('click', '.color-swatch', function() {
            // Bỏ active ở tất cả
            $('.color-swatch').removeClass('selected');

            // Thêm active cho cái được click
            $(this).addClass('selected');

            // Lấy giá trị
            let colorCode = $(this).data('color');
            let colorName = $(this).data('value');
            let slideIndex = $(this).data('slide');

            // Hiển thị tên màu
            $('#selected-color').text(colorName).removeClass('d-none');

            // Di chuyển carousel tới slide ảnh tương ứng
            let carouselEl = document.getElementById('productCarousel');
            let carousel = bootstrap.Carousel.getInstance(carouselEl) ||
                new bootstrap.Carousel(carouselEl);
            carousel.to(slideIndex);
        });

        // 🔹 Lắng nghe sự kiện chuyển slide
        $('#productCarousel').on('slid.bs.carousel', function(e) {
            let currentIndex = $(e.relatedTarget).index();

            // Lấy color-swatch theo data-slide
            let swatch = $('.color-swatch[data-slide="' + currentIndex + '"]');

            if (swatch.length) {
                // Bỏ active ở tất cả và set lại
                $('.color-swatch').removeClass('selected');
                swatch.addClass('selected');

                // Cập nhật text màu
                $('#selected-color').text(swatch.data('value')).removeClass('d-none');
            }
        });

        $("#care").on("change", function() {
            if ($(this).is(":checked")) {
                console.log("Toggle đang BẬT");
            } else {
                console.log("Toggle đang TẮT");
            }
        });

        $(document).ready(function() {
            $("#toggle-specs").click(function() {
                $("#extra-specs").slideToggle(300); // slide mượt hơn
                if ($("#extra-specs").is(":visible")) {
                    $("#toggle-text").text("Thu gọn");
                    $("#toggle-icon").removeClass("bi-chevron-down").addClass("bi-chevron-up");
                } else {
                    $("#toggle-text").text("Xem chi tiết");
                    $("#toggle-icon").removeClass("bi-chevron-up").addClass("bi-chevron-down");
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
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('./images/iphone-16-pro-max.webp') }}" class="d-block mx-auto"
                                alt="iPhone 16 Pro Max">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('./images/iphone-16-pro-max-titan-den.webp') }}" class="d-block mx-auto"
                                alt="iPhone 16 Pro Max Titan Đen">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('./images/iphone-16-pro-max-titan-tu-nhien.webp') }}" class="d-block mx-auto"
                                alt="iPhone 16 Pro Max Titan Tự Nhiên">
                        </div>
                    </div>

                    <!-- Nút prev/next -->
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

                    <!-- Indicator -->
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="0" class="active"
                            aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="1"
                            aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="2"
                            aria-label="Slide 3"></button>
                    </div>

                    <!-- Màu sắc đã chọn -->
                    <div id="selected-color"
                        class="position-absolute bottom-0 start-0 mb-3 ms-3 px-3 py-1 bg-dark bg-opacity-75 text-white rounded small">
                        Vàng sa mạc
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
                                <div class="col-md-4 mb-3"> <a href="#" class="text-decoration-none text-dark">
                                        <div class="card h-100 shadow-sm overflow-hidden pt-2"> <img
                                                src="{{ asset('./images/iphone-16-pro-max.webp') }}" class="card-img-top"
                                                alt="Sản phẩm 1">
                                            <div class="card-body">
                                                <h6 class="card-title text-truncate" style="max-width: 100%;"> Tên sản phẩm
                                                    rất rất dài vượt quá khung hiển thị </h6>
                                                <p class="card-text text-danger fw-bold">1.200.000₫</p> <span
                                                    class="btn btn-primary btn-sm">Mua ngay</span>
                                            </div>
                                        </div>
                                    </a> </div>
                                <div class="col-md-4 mb-3"> <a href="#" class="text-decoration-none text-dark ">
                                        <div class="card h-100 shadow-sm overflow-hidden pt-2"> <img
                                                src="{{ asset('./images/iphone-16-pro-max.webp') }}" class="card-img-top"
                                                alt="Sản phẩm 1">
                                            <div class="card-body">
                                                <h6 class="card-title text-truncate" style="max-width: 100%;"> Tên sản phẩm
                                                    rất rất dài vượt quá khung hiển thị </h6>
                                                <p class="card-text text-danger fw-bold">1.200.000₫</p> <span
                                                    class="btn btn-primary btn-sm">Mua ngay</span>
                                            </div>
                                        </div>
                                    </a> </div>
                                <div class="col-md-4 mb-3"> <a href="#" class="text-decoration-none text-dark">
                                        <div class="card h-100 shadow-sm overflow-hidden pt-2"> <img
                                                src="{{ asset('./images/iphone-16-pro-max.webp') }}" class="card-img-top"
                                                alt="Sản phẩm 1">
                                            <div class="card-body">
                                                <h6 class="card-title text-truncate" style="max-width: 100%;"> Tên sản phẩm
                                                    rất rất dài vượt quá khung hiển thị </h6>
                                                <p class="card-text text-danger fw-bold">1.200.000₫</p> <span
                                                    class="btn btn-primary btn-sm">Mua ngay</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Côt 2 --}}
            <div class="col-md-6 d-flex flex-column">
                <div id="product-info">
                    <h1 class="product-title fs-3 fw-bolder mb-2">iPhone 16 Pro Max 256GB – NEW</h1>
                    <div class="price-box">
                        <div
                            class="price_container d-flex flex-row flex-wrap align-items-center justify-content-between mt-2">
                            <div class="me-2">
                                <strong class="fs-4 pt-0 d-inline price_val text-danger">
                                    33.490.000₫
                                </strong>
                            </div>
                            <div class="fs-14px text-end">
                                <span>Trả góp từ: </span>
                                <strong class="price2_val text-danger d-inline fs-14px pt-0">
                                    3.031.000₫/tháng
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Màu sắc -->
                <div id="product-colors" class="mt-4">
                    <div class="d-flex align-items-center flex-row justify-content-start flex-wrap">
                        <div class="me-2">
                            <strong class="me-2">Màu sắc:</strong>
                        </div>
                        <div class="color-box d-flex align-items-center flex-wrap">
                            <div class="color-swatch" style="background-color:#000000;" data-color="#000000"
                                data-value="Đen" data-slide="1"></div>
                            <div class="color-swatch" style="background-color:#c0c0c0;" data-color="#c0c0c0"
                                data-value="Bạc" data-slide="2"></div>
                            <div class="color-swatch" style="background-color:blue;" data-color="#1e73be"
                                data-value="Xanh" data-slide="0"></div>
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
                            <p class="mb-0 fw-bold text-danger">+350.000 ₫</p>
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
                            <a href="#"
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
                                <td>Màn hình Super Retina XDR 6,9 inch Độ phân giải 2868x1320 pixel với mật độ điểm ảnh 460
                                    ppi, Công nghệ ProMotion, Màn hình Luôn Bật</td>
                            </tr>
                            <tr>
                                <th scope="row">Hệ điều hành</th>
                                <td>iOS 18</td>
                            </tr>
                            <tr>
                                <th scope="row">CPU</th>
                                <td>Chip A18 Pro CPU 6 lõi với 2 lõi hiệu năng và 4 lõi tiết kiệm điện, Neural Engine 16 lõi
                                </td>
                            </tr>
                        </tbody>

                        <!-- Các dòng còn lại ẩn -->
                        <tbody id="extra-specs" style="display: none;">
                            <tr>
                                <th scope="row">RAM</th>
                                <td>8 GB</td>
                            </tr>
                            <tr>
                                <th scope="row">Bộ nhớ trong</th>
                                <td>128 GB</td>
                            </tr>
                            <tr>
                                <th scope="row">Camera chính</th>
                                <td>108 MP + 12 MP + 8 MP</td>
                            </tr>
                            <tr>
                                <th scope="row">Camera trước</th>
                                <td>108 MP + 12 MP + 8 MP</td>
                            </tr>
                            <tr>
                                <th scope="row">Pin</th>
                                <td>4500 mAh, sạc nhanh 65W</td>
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
@stop
