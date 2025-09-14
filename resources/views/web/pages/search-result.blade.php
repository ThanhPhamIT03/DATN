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
            // Khi select thay đổi, submit form #filterForm
            $('.auto-submit').on('change', function() {
                $('#filterForm').submit();
            });
        });
    </script>
@stop

@section('content')
    <div class="container-xl pb-4">
        <h4 class="pb-4">Kết quả tìm kiếm cho: <span class="text-primary">{{ $keyword }}</span></h4>
        <h5 class="pb-2">Sắp xếp theo</h5>

        <form id="filterForm" method="GET" action="{{ route('web.search.index') }}">
            <div class="row pb-4 mb-4">
                <div class="col-3">
                    <div class="dropdown">
                        <div class="sort-item">
                            <input type="hidden" name="keyword" value="{{ $keyword }}">
                            <select name="sort" id="sortSelect" class="form-select auto-submit">
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Tất cả</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá: cao
                                    - thấp</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá: thấp -
                                    cao</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        @if ($searchResults->isEmpty())
            <div class="d-flex flex-column justify-content-center align-items-center" style="height: 50vh;">
                <i class="bi bi-search text-muted" style="font-size: 4rem;"></i>
                <h5 class="mt-3 text-muted">Không có kết quả nào.</h5>
                <p class="text-muted text-center">Thử kiểm tra lại từ khoá hoặc thử tìm kiếm khác.</p>
                <a href="{{ route('home.index') }}" class="btn btn-primary mt-3">Quay lại trang chủ</a>
            </div>
        @else
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-4">
                @foreach ($searchResults as $item)
                    <div class="col">
                        <a href="{{ route('web.product.index', $item->id) }}"
                            class="text-decoration-none text-dark d-block h-100">
                            <div class="card position-relative shadow-sm rounded-3 border-0 h-100">
                                <div class="position-absolute bg-danger text-white px-2 py-1 small custom-badge-left">
                                    Giảm {{ $item->discount }}%
                                </div>
                                <div class="position-absolute bg-primary text-white px-2 py-1 small custom-badge-right">
                                    Trả góp 0%
                                </div>
                                <img src="{{ asset('storage/' . $item->thumbnail) }}" class="card-img-top img-product"
                                    alt="{{ $item->name }}">
                                <div class="card-body p-2">
                                    <h6 class="card-title mb-1 two-line-ellipsis"
                                        style="font-size: 0.95rem; font-weight: 500;">
                                        {{ $item->name }}
                                    </h6>
                                    <div class="mb-1">
                                        <span class="text-danger fw-bold" style="font-size: 1.1rem;">
                                            {{ number_format($item->variants->first()->sale_price, 0, ',', '.') }}₫
                                        </span>
                                        <span class="text-muted text-decoration-line-through small">
                                            {{ number_format($item->variants->first()->price, 0, ',', '.') }}₫
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
                @endforeach
            </div>
        @endif

        <!-- Phân trang -->
        <div class="d-flex justify-content-center mt-3">
            {{ $searchResults->onEachSide(1)->links() }}
        </div>
    </div>
    <div class="overlay" style="display: none;"></div>
@stop
