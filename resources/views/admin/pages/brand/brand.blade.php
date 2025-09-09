@extends('admin.layouts.master')

@section('title', 'Thương hiệu')

@section('script')
    <script type="module">
        // Preview ảnh
        $(document).ready(function() {
            $('#brand_image').change(function(e) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#brandImagePreview').attr('src', e.target.result).show();
                }
                if (this.files && this.files[0]) {
                    reader.readAsDataURL(this.files[0]);
                } else {
                    $('#brandImagePreview').hide().attr('src', '#');
                }
            });
        });

        // Cập nhật trạng thái brand
        $('.brand-status').change(function() {
            $.ajax({
                url: "{{ route('admin.brand.list.status') }}",
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

        // Chỉnh sửa brand
        let currentUpdateUrl = null;

        $(document).on('click', '.edit-brand', function() {
            let id = $(this).data('id');
            let name = $(this).data('name');
            let image = $(this).data('image');
            currentUpdateUrl = $(this).data('edit');

            $('#editBrandId').val(id);
            $('#editName').val(name);
            $('#editImagePreview').attr('src', '/storage/' + image);

            let modal = new bootstrap.Modal(document.getElementById('editBrandModal'));
            modal.show();
        });

        $('#editImage').on('change', function() {
            const [file] = this.files;
            if (file) {
                $('#editImagePreview').attr('src', URL.createObjectURL(file));
            }
        });

        $('#editBrandForm').submit(function(e) {
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
                            let modalEl = document.getElementById('editBrandModal');
                            let modal = bootstrap.Modal.getInstance(modalEl);
                            modal.hide();

                            $('#editBrandModal').on('hidden.bs.modal', function() {
                                location.reload();
                            });
                        });
                    } else {
                        Swal.fire('Lỗi', res.message, 'error');
                    }
                },
                error: function() {
                    Swal.fire('Lỗi', 'Không thể cập nhật banner!', 'error');
                }
            });
        });
    </script>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Thương hiệu</a></li>
    <li class="breadcrumb-item" aria-current="page">Danh sách thương hiệu</li>
@stop

@section('content')
    <div class="container mt-2 pb-4">
        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <!-- Nút mở modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBrandModal">
                    <i class="bi bi-plus-circle me-1"></i> Thêm thương hiệu
                </button>
            </div>
        </div>

        <!-- Modal thêm thương hiệu -->
        <div class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="addBrandModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('admin.brand.list.add') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addBrandModalLabel">Thêm Thương Hiệu</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                        </div>
                        <div class="modal-body">

                            <!-- Tên thương hiệu -->
                            <div class="mb-3">
                                <label for="brand_name" class="form-label">Tên thương hiệu</label>
                                <input type="text" class="form-control @error('brand_name') is-invalid @enderror"
                                    id="brand_name" name="name" value="{{ old('brand_name') }}" required>
                                @error('brand_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Hình ảnh thương hiệu -->
                            <div class="mb-3">
                                <label for="brand_image" class="form-label">Hình ảnh</label>
                                <input type="file" class="form-control @error('brand_image') is-invalid @enderror"
                                    id="brand_image" name="image" accept="image/*">
                                @error('brand_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <div class="mt-3">
                                    <img id="brandImagePreview" src="#" alt="Preview"
                                        style="max-height: 150px; display: none;" class="img-fluid rounded border">
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-success">Lưu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <h3 class="mb-4">Danh sách Thương hiệu</h3>

        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th style="text-align: center;" scope="col" style="width: 50px;">STT</th>
                    <th style="text-align: center;" scope="col">Tên thương hiệu</th>
                    <th style="text-align: center;" scope="col">Slug</th>
                    <th style="text-align: center;" scope="col">Hình ảnh</th>
                    <th style="text-align: center;" scope="col" style="width: 150px;">Trạng thái</th>
                    <th style="text-align: center;" scope="col" style="width: 150px;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($brands as $index => $brand)
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        <td style="text-align: center;">{{ $brand->name }}</td>
                        <td style="text-align: center;">{{ $brand->slug }}</td>
                        <td style="text-align: center;">
                            <img src="{{ asset('storage/' . $brand->image) }}" alt="{{ $brand->name }}"
                                style="width: 30px; height: auto;">
                        </td>
                        <td style="text-align: center;">
                            <select class="form-select form-select-sm brand-status" data-id="{{ $brand->id }}">
                                <option value="0" {{ $brand->status == 0 ? 'selected' : '' }}>Pending</option>
                                <option value="1" {{ $brand->status == 1 ? 'selected' : '' }}>Active</option>
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
                                        <a class="dropdown-item edit-brand" href="javascript:void(0);"
                                            data-id="{{ $brand->id }}" 
                                            data-name="{{ $brand->name }}"
                                            data-image="{{ $brand->image }}" 
                                            data-edit="{{ route('admin.brand.list.edit') }}">
                                            Sửa
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-danger delete-banner" href="javascript:void(0);"
                                            data-id="{{ $brand->id }}" data-delete="#">
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

        <!-- Modal sửa thương hiệu -->
        <div class="modal fade" id="editBrandModal" tabindex="-1" aria-labelledby="editBrandLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form id="editBrandForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5 class="modal-title" id="editBannerLabel">Sửa Thương hiệu</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" name="id" id="editBrandId">

                            <div class="mb-3">
                                <label for="editName" class="form-label">Tên thương hiệu</label>
                                <input type="text" class="form-control" name="name" id="editName" required>
                            </div>

                            <div class="mb-3">
                                <label for="editImage" class="form-label">Hình ảnh</label>
                                <input type="file" class="form-control" name="image" id="editImage"
                                    accept="image/*">
                                <div class="mt-2 text-center">
                                    <img id="editImagePreview" src="" alt="Preview"
                                        style="max-width: 100px; height: auto; border: 1px solid #ddd; padding: 4px; border-radius: 6px;">
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

    @if (session('error'))
        <script>
            window.LaravelSwalMessage = {
                type: 'error',
                message: '{{ session('error') }}'
            };
        </script>
    @endif

    @if (session('success'))
        <script>
            window.LaravelSwalMessage = {
                type: 'success',
                message: '{{ session('success') }}'
            };
        </script>
    @endif
@stop
