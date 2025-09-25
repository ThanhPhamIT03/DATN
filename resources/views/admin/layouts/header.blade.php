<section id="admin-header">
    <div class="d-flex align-items-center justify-content-between" style="height: 66px;">
        <!-- Search + Fullscreen -->
        <div class="admin-header-search d-flex align-items-center">
            <!-- Fullscreen button -->
            <button id="btn-toggle-sidebar" class="btn btn-light btn-action me-2">
                <i class="bi bi-arrows-fullscreen"></i>
            </button>

            <!-- Search box -->
            <input type="text" class="form-control" style="width: 300px;" placeholder="Tìm kiếm...">
            <button class="btn btn-primary ms-2">
                <i class="bi bi-search"></i>
            </button>
        </div>

        <!-- Actions -->
        <div class="d-flex align-items-center">
            <!-- Thông báo -->
            <div class="dropdown me-4">
                <button class="btn btn-light btn-action position-relative" type="button" id="notifButton"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell"></i>
                    <!-- Badge nhỏ góc trên phải -->
                    <span class="notif-badge">{{ $notifications->count() }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end p-2 shadow-lg" aria-labelledby="notifButton"
                    style="width: 500px; max-height: 350px; overflow-y: auto; border-radius: 0.75rem;">
                    <li class="dropdown-header fw-bold">Thông báo</li>

                    @forelse($notifications as $noti)
                        @if ($noti->type == 'request')
                            <li>
                                <a class="dropdown-item d-flex align-items-start mark-as-read"
                                    data-id="{{ $noti->id }}" data-url="{{ route('admin.notify.read') }}"
                                    data-redirect="{{ route('admin.order.request.index') }}"
                                    href="#">
                                    <div class="me-2">
                                        <i class="bi bi-bell-fill text-danger"></i>
                                    </div>
                                    <div class="pe-2">
                                        <div class="fw-semibold">Yêu cầu hủy đơn</div>
                                        <small class="text-muted">
                                            Bạn vừa nhận được yêu cầu hủy đơn #{{ $noti->notifiable->order_code }}
                                        </small><br>
                                        <small class="text-primary">{{ $noti->created_at->diffForHumans() }}</small><br>

                                        @if ($noti->is_read == 1)
                                            <span class="badge bg-success">Đã đọc</span>
                                        @else
                                            <span class="badge bg-warning text-dark mark-as-read-btn">
                                                Chưa đọc
                                            </span>
                                        @endif
                                    </div>
                                </a>
                            </li>
                        @elseif($noti->type == 'order')
                            <li>
                                <a class="dropdown-item d-flex align-items-start mark-as-read"
                                    data-id="{{ $noti->id }}" data-url="{{ route('admin.notify.read') }}"
                                    data-redirect="{{ route('admin.order.list.index') }}"
                                    href="#">
                                    <div class="me-2">
                                        <i class="bi bi-bell-fill text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Đơn hàng mới</div>
                                        <small class="text-muted">Bạn vừa nhận được yêu cầu xác nhận đơn
                                            #{{ $noti->notifiable->order_code }}</small><br>
                                        <small class="text-primary">{{ $noti->created_at->diffForHumans() }}</small>
                                        <br>
                                        @if ($noti->is_read == 1)
                                            <span class="badge bg-success">Đã đọc</span>
                                        @else
                                            <span class="badge bg-warning text-dark mark-as-read-btn">
                                                Chưa đọc
                                            </span>
                                        @endif
                                    </div>
                                </a>
                            </li>
                        @endif
                    @empty
                        <li class="text-danger text-center m-4">Hiện không có thông báo nào!</li>
                    @endforelse
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item text-center text-primary" href="{{ route('admin.notify.index') }}">
                            Xem tất cả thông báo
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Tài khoản -->
            <div class="dropdown">
                <button class="btn btn-light btn-action dropdown-toggle" type="button" id="accountButton"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountButton">
                    <li><a class="dropdown-item" href="#">Thông tin cá nhân</a></li>
                    <li><a class="dropdown-item" href="#">Cài đặt</a></li>
                    <li>
                        <form method="POST" action="{{ route('auth.logout.logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center">Đăng xuất</button>
                        </form>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="{{ route('home.index') }}">Trở về trang mua hàng</a></li>
                </ul>
            </div>
        </div>
    </div>

    <style>
        #admin-header {
            border-bottom: 2px solid #dbdbdb;
        }

        #notifButton+.dropdown-menu {
            min-width: 400px;
            font-size: 0.95rem;
            padding: 0.75rem 0;
        }

        #notifButton+.dropdown-menu .dropdown-item {
            padding: 0.5rem 1rem;
        }

        #notifButton+.dropdown-menu {
            background-color: #f8f9fa;
            border-radius: 0.5rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .notif-badge {
            position: absolute;
            top: 4px;
            right: 4px;
            background-color: #dc3545;
            color: white;
            font-size: 0.65rem;
            font-weight: bold;
            padding: 2px 5px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 16px;
            height: 16px;
            line-height: 1;
            box-shadow: 0 0 2px rgba(0, 0, 0, 0.3);
        }
    </style>
</section>
