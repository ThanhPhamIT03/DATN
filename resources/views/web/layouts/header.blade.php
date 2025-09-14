<section class="header">
    <div class="header-top d-flex align-items-center justify-content-center overflow-hidden">
        <ul class="slider-message m-0 list-unstyled">
            <li><strong>Miễn phí vận chuyển với đơn hàng trên 300K!</strong></li>
            <li><strong>Giảm ngay 200K khi đặt hàng online!</strong></li>
            <li><strong>Giảm ngay 500K đối với khách hàng là học sinh & sinh viên!</strong></li>
            <li><strong>Giảm 2% đối với thành viên!</strong></li>
        </ul>
    </div>
    <div class="header-bottom">
        <div class="container-xl header-nav d-flex align-items-center justify-content-between">
            <div class="header-logo">
                <a href="{{ route('home.index') }}">
                    <img src="{{ asset('images/default/logo-website.png') }}">
                </a>
            </div>

            <div class="header-menu d-flex align-items-center justify-content-between">
                {{-- Danh mục --}}
                <div class="category btn-cus me-3">
                    <i class="bi bi-card-list"></i>
                    <span>Danh mục</span>
                    <i class="bi bi-chevron-down icon icon-down"></i>
                </div>

                {{-- Category block --}}
                <div class="category-block">
                    <ul>
                        @foreach ($categories as $category)
                            <li><a href="{{ route('web.product-category.index', $category->id) }}">
                                    {{ $category->name }}
                                    <i class="bi bi-chevron-right last-icon"></i></a></li>
                        @endforeach
                    </ul>
                </div>

                {{-- Số điện thoại --}}
                <div class="call-buy btn-cus me-3">
                    <i class="bi bi-telephone"></i>
                    <a href="tel:0337005347">0337.005.347</a>
                </div>
            </div>

            <form class="search-container d-flex justify-content-between ps-2">
                <input type="text" placeholder="Nhập từ khoá tìm kiếm ..." required>
                <button type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>

            {{-- Search history container --}}
            <div class="search-history">
                <div class="d-flex align-items-center justify-content-between search-history-title p-4">
                    <h4 class="p-0 m-0">Lịch sử tìm kiếm <i class="bi bi-clock-history"></i></h4>
                    <a href="#">Xoá toàn bộ lịch sử <i class="bi bi-trash"></i></a>
                </div>
                <ul class="search-history-list">
                    <li><a href="#">iPhone 16 Pro Max</a></li>
                    <li><a href="#">iPhone 16 Pro Max</a></li>
                    <li><a href="#">iPhone 16 Pro Max</a></li>
                    <li><a href="#">iPhone 16 Pro Max</a></li>
                </ul>
                <div class="pt-0 ps-4 pe-4 pb-4 search-history-title">
                    <h4 class="p-0 m-0">Xu hướng tìm kiếm <i class="bi bi-fire"></i></h4>
                </div>
                <ul class="d-flex flex-wrap gap-2 search-trend">
                    <li><a href="#">iPhone 16 Pro Max</a></li>
                    <li><a href="#">iPhone 16 Pro Max</a></li>
                    <li><a href="#">iPhone 16 Pro Max</a></li>
                    <li><a href="#">iPhone 16 Pro Max</a></li>
                </ul>
            </div>

            <div class="header-action d-flex align-items-center justify-content-between">
                {{-- Giỏ hàng --}}
                <div class="btn-cus me-3 ms-3 position-relative" id="cart"
                    onclick="window.location.href='{{ route('web.cart.index') }}'">
                    <span>Giỏ hàng</span>
                    <i class="bi bi-cart3 icon-act"></i>

                    <!-- Badge hiển thị số lượng -->
                    @auth
                        <span id="cart-count"
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $countCartItem }}
                        </span>
                    @endauth
                </div>
                {{-- Tài khoản --}}
                {{-- Chưa đăng nhập --}}
                @guest
                    <div class="btn-cus" id="account">
                        <span>Đăng nhập</span>
                        <i class="bi bi-person-circle icon-act"></i>
                    </div>
                @endguest

                {{-- Đã đăng nhập --}}
                @auth
                    <div class="btn-cus" data-bs-toggle="offcanvas" data-bs-target="#accountPanel"
                        aria-controls="accountPanel">
                        <span>Tài khoản</span>
                        <i class="bi bi-person-circle icon-act"></i>
                    </div>

                    <div class="offcanvas offcanvas-end p-4" tabindex="-1" id="accountPanel"
                        aria-labelledby="accountPanelLabel">
                        <div class="offcanvas-header">
                            <h5 id="accountPanelLabel">Tài khoản</h5>
                            <button type="button" class="btn-close text-reset"
                                data-bs-dismiss="offcanvas"aria-label="Đóng"></button>
                        </div>

                        <div class="user-card shadow-sm mb-2">
                            <a href="{{ route('web.info.index') }}"
                                class="card-body p-2 d-flex align-items-center justify-content-between text-decoration-none">
                                <img src="{{ asset('./images/default-avatar.png') }}" alt="Avatar"
                                    class="rounded-circle me-2" style="width:40px; height:40px;">
                                <div class="fw-bold flex-grow-1 text-center">
                                    {{ $user->name }}
                                </div>
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </div>
                        @if ($user->role == 'admin' || $user->role == 'sadmin')
                            <div class="user-card shadow-sm mb-2 mt-2">
                                <a href="{{ route('admin.dashboard.index') }}"
                                    class="card-body p-2 d-flex align-items-center justify-content-between text-decoration-none">
                                    <img src="{{ asset('./images/dashboard-icon.png') }}" alt="Avatar"
                                        class="rounded-circle me-2" style="width:40px; height:40px;">
                                    <div class="fw-bold flex-grow-1 text-center">
                                        Trang quản trị
                                    </div>
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            </div>
                        @endif

                        <div class="mt-4">
                            <h5>Thông báo của tôi <i class="bi bi-bell"></i></h5>
                        </div>
                        <div class="mb-2 mt-2">
                            @forelse($orders as $order)
                                @if ($order->status == 'processing')
                                    <div class="card-body notify-card-item d-flex align-items-center warning">
                                        <i class="bi bi-bell-fill text-warning me-3" style="font-size: 1.5rem;"></i>
                                        <div class="flex-grow-1">
                                            <div>Đơn hàng <strong>{{ $order->order_code }}</strong> đang xử lý.</div>
                                            <a href="#" class="text-primary small">Xem chi tiết</a>
                                        </div>
                                    </div>
                                @elseif ($order->status == 'shipping')
                                    <div class="card-body notify-card-item d-flex align-items-center success">
                                        <i class="bi bi-bell-fill text-primary me-3" style="font-size: 1.5rem;"></i>
                                        <div class="flex-grow-1">
                                            <div>Đơn hàng <strong>{{ $order->order_code }}</strong> đang giao hàng.</div>
                                            <a href="#" class="text-primary small">Xem chi tiết</a>
                                        </div>
                                    </div>
                                @elseif ($order->status == 'success')
                                    <div class="card-body notify-card-item d-flex align-items-center success">
                                        <i class="bi bi-bell-fill text-success me-3" style="font-size: 1.5rem;"></i>
                                        <div class="flex-grow-1">
                                            <div>Đơn hàng <strong>{{ $order->order_code }}</strong> đã giao thành công.</div>
                                            <a href="#" class="text-primary small">Xem chi tiết</a>
                                        </div>
                                    </div>
                                @elseif($order->status == 'cancel')
                                    <div class="card-body notify-card-item d-flex align-items-center success">
                                        <i class="bi bi-bell-fill text-danger me-3" style="font-size: 1.5rem;"></i>
                                        <div class="flex-grow-1">
                                            <div>Đơn hàng <strong>{{ $order->order_code }}</strong> đã huỷ.</div>
                                            <a href="#" class="text-primary small">Xem chi tiết</a>
                                        </div>
                                    </div>
                                @endif
                            @empty
                            @endforelse
                        </div>
                    </div>
                @endauth

                {{-- Modal login and register --}}
                <div class="modal-login">
                    <div class="modal-login-heading p-4">
                        <h4>Đăng nhập - Đăng ký</h4>
                        <p>Vui lòng đăng nhập tài khoản thành viên để xem ưu đãi và thanh toán dễ dàng hơn.</p>
                    </div>
                    <div class="modal-login-btn d-flex align-items-center justify-content-around p-4">
                        <a class="button" href="{{ route('auth.register.index') }}"><span class="button-text">Đăng
                                ký</span></a>
                        <a class="button button-login" href="{{ route('auth.login.index') }}"><span
                                class="button-text">Đăng nhập</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .user-card {
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
        }

        .user-card:hover {
            border-color: #0d6efd;
            transform: scale(0.98);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            cursor: pointer;
        }

        .notify-card-item {
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-bottom: 12px;
            padding: 10px;
        }

        .success {
            border-color: var(--primary-color) !important;
        }

        .pending {
            border-color: #FFC007 !important;
        }

        .reject {
            border-color: red !important;
        }
    </style>
</section>
