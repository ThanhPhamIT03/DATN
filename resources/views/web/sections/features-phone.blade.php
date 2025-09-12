<section>
    <div class="container-xl p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="m-0 fearture-phone-heading">Điện thoại nổi bật</h4>
            <ul class="product-list">
                @foreach($brands as $brand)
                    <li>
                        <a href="#">{{ $brand->name }}</a>
                    </li>
                @endforeach
                <li>
                    <a href="#">Xem tất cả</a>
                </li>
            </ul>
        </div>
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-4">
            @foreach($featuredPhone as $item)
                <div class="col">
                    <a href="{{ route('web.product.index') }}" class="text-decoration-none text-dark d-block h-100">
                        <div class="card position-relative shadow-sm rounded-3 border-0 h-100">
                            <div class="position-absolute bg-danger text-white px-2 py-1 small custom-badge-left">
                                Giảm {{ $item->discount }}%
                            </div>
                            <div class="position-absolute bg-primary text-white px-2 py-1 small custom-badge-right">
                                Trả góp 0%
                            </div>
                            <img src="{{ asset('storage/' . $item->thumbnail) }}" class="card-img-top img-product" alt="{{ $item->name }}">
                            <div class="card-body p-2">
                                <h6 class="card-title mb-1 two-line-ellipsis" style="font-size: 0.95rem; font-weight: 500;">
                                    {{ $item->name }}
                                </h6>
                                <div class="mb-1">
                                    @php
                                        $discountPrice = $item->display_price - ($item->display_price * ($item->discount / 100));
                                    @endphp
                                    <span class="text-danger fw-bold" style="font-size: 1.1rem;">
                                        {{ number_format($discountPrice ?? $item->display_price, 0, ',', '.') }}₫
                                    </span>
                                    @if ($discountPrice)
                                    <span class="text-muted text-decoration-line-through small">
                                        {{ number_format($item->display_price, 0, ',', '.') }}₫
                                    </span>
                                    @endif
                                </div>
                                <div class="bg-light border rounded px-2 py-1 small text-dark mb-1" style="font-size: 0.75rem;">
                                    Member giảm đến 297.000đ
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
