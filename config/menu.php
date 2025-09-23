<?php

return [
    [
        'title' => 'Tổng quan',
        'icon' => 'bi bi-house-fill',
        'route' => 'admin.dashboard.index',
        'children' => []
    ],
    [
        'title' => 'Banner',
        'icon' => 'bi bi-image',
        'children' => [
            ['title' => 'Thêm banner mới', 'icon' => 'bi bi-folder-plus', 'route' => 'admin.banner.add.index'],
            ['title' => 'Danh sách banner', 'icon' => 'bi bi-card-list', 'route' => 'admin.banner.list.index']
        ]
    ],
    [
        'title' => 'Danh mục',
        'icon' => 'bi bi-list-ul',
        'children' => [
            ['title' => 'Thêm danh mục mới', 'icon' => 'bi bi-folder-plus', 'route' => 'admin.category.add.index'],
            ['title' => 'Danh sách danh mục', 'icon' => 'bi bi-card-list', 'route' => 'admin.category.list.index']
        ]
    ],
    [
        'title' => 'Thương hiệu',
        'icon' => 'bi bi-shop',
        'children' => [
            ['title' => 'Danh sách thương hiệu', 'icon' => 'bi bi-card-list', 'route' => 'admin.brand.list.index'],
        ]
    ],
    [
        'title' => 'Sản phẩm',
        'icon' => 'bi bi-cart',
        'children' => [
            ['title' => 'Thêm sản phẩm', 'icon' => 'bi bi-folder-plus', 'route' => 'admin.product.add.index'],
            ['title' => 'Danh sách sản phẩm', 'icon' => 'bi bi-card-list', 'route' => 'admin.product.list.index'],
            ['title' => 'Sản phẩm nổi bật', 'icon' => 'bi bi-star', 'route' => 'admin.product.featured.index']
        ]
    ],
    [
        'title' => 'Quản lý đơn hàng',
        'icon' => 'bi bi-bag',
        'children' => [
            ['title' => 'Danh sách đơn hàng', 'icon' => 'bi bi-card-list', 'route' => 'admin.order.list.index'],
            ['title' => 'Tạo đơn hàng mới', 'icon' => 'bi bi-folder-plus', 'route' => ''],
            ['title' => 'Yêu cầu hủy đơn', 'icon' => 'bi bi-arrow-repeat', 'route' => 'admin.order.request.index']
        ]
    ],
    [
        'title' => 'Quản lý bài viết',
        'icon' => 'bi bi-file-earmark-post',
        'children' => [
            ['title' => 'Thêm bài viết', 'icon' => 'bi bi-plus-square-fill', 'route' => 'admin.blog.create.index'],
            ['title' => 'Danh sách bài viết' , 'icon' => 'bi bi-card-list', 'route' => 'admin.blog.list.index']
        ]
    ],
    [
        'title' => 'Quản lý tài khoản',
        'icon' => 'bi bi-person-circle',
        'children' => [
            ['title' => 'Tài khoản nhân viên', 'icon' => 'bi bi-person-badge-fill', 'route' => ''],
            ['title' => 'Tài khoản khách hàng', 'icon' => 'bi bi-people', 'route' => '']
        ]
    ],
    [
        'title' => 'Thống kê',
        'icon' => 'bi bi-graph-up-arrow',
        'children' => [
            ['title' => 'Thống kê doanh số', 'icon' => 'bi bi-graph-up-arrow', 'route' => '']
        ]
    ]
];