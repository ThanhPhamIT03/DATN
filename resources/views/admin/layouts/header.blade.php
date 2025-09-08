<section id="admin-header">
    <div class="d-flex align-items-center justify-content-between" style="height: 76px;">
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
                    <span class="notif-badge">3</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notifButton">
                    <li><a class="dropdown-item" href="#">Thông báo 1</a></li>
                    <li><a class="dropdown-item" href="#">Thông báo 2</a></li>
                    <li><a class="dropdown-item" href="#">Thông báo 3</a></li>
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
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Trở về trang mua hàng</a></li>
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
