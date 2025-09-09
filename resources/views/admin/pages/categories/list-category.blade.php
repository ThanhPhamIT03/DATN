@extends('admin.layouts.master')

@section('title', 'Danh sách danh mục')

@section('script')
    <script type="module">
        $(document).ready(function() {

            // Cập nhật trạng thái category
            $('.category-status').change(function() {
                $.ajax({
                    url: "{{ route('admin.category.list.status') }}",
                    type: "POST",
                    data: {
                        id: $(this).data('id'),
                        status: $(this).val(),
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire('Thành công', res.message, 'success');
                        } else {
                            Swal.fire('Lỗi', res.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Lỗi', 'Không thể cập nhật trạng thái!', 'error');
                    }
                });
            });

            // Show info của danh mục
            // $('.show-info-btn').click(function() {
            //     var info = $(this).data('info');
            //     var prettyInfo = JSON.stringify(info, null, 4);
            //     $('#categoryInfoJson').text(prettyInfo);
            //     var modal = new bootstrap.Modal(document.getElementById('showInfoModal'));
            //     modal.show();
            // });

        });

        // Modal edit category
        let currentUpdateUrl = null;

        $(document).on('click', '.edit-category', function() {
            let id = $(this).data('id');
            let name = $(this).data('name');
            let type = $(this).data('type');
            let description = $(this).data('description');
            let image = $(this).data('image');
            currentUpdateUrl = $(this).data('edit');

            $('#editCategoryId').val(id);
            $('#editName').val(name);
            $('#editType').val(type);
            $('#editDescription').val(description);
            $('#editImagePreview').attr('src', '/storage/' + image);

            let modal = new bootstrap.Modal(document.getElementById('editCategoryModal'));
            modal.show();
        });

        $('#editImage').on('change', function() {
            const [file] = this.files;
            if (file) {
                $('#editImagePreview').attr('src', URL.createObjectURL(file));
            }
        });

        $('#editCategoryForm').submit(function(e) {
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
                            let modalEl = document.getElementById('editCategoryModal');
                            let modal = bootstrap.Modal.getInstance(modalEl);
                            modal.hide();

                            $('#editCategoryModal').on('hidden.bs.modal', function() {
                                location.reload();
                            });
                        });
                    } else {
                        Swal.fire('Lỗi', res.message, 'error');
                    }
                },
                error: function() {
                    Swal.fire('Lỗi', 'Không thể cập nhật category!', 'error');
                }
            });
        });

        // Xoá category
        $(document).on('click', '.delete-category', function() {
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
                            Swal.fire("Lỗi", "Không thể xoá danh mục!", "error");
                        }
                    });
                }
            });
        });
    </script>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Danh mục</a></li>
    <li class="breadcrumb-item" aria-current="page">Danh sách danh mục</li>
@stop

@section('content')
    <div class="container mt-2 pb-4">
        <h3 class="mb-4">Danh sách Danh mục</h3>

        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th style="text-align: center;" scope="col" style="width: 50px;">STT</th>
                    <th style="text-align: center;" scope="col">Tên</th>
                    <th style="text-align: center;" scope="col">Loại</th>
                    <th style="text-align: center;" scope="col">Mô tả</th>
                    <th style="text-align: center;" scope="col">Slug</th>
                    <th style="text-align: center;" scope="col">Hình ảnh</th>
                    {{-- <th scope="col">Thông tin</th> --}}
                    <th scope="col" style="width: 150px;">Trạng thái</th>
                    <th scope="col" style="width: 150px;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $index => $category)
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        <td style="text-align: center;">{{ $category->name }}</td>
                        <td style="text-align: center;">{{ $category->type }}</td>
                        <td style="text-align: center;">{{ $category->description }}</td>
                        <td style="text-align: center;">{{ $category->slug }}</td>
                        <td style="text-align: center;">
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                style="width: 100px; height: auto;">
                        </td>
                        {{-- <td>
                            <button type="button" class="btn btn-sm btn-primary show-info-btn"
                                data-info='@json($category->info)'>
                                <i class="bi bi-info-circle-fill"></i>
                            </button>
                        </td> --}}
                        <td style="text-align: center;">
                            <select class="form-select form-select-sm category-status" data-id="{{ $category->id }}">
                                <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>Pending</option>
                                <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>Active</option>
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
                                        <a class="dropdown-item edit-category" href="javascript:void(0);"
                                            data-id="{{ $category->id }}" data-name="{{ $category->name }}"
                                            data-description="{{ $category->description }}"
                                            data-image="{{ $category->image }}"
                                            data-edit="{{ route('admin.category.list.edit') }}">
                                            Sửa
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-danger delete-category" href="javascript:void(0);"
                                            data-id="{{ $category->id }}"
                                            data-delete="{{ route('admin.category.list.delete') }}">
                                            Xoá
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Modal Info -->
        <div class="modal fade" id="showInfoModal" tabindex="-1" aria-labelledby="showInfoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="showInfoModalLabel">Thông tin danh mục</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <pre id="categoryInfoJson" style="white-space: pre-wrap;"></pre>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal sửa category --}}
        <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form id="editCategoryForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5 class="modal-title" id="editBannerLabel">Sửa Danh mục</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" name="id" id="editCategoryId">

                            <div class="mb-3">
                                <label for="editName" class="form-label">Tên</label>
                                <input type="text" class="form-control" name="name" id="editName" required>
                            </div>

                            <div class="mb-3">
                                <label for="editType" class="form-label">Loại</label>
                                <select class="form-select" name="type" id="editType" required>
                                    <option value="">-- Chọn loại --</option>
                                    <option value="product" {{ $category->type == 'product' ? 'selected' : '' }}>Sản phẩm</option>
                                    <option value="service" {{ $category->type == 'service' ? 'selected' : '' }}>Dịch vụ</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="editDescription" class="form-label">Mô tả</label>
                                <textarea class="form-control" name="description" id="editDescription" rows="3"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="editImage" class="form-label">Hình ảnh</label>
                                <input type="file" class="form-control" name="image" id="editImage"
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

    </div>
@stop
