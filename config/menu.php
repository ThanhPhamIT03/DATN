<?php

return [
    [
        'title' => 'Tổng quan',
        'icon' => 'bi bi-house-fill',
        'route' => 'admin.dashboard.index',
        'roles' => ['admin', 'sadmin'], 
        'children' => []
    ],
    [
        'title' => 'Banner',
        'icon' => 'bi bi-image',
        'roles' => ['sadmin'], 
        'children' => [
            [
                'title' => 'Thêm banner mới',
                'icon' => 'bi bi-folder-plus',
                'route' => 'admin.banner.add.index',
                'roles' => ['sadmin']
            ],
            [
                'title' => 'Danh sách banner',
                'icon' => 'bi bi-card-list',
                'route' => 'admin.banner.list.index',
                'roles' => ['admin', 'sadmin']
            ],
        ]
    ],
    [
        'title' => 'Danh mục',
        'icon' => 'bi bi-list-ul',
        'roles' => ['sadmin'],
        'children' => [
            [
                'title' => 'Thêm danh mục mới',
                'icon' => 'bi bi-folder-plus',
                'route' => 'admin.category.add.index',
                'roles' => ['sadmin']
            ],
            [
                'title' => 'Danh sách danh mục',
                'icon' => 'bi bi-card-list',
                'route' => 'admin.category.list.index',
                'roles' => ['sadmin']
            ],
        ]
    ],
    [
        'title' => 'Thương hiệu',
        'icon' => 'bi bi-shop',
        'roles' => ['sadmin'],
        'children' => [
            [
                'title' => 'Danh sách thương hiệu',
                'icon' => 'bi bi-card-list',
                'route' => 'admin.brand.list.index',
                'roles' => ['sadmin']
            ],
        ]
    ],
    [
        'title' => 'Sản phẩm',
        'icon' => 'bi bi-cart',
        'roles' => ['admin', 'sadmin'],
        'children' => [
            [
                'title' => 'Thêm sản phẩm',
                'icon' => 'bi bi-folder-plus',
                'route' => 'admin.product.add.index',
                'roles' => ['admin', 'sadmin']
            ],
            [
                'title' => 'Danh sách sản phẩm',
                'icon' => 'bi bi-card-list',
                'route' => 'admin.product.list.index',
                'roles' => ['admin', 'sadmin']
            ],
            [
                'title' => 'Sản phẩm nổi bật',
                'icon' => 'bi bi-star',
                'route' => 'admin.product.featured.index',
                'roles' => ['admin', 'sadmin']
            ],
        ]
    ],
    [
        'title' => 'Quản lý đơn hàng',
        'icon' => 'bi bi-bag',
        'roles' => ['admin', 'sadmin'],
        'children' => [
            [
                'title' => 'Danh sách đơn hàng',
                'icon' => 'bi bi-card-list',
                'route' => 'admin.order.list.index',
                'roles' => ['admin', 'sadmin']
            ],
            [
                'title' => 'Tạo đơn hàng mới',
                'icon' => 'bi bi-folder-plus',
                'route' => 'admin.order.create.index',
                'roles' => ['sadmin']
            ],
            [
                'title' => 'Yêu cầu hủy đơn',
                'icon' => 'bi bi-arrow-repeat',
                'route' => 'admin.order.request.index',
                'roles' => ['admin', 'sadmin']
            ],
        ]
    ],
    [
        'title' => 'Quản lý bài viết',
        'icon' => 'bi bi-file-earmark-post',
        'roles' => ['admin', 'sadmin'],
        'children' => [
            [
                'title' => 'Thêm bài viết',
                'icon' => 'bi bi-plus-square-fill',
                'route' => 'admin.blog.create.index',
                'roles' => ['sadmin']
            ],
            [
                'title' => 'Danh sách bài viết',
                'icon' => 'bi bi-card-list',
                'route' => 'admin.blog.list.index',
                'roles' => ['admin', 'sadmin']
            ]
        ]
    ],
    [
        'title' => 'Quản lý tài khoản',
        'icon' => 'bi bi-person-circle',
        'roles' => ['sadmin'],
        'children' => [
            ['title' => 'Tài khoản nhân viên', 'icon' => 'bi bi-person-badge-fill', 'route' => 'admin.account.staff.index', 'roles' => ['sadmin']],
            ['title' => 'Tài khoản khách hàng', 'icon' => 'bi bi-people', 'route' => 'admin.account.customer.index', 'roles' => ['sadmin']],
        ]
    ],
    [
        'title' => 'Thống kê',
        'icon' => 'bi bi-graph-up-arrow',
        'roles' => ['sadmin'],
        'children' => [
            ['title' => 'Thống kê doanh số', 'icon' => 'bi bi-graph-up-arrow', 'route' => 'admin.revenue.index', 'roles' => ['sadmin']]
        ]
    ]
];
