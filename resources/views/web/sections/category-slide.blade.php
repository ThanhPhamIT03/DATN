<section id="category-slide" class="py-4" style="background-color: var(--bgr-gray);">
    <div class="container">
        <div class="row gx-3 gy-4 justify-content-center category-slide">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="m-0 fearture-phone-heading">Danh mục</h4>
            </div>
            <!-- Category Item -->
            <div class="col-6 col-md-3">
                <div class="category-item position-relative overflow-hidden rounded shadow-sm"
                    onclick="location.href='#'" style="cursor: pointer;">
                    <img src="{{ asset('./images/phone.jpeg') }}" alt="Điện thoại" class="w-100 h-100 object-cover">

                    <div
                        class="category-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end align-items-center text-white p-3 text-center">
                        <h5 class="mb-3 fw-bold">Điện thoại</h5>
                        <a href="#" class="btn btn-light btn-sm fw-medium px-3">Xem ngay</a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="category-item position-relative overflow-hidden rounded shadow-sm"
                    onclick="location.href='#'" style="cursor: pointer;">
                    <img src="{{ asset('./images/may-tinh-bang-3-800x450.jpg') }}" alt="Điện thoại"
                        class="w-100 h-100 object-cover">

                    <div
                        class="category-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end align-items-center text-white p-3 text-center">
                        <h5 class="mb-3 fw-bold">Máy tính bảng</h5>
                        <a href="#" class="btn btn-light btn-sm fw-medium px-3">Xem ngay</a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="category-item position-relative overflow-hidden rounded shadow-sm"
                    onclick="location.href='#'" style="cursor: pointer;">
                    <img src="{{ asset('./images/phu-kien-dien-thoai-gia-si-1.jpg') }}" alt="Điện thoại"
                        class="w-100 h-100 object-cover">

                    <div
                        class="category-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end align-items-center text-white p-3 text-center">
                        <h5 class="mb-3 fw-bold">Phụ kiện</h5>
                        <a href="#" class="btn btn-light btn-sm fw-medium px-3">Xem ngay</a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="category-item position-relative overflow-hidden rounded shadow-sm"
                    onclick="location.href='#'" style="cursor: pointer;">
                    <img src="{{ asset('./images/maycu6_1024x576.jpg') }}" alt="Điện thoại"
                        class="w-100 h-100 object-cover">

                    <div
                        class="category-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end align-items-center text-white p-3 text-center">
                        <h5 class="mb-3 fw-bold">Hàng cũ</h5>
                        <a href="#" class="btn btn-light btn-sm fw-medium px-3">Xem ngay</a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="category-item position-relative overflow-hidden rounded shadow-sm"
                    onclick="location.href='#'" style="cursor: pointer;">
                    <img src="{{ asset('./images/Anh-thumb-9-768x402.jpg') }}" alt="Điện thoại"
                        class="w-100 h-100 object-cover">

                    <div
                        class="category-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end align-items-center text-white p-3 text-center">
                        <h5 class="mb-3 fw-bold">Tin công nghệ</h5>
                        <a href="#" class="btn btn-light btn-sm fw-medium px-3">Xem ngay</a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="category-item position-relative overflow-hidden rounded shadow-sm"
                    onclick="location.href='#'" style="cursor: pointer;">
                    <img src="{{ asset('./images/promotion.jpg') }}" alt="Điện thoại" class="w-100 h-100 object-cover">

                    <div
                        class="category-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end align-items-center text-white p-3 text-center">
                        <h5 class="mb-3 fw-bold">Khuyến mãi</h5>
                        <a href="#" class="btn btn-light btn-sm fw-medium px-3">Xem ngay</a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="category-item position-relative overflow-hidden rounded shadow-sm"
                    onclick="location.href='#'" style="cursor: pointer;">
                    <img src="{{ asset('./images/maycu6_1024x576.jpg') }}" alt="Điện thoại"
                        class="w-100 h-100 object-cover">

                    <div
                        class="category-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end align-items-center text-white p-3 text-center">
                        <h5 class="mb-3 fw-bold">Thu cũ đổi mới</h5>
                        <a href="#" class="btn btn-light btn-sm fw-medium px-3">Xem ngay</a>
                    </div>
                </div>
            </div>
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
