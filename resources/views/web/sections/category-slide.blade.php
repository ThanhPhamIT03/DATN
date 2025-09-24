<section id="category-slide" class="py-4" style="background-color: var(--bgr-gray);">
    <div class="container">
        <div class="row gx-3 gy-4 justify-content-center category-slide">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="m-0 fearture-phone-heading" data-aos="fade-right" data-aos-duration="1000">Danh mục sản phẩm</h4>
            </div>
            <!-- Category Item -->
            @foreach($categories as $category)
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-duration="1000">
                    <div class="category-item position-relative overflow-hidden rounded shadow-sm"
                        onclick="location.href='#'" style="cursor: pointer;">
                        <img src="{{ asset('storage/' . $category->image ) }}" alt="{{ $category->name}}" class="w-100 h-100 object-cover">

                        <div
                            class="category-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end align-items-center text-white p-3 text-center">
                            <h5 class="mb-3 fw-bold">{{ $category->name }}</h5>
                            <a href="{{ route('web.product-category.index', $category->id) }}" class="btn btn-light btn-sm fw-medium px-3">Xem ngay</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <style>
        .category-item {
            height: 200px;
            position: relative;
            transition: transform 0.3s ease;
        }

        .category-item img {
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .category-item:hover img {
            transform: scale(1.05);
        }

        .category-overlay {
            background: rgba(0, 0, 0, 0.2);
            text-align: center;
            transition: background 0.3s ease;
        }

        .category-item:hover .category-overlay {
            background: rgba(0, 0, 0, 0.3);
            cursor: pointer;
        }

        .category-overlay h5 {
            font-size: 18px;
            font-weight: 600;
            color: #fff;
            text-shadow:
                0 1px 3px rgba(0, 0, 0, 0.8),
                0 0 10px rgba(0, 0, 0, 0.6);
            letter-spacing: 0.5px;
            margin-bottom: 1rem;
        }

        .category-overlay h5:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }

        .category-overlay .btn {
            font-size: 14px;
            border-radius: 10px;
            border: 1px solid transparent;
            color: var(--text-color);
            background-color: #ffff;
        }

        .category-overlay .btn:hover {
            cursor: pointer;
            border-color: #fff;
            color: #fff;
            background-color: transparent;
        }

        .object-cover {
            object-fit: cover;
        }
    </style>

</section>
