<section>
    <div class="container-xl p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="m-0 fearture-phone-heading">Phụ kiện</h4>
            <a href="{{ route('web.product-category.index', $accessoryId) }}" class="view-more">Xem tất cả</a>
        </div>

        <div class="row g-3">
            @foreach ($accessoryFeatured as $item)
                <div class="col-6 col-sm-4 col-md-2">
                    <a href="#" class="d-block text-center p-3 rounded text-decoration-none h-100 card-custom">
                        <img src="{{ asset('storage/' . $item->thumbnail) }}" class="img-fluid mb-2"
                            alt="{{ $item->name }}" style="max-height: 60px;">

                        <!-- Tên sản phẩm, cố định chiều cao, quá dài sẽ hiển thị ... -->
                        <div class="fw-medium small text-dark text-truncate mb-3"
                            style="max-width: 100%; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $item->name }}
                        </div>

                        <!-- Giá cố định -->
                        @php
                            $discountPrice = $item->display_price - $item->display_price * ($item->discount / 100);
                        @endphp
                        <span class="text-danger fw-bold" style="font-size: 1rem;">
                            {{ number_format($discountPrice ?? $item->display_price, 0, ',', '.') }}₫
                        </span>
                        @if ($discountPrice)
                            <p class="text-muted text-decoration-line-through small">
                                {{ number_format($item->display_price, 0, ',', '.') }}₫
                            </p>
                        @endif
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
