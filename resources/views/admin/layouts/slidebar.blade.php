<section id="admin-slidebar" class="p-2 m-0">
    {{-- Logo --}}
    <div class="admin-logo">
        <h6 class="m-0">Sơn Thảo Mobile</h6>
        <p>Trang quản trị</p>
    </div>

    {{-- Menu --}}
    <div class="admin-menu list-group pt-4">
        <!-- Menu cha -->
        <a href="/category/list"
            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
            Danh mục
            <i class="bi bi-chevron-down"></i>
        </a>
        <div class="collapse" id="menuCategory">
            <a href="/category/add" class="list-group-item list-group-item-action active-item">Thêm danh mục</a>
            <a href="/category/list" class="list-group-item list-group-item-action active-item">Danh sách danh mục</a>
        </div>

        <!-- Banner -->
        <a href="/banner/list"
            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
            Banner
            <i class="bi bi-chevron-down"></i>
        </a>
        <div class="collapse" id="menuBanner">
            <a href="/banner/add" class="list-group-item list-group-item-action active-item">Thêm banner mới</a>
            <a href="/banner/list" class="list-group-item list-group-item-action active-item">Danh sách banner</a>
        </div>
    </div>
    <style>
        #admin-slidebar {
            background-color: #2F3C54;
            height: 100vh;
            color: #fff;
        }

        .admin-logo {
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding-bottom: 1rem;
            margin-bottom: 1rem;
        }

        .admin-logo h6 {
            color: #ffffff;
            font-size: 22px;
            font-weight: 600;
            text-align: center;
        }

        .admin-logo p {
            color: #a0a9b8;
            text-align: center;
            font-size: 13px;
        }

        .admin-menu .list-group-item {
            background-color: transparent;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            margin-bottom: 4px;
            transition: all 0.2s ease-in-out;
            font-size: 16px;
        }

        .admin-menu .list-group-item:hover,
        .admin-menu .list-group-item:focus {
            background-color: #1f2a42;
            color: #fff;
        }

        .admin-menu .collapse .list-group-item {
            padding-left: 1rem;
            font-size: 0.9rem;
            color: #cfd3dc;
            border-radius: 5px;
            font-size: 16px;
        }

        .admin-menu .collapse .list-group-item:hover {
            background-color: #1f2a42;
            color: #ffffff;
        }

        .admin-menu .bi-chevron-down {
            transition: transform 0.2s;
        }

        .admin-menu>a.list-group-item.d-flex .bi-chevron-down {
            transition: transform 0.2s;
        }

        .admin-menu>a.list-group-item.d-flex[aria-expanded="true"] .bi-chevron-down {
            transform: rotate(180deg);
        }

        /* Menu con active theo class active-item */
        .admin-menu .collapse .list-group-item.active-item {
            background-color: #162136 !important;
            color: #ffffff !important;
            font-weight: 500;
        }

        /* Menu cha nếu menu con active */
        .admin-menu>a.list-group-item.d-flex.active-item-parent {
            background-color: #1f2a42 !important;
            color: #ffffff !important;
            font-weight: 600;
        }
    </style>
</section>
