@extends('admin.layouts.master')

@section('title', 'Danh sách sản phẩm')

@section('script')
    <script type="module">
        // Trạng thái sản phẩm
        $('.product-status').change(function() {
            $.ajax({
                url: "{{ route('admin.product.list.status') }}",
                type: "POST",
                data: {
                    id: $(this).data('id'),
                    status: $(this).val(),
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    if (res.success) {
                        Swal.fire('Thành công', res.message, 'success').then(() => {
                            location.reload();
                        });
                    } else {
                         Swal.fire('Thất bại', res.message, 'error').then(() => {
                            location.reload();
                        });
                    }
                },
                error: function() {
                    Swal.fire('Lỗi', 'Không thể cập nhật trạng thái!', 'error');
                }
            });
        });

        // Edit sản phẩm
        let currentUpdateUrl = null;

        $(document).on('click', '.edit-product', function() {
            let id = $(this).data('id');
            let name = $(this).data('name');
            let model = $(this).data('model');
            let description = $(this).data('description');
            let thumbnail = $(this).data('thumbnail');
            let discount = $(this).data('discount');

            currentUpdateUrl = $(this).data('edit');

            $('#editProductId').val(id);
            $('#editName').val(name);
            $('#editModel').val(model);
            $('#editDescription').val(description);
            $('#editDiscount').val(discount);
            $('#editImagePreview').attr('src', '/storage/' + thumbnail);

            let modal = new bootstrap.Modal(document.getElementById('editProductModal'));
            modal.show();
        });

        $('#editThumbnail').on('change', function() {
            const [file] = this.files;
            if (file) {
                $('#editImagePreview').attr('src', URL.createObjectURL(file));
            }
        });

        $('#editProductForm').submit(function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: currentUpdateUrl,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.success) {
                        Swal.fire('Thành công', res.message, 'success').then(() => {
                            let modalEl = document.getElementById('editProductModal');
                            let modal = bootstrap.Modal.getInstance(modalEl);
                            modal.hide();

                            $('#editProductModal').on('hidden.bs.modal', function() {
                                location.reload();
                            });
                        });
                    } else {
                        Swal.fire('Lỗi', res.message, 'error');
                    }
                },
                error: function() {
                    Swal.fire('Lỗi', 'Không thể cập nhật sản phẩm!', 'error');
                }
            });
        });

        // Xoá sản phẩm
        $(document).on('click', '.delete-product', function() {
            let id = $(this).data('id');
            let deleteUrl = $(this).data('delete');

            Swal.fire({
                title: "Bạn chắc chắn muốn xoá?",
                text: "Hành động này không thể hoàn tác!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Xoá",
                cancelButtonText: "Huỷ"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: deleteUrl,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id
                        },
                        success: function(res) {
                            if (res.success) {
                                Swal.fire("Đã xoá!", res.message, "success").then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire("Lỗi", res.message, "error");
                            }
                        },
                        error: function() {
                            Swal.fire("Lỗi", "Không thể xoá sản phẩm!", "error");
                        }
                    });
                }
            });
        });

        // Xử lý nút detail
        $(document).ready(function() {
            $('.detail-product').on('click', function(e) {
                e.preventDefault();

                var productId = $(this).data('id');
                var detailUrl = $(this).data('detail');

                window.location.href = detailUrl + '?id=' + productId;
            });
        });

        // Xử lý ô tìm kiếm
        $(document).ready(function() {
            var $input = $('#keywordInput');
            var $clear = $('.clear-btn');

            // Hiện nút x nếu input có giá trị
            function toggleClear() {
                if ($input.val().length > 0) {
                    $clear.show();
                } else {
                    $clear.hide();
                }
            }

            toggleClear(); // chạy lần đầu

            $input.on('input', toggleClear);

            $clear.click(function() {
                $input.val(''); // xóa giá trị
                $clear.hide(); // ẩn nút
                $input.focus(); // focus lại input
                $('#keywordForm').submit(); // gửi form để load lại index
            });
        });

        // Xử lý phần filter
        $(document).ready(function() {
            $('.auto-submit').on('change', function() {
                $('#filterForm').submit();
            });
        });
    </script>
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

        {{-- Form tìm kiếm --}}
        <form id="keywordForm" method="GET" action="{{ route('admin.product.list.index') }}">
            <div class="row mb-3">
                <div class="col-md-3 input-clear-wrapper">
                    <input type="text" name="keyword" id="keywordInput" class="form-control"
                        placeholder="Tìm theo tên sản phẩm..." value="{{ request('keyword') }}">
                    <button type="button" class="clear-btn">&times;</button>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
                </div>
            </div>
        </form>

        {{-- Bộ lọc --}}
        <form id="filterForm" method="GET" action="{{ route('admin.product.list.index') }}">
            <div class="row mb-3">
                <!-- Category -->
                <div class="col-md-3">
                    <select name="category_id" class="form-select auto-submit">
                        <option value="">-- Tất cả --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Brand -->
                <div class="col-md-3">
                    <select name="brand_id" class="form-select auto-submit">
                        <option value="">-- Tất cả --</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Condition -->
                <div class="col-md-3">
                    <select name="condition" class="form-select auto-submit">
                        <option value="">-- Tất cả --</option>
                        <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>Mới</option>
                        <option value="used" {{ request('condition') == 'used' ? 'selected' : '' }}>Đã qua sử dụng
                        </option>
                    </select>
                </div>
            </div>
        </form>

        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th style="text-align: center;" scope="col">Tên</th>
                    <th style="text-align: center;" scope="col">Danh mục</th>
                    <th style="text-align: center;" scope="col">Thương hiệu</th>
                    <th style="text-align: center;" scope="col">Model</th>
                    <th style="text-align: center;" scope="col">Giảm giá</th>
                    <th style="text-align: center;" scope="col">Hình ảnh</th>
                    <th style="text-align: center;" scope="col">Tình trạng</th>
                    <th style="text-align: center;" scope="col">Trạng thái</th>
                    <th style="text-align: center;" scope="col">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td class="text-center text-truncate" style="max-width: 200px;">
                            {{ $product->name }}
                        </td>
                        <td class="text-center">{{ $product->category->name ?? 'N/A' }}</td>
                        <td class="text-center">{{ $product->brand->name ?? 'N/A' }}</td>
                        <td class="text-center">{{ $product->model ?? 'N/A' }}</td>
                        <td class="text-center">
                            <div class="text-danger small">
                                Giảm {{ $product->discount }}%
                            </div>
                        </td>
                        <td style="text-align: center;">
                            <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}"
                                style="width: 50px; height: auto;" />
                        </td>
                        <td class="text-center">{{ $product->condition ?? 'N/A' }}</td>
                        <td style="text-align: center;">
                            <select class="form-select form-select-sm product-status" data-id="{{ $product->id }}">
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
                                        <a class="dropdown-item text-primary edit-product" href="javascript:void(0);"
                                            data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                            data-description="{{ $product->description }}"
                                            data-thumbnail="{{ $product->thumbnail }}" data-model="{{ $product->model }}"
                                            data-discount="{{ $product->discount }}"
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
                                    <li>
                                        <a class="dropdown-item text-success detail-product" href="javascript:void(0);"
                                            data-id="{{ $product->id }}"
                                            data-detail="{{ route('admin.product.detail.index') }}">
                                            Xem chi tiết
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-danger">Không có sản phẩm nào</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Modal edit --}}
        <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form id="editProductForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5 class="modal-title" id="editBannerLabel">Sửa Danh mục</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" name="id" id="editProductId">

                            <div class="mb-3">
                                <label for="editName" class="form-label">Tên</label>
                                <input type="text" class="form-control" name="name" id="editName" required>
                            </div>

                            <div class="mb-3">
                                <label for="editModel" class="form-label">Model</label>
                                <input type="text" class="form-control" name="model" id="editModel">
                            </div>

                            <div class="mb-3">
                                <label for="editDescription" class="form-label">Mô tả sản phẩm</label>
                                <textarea class="form-control" name="description" id="editDescription" rows="3"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="editDiscount" class="form-label">Giảm giá</label>
                                <input type="number" class="form-control" name="discount" id="editDiscount" required>
                            </div>

                            <div class="mb-3">
                                <label for="editThumbnail" class="form-label">Ảnh đại diện sản phẩm</label>
                                <input type="file" class="form-control" name="thumbnail" id="editThumbnail"
                                    accept="image/*">
                                <div class="mt-2 text-center">
                                    <img id="editImagePreview" src="" alt="Preview"
                                        style="max-width: 250px; height: auto; border: 1px solid #ddd; padding: 4px; border-radius: 6px;">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Phân trang --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $products->onEachSide(1)->links() }}
        </div>
    </div>
@stop
