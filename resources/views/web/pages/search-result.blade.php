@extends('web.layouts.master')

@section('title', 'Kết quả tìm kiếm')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
    <li class="breadcrumb-item"><a href="#">Tìm kiếm</a></li>
    <li class="breadcrumb-item" aria-current="page">iPhone 16 Pro Max</li>
@endsection

@section('script')
    <script type="module">
        $(document).ready(function() {
            $('.dropdown-menu .dropdown-item').on('click', function(e) {
                e.preventDefault();
                var sortType = $(this).data('sort');
                var htmlContent = $(this).html();
                $('#sortDropdown').html(htmlContent);
                console.log("Sắp xếp theo:", sortType);
            });
        });
    </script>
@stop

@section('content')
    <div class="container-xl pb-4">
        <h4 class="pb-4">Kết quả tìm kiếm cho: <span class="text-primary">iPhone 16 Pro Max</span></h4>
        <h5 class="pb-2">Sắp xếp theo</h5>

        <div class="dropdown pb-4 mb-4">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="sortDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-arrow-down-up me-1"></i> Mặc định
            </button>
            <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                <li><a class="dropdown-item" href="#" data-sort="default"><i class="bi bi-arrow-down-up me-1"></i> Mặc định</a></li>
                <li><a class="dropdown-item" href="#" data-sort="price-desc"><i class="bi bi-sort-down"></i> Giá: Cao → Thấp</a></li>
                <li><a class="dropdown-item" href="#" data-sort="price-asc"><i class="bi bi-sort-up"></i>Giá: Thấp → Cao</a></li>
            </ul>
        </div>

        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-4">
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
                            <div class="bg-light border rounded px-2 py-1 small text-dark mb-1" style="font-size: 0.75rem;">
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
                            <div class="bg-light border rounded px-2 py-1 small text-dark mb-1" style="font-size: 0.75rem;">
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
                            <div class="bg-light border rounded px-2 py-1 small text-dark mb-1" style="font-size: 0.75rem;">
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
        </div>
    </div>

    <div class="overlay" style="display: none;"></div>
@stop
