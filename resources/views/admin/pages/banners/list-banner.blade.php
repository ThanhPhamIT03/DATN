@extends('admin.layouts.master')

@section('title', 'Danh sách banner')

@section('script')
    <script type="module">
        // Cập nhật trạng thái banner
        $('.banner-status').change(function() {
            $.ajax({
                url: "{{ route('admin.banner.list.status') }}",
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

        // Chỉnh sửa banner
        let currentUpdateUrl = null;

        $(document).on('click', '.edit-banner', function() {
            let id = $(this).data('id');
            let title = $(this).data('title');
            let description = $(this).data('description');
            let link = $(this).data('link');
            let image = $(this).data('image');
            currentUpdateUrl = $(this).data('update');

            $('#editBannerId').val(id);
            $('#editTitle').val(title);
            $('#editDescription').val(description);
            $('#editLink').val(link);
            $('#editImagePreview').attr('src', '/storage/' + image);

            let modal = new bootstrap.Modal(document.getElementById('editBannerModal'));
            modal.show();
        });

        $('#editImage').on('change', function() {
            const [file] = this.files;
            if (file) {
                $('#editImagePreview').attr('src', URL.createObjectURL(file));
            }
        });

        $('#editBannerForm').submit(function(e) {
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
                            let modalEl = document.getElementById('editBannerModal');
                            let modal = bootstrap.Modal.getInstance(modalEl);
                            modal.hide();

                            $('#editBannerModal').on('hidden.bs.modal', function() {
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

        // Xoá banner
        $(document).on('click', '.delete-banner', function() {
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
                            Swal.fire("Lỗi", "Không thể xoá banner!", "error");
                        }
                    });
                }
            });
        });
    </script>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Banner</a></li>
    <li class="breadcrumb-item" aria-current="page">Danh sách banner</li>
@stop

@section('content')
    <div class="container mt-2 pb-4">
        <h3 class="mb-4">Danh sách Banner</h3>

        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th style="text-align: center;" scope="col" style="width: 50px;">STT</th>
                    <th style="text-align: center;" scope="col">Tiêu đề</th>
                    <th style="text-align: center;" scope="col">Mô tả</th>
                    <th style="text-align: center;" scope="col">Link</th>
                    <th style="text-align: center;" scope="col">Hình ảnh</th>
                    <th style="text-align: center;" scope="col" style="width: 150px;">Trạng thái</th>
                    <th style="text-align: center;" scope="col" style="width: 150px;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($banners as $index => $banner)
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        <td style="text-align: center;">{{ $banner->title }}</td>
                        <td style="text-align: center;">{{ $banner->description }}</td>
                        <td style="text-align: center;">
                            <a href="{{ $banner->link }}" target="_blank">{{ $banner->link }}</a>
                        </td>
                        <td style="text-align: center;">
                            <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}"
                                style="width: 100px; height: auto;">
                        </td>
                        <td style="text-align: center;">
                            <select class="form-select form-select-sm banner-status" data-id="{{ $banner->id }}">
                                <option value="0" {{ $banner->status == 0 ? 'selected' : '' }}>Pending</option>
                                <option value="1" {{ $banner->status == 1 ? 'selected' : '' }}>Active</option>
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
                                        <a class="dropdown-item edit-banner" href="javascript:void(0);"
                                            data-id="{{ $banner->id }}" data-title="{{ $banner->title }}"
                                            data-description="{{ $banner->description }}" data-link="{{ $banner->link }}"
                                            data-image="{{ $banner->image }}"
                                            data-update="{{ route('admin.banner.list.edit', $banner->id) }}">
                                            Sửa
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-danger delete-banner" href="javascript:void(0);"
                                            data-id="{{ $banner->id }}" data-delete="{{ route('admin.banner.list.delete') }}">
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

        {{-- Modal sửa banner --}}
        <div class="modal fade" id="editBannerModal" tabindex="-1" aria-labelledby="editBannerLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form id="editBannerForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5 class="modal-title" id="editBannerLabel">Sửa Banner</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" name="id" id="editBannerId">

                            <div class="mb-3">
                                <label for="editTitle" class="form-label">Tiêu đề</label>
                                <input type="text" class="form-control" name="title" id="editTitle" required>
                            </div>

                            <div class="mb-3">
                                <label for="editDescription" class="form-label">Mô tả</label>
                                <textarea class="form-control" name="description" id="editDescription" rows="3"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="editLink" class="form-label">Link</label>
                                <input type="text" class="form-control" name="link" id="editLink">
                            </div>

                            <div class="mb-3">
                                <label for="editImage" class="form-label">Hình ảnh</label>
                                <input type="file" class="form-control" name="image" id="editImage" accept="image/*">
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
