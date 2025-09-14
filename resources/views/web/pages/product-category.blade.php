@extends('web.layouts.master')

@section('title', 'Danh mục sản phẩm')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
    <li class="breadcrumb-item"><a href="#">Danh mục</a></li>
    <li class="breadcrumb-item" aria-current="page">{{ $curentCategory->name }}</li>
@stop

@section('script')
    <script type="module">
        // Xử lý phần filter
        $(document).ready(function() {
            $('.auto-submit').on('change', function() {
                $('#filterForm').submit();
            });
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
                    <form id="filterForm" method="GET"
                        action="{{ route('web.product-category.index', $curentCategory->id) }}">
                        <div class="d-flex gap-3 mt-2 mt-md-0">
                            <div class="sort-item">
                                <select name="sort" id="sortSelect" class="form-select auto-submit">
                                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Phổ biến
                                    </option>
                                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá:
                                        cao - thấp</option>
                                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá:
                                        thấp - cao</option>
                                </select>
                            </div>
                            <div class="sort-item">
                                <select name="brand" id="brandSelect" class="form-select auto-submit">
                                    <option value="">-- Chọn hãng sản xuất --</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Sản phẩm --}}
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-4 pt-3 pb-4">
                @forelse ($products as $product)
                    <div class="col">
                        <a href="{{ route('web.product.index', $product->id) }}" class="text-decoration-none text-dark d-block h-100">
                            <div class="card position-relative shadow-sm rounded-3 border-0 h-100">
                                <div class="position-absolute bg-danger text-white px-2 py-1 small custom-badge-left">
                                    Giảm {{ $product->discount }}%
                                </div>
                                <div class="position-absolute bg-primary text-white px-2 py-1 small custom-badge-right">
                                    Trả góp 0%
                                </div>
                                <img src="{{ asset('storage/' . $product->thumbnail) }}" class="card-img-top img-product"
                                    alt="{{ $product->name }}">
                                <div class="card-body p-2">
                                    <h6 class="card-title mb-1 one-line-ellipsis"
                                        style="font-size: 0.95rem; font-weight: 500;">
                                        {{ $product->name }}
                                    </h6>
                                    <div class="mb-1">
                                        <span class="text-danger fw-bold" style="font-size: 1.1rem;">
                                            {{ number_format($product->variants->first()->sale_price, 0, ',', '.') }}₫
                                        </span>
                                        <span class="text-muted text-decoration-line-through small">
                                            {{ number_format($product->variants->first()->price, 0, ',', '.') }}₫
                                        </span>
                                    </div>
                                    <div class="bg-light border rounded px-2 py-1 small text-dark mb-1"
                                        style="font-size: 0.75rem;">
                                        Member giảm đến 297.000đ
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div style="width: 100%;">
                        <div class="d-flex justify-content-center align-items-center py-5">
                            <span class="text-danger fw-bold fst-italic">Không có sản phẩm nào.</span>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
        {{-- Phân trang --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $products->onEachSide(1)->links() }}
        </div>
    </div>
    <div class="overlay" style="display: none;"></div>
@stop
