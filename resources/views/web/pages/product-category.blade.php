@extends('web.layouts.master')

@section('title', 'Danh mục sản phẩm')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
    <li class="breadcrumb-item"><a href="#">Danh mục</a></li>
    <li class="breadcrumb-item" aria-current="page">Điện thoại</li>
@stop

@section('script')
    <script type="module">
        $(document).ready(function() {
            let currentSort = 'popular';
            let currentBrand = null;

            function handleSort() {
                $('.sort-item a.btn').on('click', function(e) {
                    e.preventDefault();
                    $('.sort-item a.btn').removeClass('active');
                    $(this).addClass('active');
                    currentSort = $(this).data('sort');
                    applyFilters();
                });
            }

            function handleBrandFilter() {
                $('.dropdown-menu .dropdown-item').on('click', function(e) {
                    e.preventDefault();
                    currentBrand = $(this).data('brand');
                    $('#brandDropdown').addClass('active').text(currentBrand);
                    applyFilters();
                });
            }

            function applyFilters() {
                console.log('Sort by:', currentSort, '| Brand:', currentBrand);
            }
            handleSort();
            handleBrandFilter();
        });
    </script>
@stop


@section('content')
    <div class="container-xl">
        <div class="container-xl">
            <div class="row align-items-center pb-4">
                <div class="col-12 d-flex justify-content-between align-items-center flex-wrap">
                    <!-- Title -->
                    <h4 class="mb-0">Sắp xếp theo: </h4>

                    <!-- Sort buttons -->
                    <div class="d-flex gap-3 mt-2 mt-md-0">
                        <div class="sort-item">
                            <a href="#" class="btn btn-outline-primary active" data-sort="popular">
                                <i class="bi bi-star me-2"></i> Phổ biến
                            </a>
                        </div>
                        <div class="sort-item">
                            <a href="#" class="btn btn-outline-primary" data-sort="price_desc">
                                <i class="bi bi-sort-down me-2"></i> Giá: cao - thấp
                            </a>
                        </div>
                        <div class="sort-item">
                            <a href="#" class="btn btn-outline-primary" data-sort="price_asc">
                                <i class="bi bi-sort-up me-2"></i> Giá: thấp - cao
                            </a>
                        </div>
                        <div class="dropdown sort-item">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="brandDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Hãng sản xuất
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="brandDropdown">
                                <li><a class="dropdown-item" href="#" data-brand="Apple">Apple</a></li>
                                <li><a class="dropdown-item" href="#" data-brand="Samsung">Samsung</a></li>
                                <li><a class="dropdown-item" href="#" data-brand="Xiaomi">Xiaomi</a></li>
                                <li><a class="dropdown-item" href="#" data-brand="Oppo">Oppo</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sản phẩm --}}
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-4 pt-3 pb-4">
                <div class="col">
                    <a href="{{ route('web.product.index') }}" class="text-decoration-none text-dark d-block h-100">
                        <div class="card position-relative shadow-sm rounded-3 border-0 h-100">
                            <div class="position-absolute bg-danger text-white px-2 py-1 small custom-badge-left">
                                Giảm 15%
                            </div>
                            <div class="position-absolute bg-primary text-white px-2 py-1 small custom-badge-right">
                                Trả góp 0%
                            </div>
                            <img src="{{ asset('./images/iphone-16-pro-max.webp') }}" class="card-img-top img-product"
                                alt="iPhone 16 Pro Max">
                            <div class="card-body p-2">
                                <h6 class="card-title mb-1 two-line-ellipsis" style="font-size: 0.95rem; font-weight: 500;">
                                    iPhone 16 Pro Max 256GB | Chính hãng VN/A
                                </h6>
                                <div class="mb-1">
                                    <span class="text-danger fw-bold" style="font-size: 1.1rem;">29.690.000₫</span>
                                    <span class="text-muted text-decoration-line-through small">34.990.000₫</span>
                                </div>
                                <div class="bg-light border rounded px-2 py-1 small text-dark mb-1"
                                    style="font-size: 0.75rem;">
                                    Member giảm đến 297.000đ
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col">
                    <a href="{{ route('web.product.index') }}" class="text-decoration-none text-dark d-block h-100">
                        <div class="card position-relative shadow-sm rounded-3 border-0 h-100">
                            <div class="position-absolute bg-danger text-white px-2 py-1 small custom-badge-left">
                                Giảm 15%
                            </div>
                            <div class="position-absolute bg-primary text-white px-2 py-1 small custom-badge-right">
                                Trả góp 0%
                            </div>
                            <img src="{{ asset('./images/iphone-16-pro-max.webp') }}" class="card-img-top img-product"
                                alt="iPhone 16 Pro Max">
                            <div class="card-body p-2">
                                <h6 class="card-title mb-1 two-line-ellipsis" style="font-size: 0.95rem; font-weight: 500;">
                                    iPhone 16 Pro Max 256GB | Chính hãng VN/A
                                </h6>
                                <div class="mb-1">
                                    <span class="text-danger fw-bold" style="font-size: 1.1rem;">29.690.000₫</span>
                                    <span class="text-muted text-decoration-line-through small">34.990.000₫</span>
                                </div>
                                <div class="bg-light border rounded px-2 py-1 small text-dark mb-1"
                                    style="font-size: 0.75rem;">
                                    Member giảm đến 297.000đ
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col">
                    <a href="{{ route('web.product.index') }}" class="text-decoration-none text-dark d-block h-100">
                        <div class="card position-relative shadow-sm rounded-3 border-0 h-100">
                            <div class="position-absolute bg-danger text-white px-2 py-1 small custom-badge-left">
                                Giảm 15%
                            </div>
                            <div class="position-absolute bg-primary text-white px-2 py-1 small custom-badge-right">
                                Trả góp 0%
                            </div>
                            <img src="{{ asset('./images/iphone-16-pro-max.webp') }}" class="card-img-top img-product"
                                alt="iPhone 16 Pro Max">
                            <div class="card-body p-2">
                                <h6 class="card-title mb-1 two-line-ellipsis" style="font-size: 0.95rem; font-weight: 500;">
                                    iPhone 16 Pro Max 256GB | Chính hãng VN/A
                                </h6>
                                <div class="mb-1">
                                    <span class="text-danger fw-bold" style="font-size: 1.1rem;">29.690.000₫</span>
                                    <span class="text-muted text-decoration-line-through small">34.990.000₫</span>
                                </div>
                                <div class="bg-light border rounded px-2 py-1 small text-dark mb-1"
                                    style="font-size: 0.75rem;">
                                    Member giảm đến 297.000đ
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col">
                    <a href="{{ route('web.product.index') }}" class="text-decoration-none text-dark d-block h-100">
                        <div class="card position-relative shadow-sm rounded-3 border-0 h-100">
                            <div class="position-absolute bg-danger text-white px-2 py-1 small custom-badge-left">
                                Giảm 15%
                            </div>
                            <div class="position-absolute bg-primary text-white px-2 py-1 small custom-badge-right">
                                Trả góp 0%
                            </div>
                            <img src="{{ asset('./images/iphone-16-pro-max.webp') }}" class="card-img-top img-product"
                                alt="iPhone 16 Pro Max">
                            <div class="card-body p-2">
                                <h6 class="card-title mb-1 two-line-ellipsis"
                                    style="font-size: 0.95rem; font-weight: 500;">
                                    iPhone 16 Pro Max 256GB | Chính hãng VN/A
                                </h6>
                                <div class="mb-1">
                                    <span class="text-danger fw-bold" style="font-size: 1.1rem;">29.690.000₫</span>
                                    <span class="text-muted text-decoration-line-through small">34.990.000₫</span>
                                </div>
                                <div class="bg-light border rounded px-2 py-1 small text-dark mb-1"
                                    style="font-size: 0.75rem;">
                                    Member giảm đến 297.000đ
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col">
                    <a href="{{ route('web.product.index') }}" class="text-decoration-none text-dark d-block h-100">
                        <div class="card position-relative shadow-sm rounded-3 border-0 h-100">
                            <div class="position-absolute bg-danger text-white px-2 py-1 small custom-badge-left">
                                Giảm 15%
                            </div>
                            <div class="position-absolute bg-primary text-white px-2 py-1 small custom-badge-right">
                                Trả góp 0%
                            </div>
                            <img src="{{ asset('./images/iphone-16-pro-max.webp') }}" class="card-img-top img-product"
                                alt="iPhone 16 Pro Max">
                            <div class="card-body p-2">
                                <h6 class="card-title mb-1 two-line-ellipsis"
                                    style="font-size: 0.95rem; font-weight: 500;">
                                    iPhone 16 Pro Max 256GB | Chính hãng VN/A
                                </h6>
                                <div class="mb-1">
                                    <span class="text-danger fw-bold" style="font-size: 1.1rem;">29.690.000₫</span>
                                    <span class="text-muted text-decoration-line-through small">34.990.000₫</span>
                                </div>
                                <div class="bg-light border rounded px-2 py-1 small text-dark mb-1"
                                    style="font-size: 0.75rem;">
                                    Member giảm đến 297.000đ
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col">
                    <a href="{{ route('web.product.index') }}" class="text-decoration-none text-dark d-block h-100">
                        <div class="card position-relative shadow-sm rounded-3 border-0 h-100">
                            <div class="position-absolute bg-danger text-white px-2 py-1 small custom-badge-left">
                                Giảm 15%
                            </div>
                            <div class="position-absolute bg-primary text-white px-2 py-1 small custom-badge-right">
                                Trả góp 0%
                            </div>
                            <img src="{{ asset('./images/iphone-16-pro-max.webp') }}" class="card-img-top img-product"
                                alt="iPhone 16 Pro Max">
                            <div class="card-body p-2">
                                <h6 class="card-title mb-1 two-line-ellipsis"
                                    style="font-size: 0.95rem; font-weight: 500;">
                                    iPhone 16 Pro Max 256GB | Chính hãng VN/A
                                </h6>
                                <div class="mb-1">
                                    <span class="text-danger fw-bold" style="font-size: 1.1rem;">29.690.000₫</span>
                                    <span class="text-muted text-decoration-line-through small">34.990.000₫</span>
                                </div>
                                <div class="bg-light border rounded px-2 py-1 small text-dark mb-1"
                                    style="font-size: 0.75rem;">
                                    Member giảm đến 297.000đ
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col">
                    <a href="{{ route('web.product.index') }}" class="text-decoration-none text-dark d-block h-100">
                        <div class="card position-relative shadow-sm rounded-3 border-0 h-100">
                            <div class="position-absolute bg-danger text-white px-2 py-1 small custom-badge-left">
                                Giảm 15%
                            </div>
                            <div class="position-absolute bg-primary text-white px-2 py-1 small custom-badge-right">
                                Trả góp 0%
                            </div>
                            <img src="{{ asset('./images/iphone-16-pro-max.webp') }}" class="card-img-top img-product"
                                alt="iPhone 16 Pro Max">
                            <div class="card-body p-2">
                                <h6 class="card-title mb-1 two-line-ellipsis"
                                    style="font-size: 0.95rem; font-weight: 500;">
                                    iPhone 16 Pro Max 256GB | Chính hãng VN/A
                                </h6>
                                <div class="mb-1">
                                    <span class="text-danger fw-bold" style="font-size: 1.1rem;">29.690.000₫</span>
                                    <span class="text-muted text-decoration-line-through small">34.990.000₫</span>
                                </div>
                                <div class="bg-light border rounded px-2 py-1 small text-dark mb-1"
                                    style="font-size: 0.75rem;">
                                    Member giảm đến 297.000đ
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col">
                    <a href="{{ route('web.product.index') }}" class="text-decoration-none text-dark d-block h-100">
                        <div class="card position-relative shadow-sm rounded-3 border-0 h-100">
                            <div class="position-absolute bg-danger text-white px-2 py-1 small custom-badge-left">
                                Giảm 15%
                            </div>
                            <div class="position-absolute bg-primary text-white px-2 py-1 small custom-badge-right">
                                Trả góp 0%
                            </div>
                            <img src="{{ asset('./images/iphone-16-pro-max.webp') }}" class="card-img-top img-product"
                                alt="iPhone 16 Pro Max">
                            <div class="card-body p-2">
                                <h6 class="card-title mb-1 two-line-ellipsis"
                                    style="font-size: 0.95rem; font-weight: 500;">
                                    iPhone 16 Pro Max 256GB | Chính hãng VN/A
                                </h6>
                                <div class="mb-1">
                                    <span class="text-danger fw-bold" style="font-size: 1.1rem;">29.690.000₫</span>
                                    <span class="text-muted text-decoration-line-through small">34.990.000₫</span>
                                </div>
                                <div class="bg-light border rounded px-2 py-1 small text-dark mb-1"
                                    style="font-size: 0.75rem;">
                                    Member giảm đến 297.000đ
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col">
                    <a href="{{ route('web.product.index') }}" class="text-decoration-none text-dark d-block h-100">
                        <div class="card position-relative shadow-sm rounded-3 border-0 h-100">
                            <div class="position-absolute bg-danger text-white px-2 py-1 small custom-badge-left">
                                Giảm 15%
                            </div>
                            <div class="position-absolute bg-primary text-white px-2 py-1 small custom-badge-right">
                                Trả góp 0%
                            </div>
                            <img src="{{ asset('./images/iphone-16-pro-max.webp') }}" class="card-img-top img-product"
                                alt="iPhone 16 Pro Max">
                            <div class="card-body p-2">
                                <h6 class="card-title mb-1 two-line-ellipsis"
                                    style="font-size: 0.95rem; font-weight: 500;">
                                    iPhone 16 Pro Max 256GB | Chính hãng VN/A
                                </h6>
                                <div class="mb-1">
                                    <span class="text-danger fw-bold" style="font-size: 1.1rem;">29.690.000₫</span>
                                    <span class="text-muted text-decoration-line-through small">34.990.000₫</span>
                                </div>
                                <div class="bg-light border rounded px-2 py-1 small text-dark mb-1"
                                    style="font-size: 0.75rem;">
                                    Member giảm đến 297.000đ
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col">
                    <a href="{{ route('web.product.index') }}" class="text-decoration-none text-dark d-block h-100">
                        <div class="card position-relative shadow-sm rounded-3 border-0 h-100">
                            <div class="position-absolute bg-danger text-white px-2 py-1 small custom-badge-left">
                                Giảm 15%
                            </div>
                            <div class="position-absolute bg-primary text-white px-2 py-1 small custom-badge-right">
                                Trả góp 0%
                            </div>
                            <img src="{{ asset('./images/iphone-16-pro-max.webp') }}" class="card-img-top img-product"
                                alt="iPhone 16 Pro Max">
                            <div class="card-body p-2">
                                <h6 class="card-title mb-1 two-line-ellipsis"
                                    style="font-size: 0.95rem; font-weight: 500;">
                                    iPhone 16 Pro Max 256GB | Chính hãng VN/A
                                </h6>
                                <div class="mb-1">
                                    <span class="text-danger fw-bold" style="font-size: 1.1rem;">29.690.000₫</span>
                                    <span class="text-muted text-decoration-line-through small">34.990.000₫</span>
                                </div>
                                <div class="bg-light border rounded px-2 py-1 small text-dark mb-1"
                                    style="font-size: 0.75rem;">
                                    Member giảm đến 297.000đ
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="overlay" style="display: none;"></div>
@stop
