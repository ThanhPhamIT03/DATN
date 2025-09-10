@extends('admin.layouts.master')

@section('title', 'Danh sách sản phẩm')

@section('script')

@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Sản phẩm</a></li>
    <li class="breadcrumb-item" aria-current="page">Danh sách sản phẩm</li>
@stop

@section('content')
    <div class="container mt-2 pb-4">
        <h3 class="mb-4">
            Danh sách Sản phẩm
        </h3>

        {{-- Bộ lọc --}}
        <div class="row mb-3">
            <div class="col-md-3">
                <input type="text" name="keyword" class="form-control" placeholder="Tìm theo tên..."
                    value="{{ request('keyword') }}">
            </div>

            <div class="col-md-3">
                <select name="category_id" class="form-select">
                    <option value="">-- Chọn danh mục --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <select name="brand_id" class="form-select">
                    <option value="">-- Chọn thương hiệu --</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <select name="condition" class="form-select">
                    <option value="">-- Chọn tình trạng --</option>
                    <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>Mới</option>
                    <option value="used" {{ request('condition') == 'used' ? 'selected' : '' }}>Đã qua sử dụng</option>
                </select>
            </div>
        </div>

        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th style="text-align: center;" scope="col">Tên</th>
                    <th style="text-align: center;" scope="col">Danh mục</th>
                    <th style="text-align: center;" scope="col">Thương hiệu</th>
                    <th style="text-align: center;" scope="col">Model</th>
                    <th style="text-align: center;" scope="col">Hình ảnh</th>
                    <th style="text-align: center;" scope="col">Tình trạng</th>
                    <th style="text-align: center;" scope="col">Trạng thái</th>
                    <th style="text-align: center;" scope="col">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td class="text-center">{{ $product->name }}</td>
                        <td class="text-center">{{ $product->category->name ?? 'N/A' }}</td>
                        <td class="text-center">{{ $product->brand->name ?? 'N/A' }}</td>
                        <td class="text-center">{{ $product->model ?? 'N/A' }}</td>
                        <td style="text-align: center;">
                            <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}"
                                style="width: 50px; height: auto;" />
                        </td>
                        <td class="text-center">{{ $product->condition ?? 'N/A' }}</td>
                        <td style="text-align: center;">
                            <select class="form-select form-select-sm category-status" data-id="{{ $product->id }}">
                                <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Pending</option>
                                <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Active</option>
                            </select>
                        </td>
                        <td style="text-align: center;">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown">
                                    Hành động
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item edit-product" href="javascript:void(0);"
                                            data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                            data-description="{{ $product->description }}"
                                            data-image="{{ $product->image }}"
                                            data-edit="{{ route('admin.product.list.edit') }}">
                                            Sửa
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-danger delete-product" href="javascript:void(0);"
                                            data-id="{{ $product->id }}"
                                            data-delete="{{ route('admin.product.list.delete') }}">
                                            Xoá
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Không có sản phẩm nào</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Phân trang --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $products->links() }}
        </div>
    </div>
@stop
