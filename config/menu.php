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
            ['title' => 'Thêm sản phẩm mới', 'icon' => 'bi bi-folder-plus', 'route' => 'admin.product.add.index'],
            ['title' => 'Danh sách sản phẩm', 'icon' => 'bi bi-card-list', 'route' => 'admin.product.list.index'],
            ['title' => 'Danh sách biến thể', 'icon' => 'bi bi-list-ul', 'route' => 'admin.product.list.variants.index'],
        ]
    ]
];