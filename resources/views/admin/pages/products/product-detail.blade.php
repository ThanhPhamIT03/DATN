@extends('admin.layouts.master')

@section('title', 'Chi tiết sản phẩm')

@section('script')
    <script type="module">
        // Xử lý xem trước ảnh upload
        $(document).ready(function() {
            $('#thumbnail').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#thumbnailPreview').attr('src', e.target.result).show();
                }
                if (this.files && this.files[0]) {
                    reader.readAsDataURL(this.files[0]);
                } else {
                    $('#thumbnailPreview').hide().attr('src', '#');
                }
            });
        });

        // Show info của sản phẩm
        $('.show-info-btn').click(function() {
            var info = $(this).data('info');
            var prettyInfo = JSON.stringify(info, null, 4);
            $('#categoryInfoJson').text(prettyInfo);
            var modal = new bootstrap.Modal(document.getElementById('showInfoModal'));
            modal.show();
        });

        // Trạng thái
        $('.detail-status').change(function() {
            $.ajax({
                url: "{{ route('admin.product.detail.status') }}",
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

        // Edit biến thể
        let currentUpdateUrl = null;

        $(document).on('click', '.edit-variant', function() {
            let id = $(this).data('id');
            let code = $(this).data('code');
            let color = $(this).data('color');
            let ram = $(this).data('ram');
            let rom = $(this).data('rom');
            let price = $(this).data('price');
            let thumbnail = $(this).data('thumbnail');
            let quantity = $(this).data('quantity');
            let operating_system = $(this).data('operating_system');
            let screen_size = $(this).data('screen_size');
            let screen_technology = $(this).data('screen_technology');
            let front_camera = $(this).data('front_camera');
            let rear_camera = $(this).data('rear_camera');
            let chip = $(this).data('chip');
            let battery = $(this).data('battery');
            let cpu_type = $(this).data('cpu_type');

            currentUpdateUrl = $(this).data('edit');

            $('#editVariantId').val(id);
            $('#editCode').val(code);
            $('#editColor').val(color);
            $('#editStorageRam').val(ram);
            $('#editStorageRom').val(rom);
            $('#editPrice').val(price);
            $('#editQuantity').val(quantity);
            $('#editOperatingSystem').val(operating_system);
            $('#editScreenSize').val(screen_size);
            $('#editScreenTechnology').val(screen_technology);
            $('#editFrontCamera').val(front_camera);
            $('#editRearCamera').val(rear_camera);
            $('#editChip').val(chip);
            $('#editBattery').val(battery);
            $('#editCpuType').val(cpu_type);
            $('#editImagePreview').attr('src', '/storage/' + thumbnail);

            let modal = new bootstrap.Modal(document.getElementById('editVariantModal'));
            modal.show();
        });

        $('#editThumbnail').on('change', function() {
            const [file] = this.files;
            if (file) {
                $('#editImagePreview').attr('src', URL.createObjectURL(file));
            }
        });

        $('#editVariantForm').submit(function(e) {
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
                            let modalEl = document.getElementById('editVariantModal');
                            let modal = bootstrap.Modal.getInstance(modalEl);
                            modal.hide();

                            $('#editVariantModal').on('hidden.bs.modal', function() {
                                location.reload();
                            });
                        });
                    } else {
                        Swal.fire('Lỗi', res.message, 'error');
                    }
                },
                error: function() {
                    Swal.fire('Lỗi', 'Không thể cập nhật biến thể!', 'error');
                }
            });
        });

        // Xoá biến thể
        $(document).on('click', '.delete-variant', function() {
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
    </script>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.product.list.index') }}">Sản phẩm</a></li>
    <li class="breadcrumb-item"><a href="#">{{ $parentProduct->name }}</a></li>
    <li class="breadcrumb-item" aria-current="page">Chi tiết</li>
@stop

@section('content')
    <div class="container mt-2 pb-4">

        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <!-- Nút mở modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVariantModal">
                    <i class="bi bi-plus-circle me-1"></i> Thêm biến thể mới
                </button>
            </div>
        </div>

        <!-- Modal Thêm biến thể mới -->
        <div class="modal fade" id="addVariantModal" tabindex="-1" aria-labelledby="addVariantModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <form id="addVariantForm" method="POST" action="{{ route('admin.product.detail.add') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $parentProduct->id }}">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addVariantModalLabel">Thêm biến thể mới</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                        </div>
                        <div class="modal-body row">
                            <div class="col-md-6 mb-3">
                                <label for="variantCode" class="form-label">Mã biến thể (bắt buộc)</label>
                                <input type="text" class="form-control" id="variantCode" name="code"
                                    placeholder="Ví dụ: SP001-M" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="variantColor" class="form-label">Màu sắc (bắt buộc)</label>
                                <input type="text" class="form-control" id="variantColor" name="color"
                                    placeholder="Ví dụ: Đỏ">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="variantStorage" class="form-label">Dung lượng / Bộ nhớ (bắt buộc)</label>
                                <input type="text" class="form-control" id="variantStorage" name="storage_rom"
                                    placeholder="Ví dụ: 64GB">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="variantRam" class="form-label">Bộ nhớ RAM (bắt buộc)</label>
                                <input type="text" class="form-control" id="variantRam" name="storage_ram"
                                    placeholder="Ví dụ: 8GB">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="variantPrice" class="form-label">Giá (bắt buộc)</label>
                                <input type="number" class="form-control" id="variantPrice" name="price" placeholder="0"
                                    min="0" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="variantQuantity" class="form-label">Số lượng (bắt buộc)</label>
                                <input type="number" class="form-control" id="variantQuantity" name="quantity"
                                    placeholder="0" min="0" required>
                            </div>
                            <div class="mb-3">
                                <label for="thumbnail" class="form-label">Ảnh đại diện (bắt buộc)</label>
                                <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                                    class="form-control @error('thumbnail') is-invalid @enderror">
                                @error('thumbnail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="mt-3">
                                    <img id="thumbnailPreview" src="#" alt="Preview" class="img-fluid"
                                        style="max-height: 200px; display: none;">
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Thông tin chi tiết (bắt buộc)</label>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="operating_system"
                                            placeholder="Hệ điều hành">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="screen_size"
                                            placeholder="Kích thước màn hình">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="screen_technology"
                                            placeholder="Công nghệ màn hình">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="front_camera"
                                            placeholder="Camera trước">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="rear_camera"
                                            placeholder="Camera sau">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="chip"
                                            placeholder="Chip xử lý">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="battery"
                                            placeholder="Dung lượng pin">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="cpu_type"
                                            placeholder="Loại CPU">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-primary">Lưu biến thể</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <h3 class="mb-4">
            Danh sách các biến thể của: <span class="fw-bold text-primary ms-2">{{ $parentProduct->name }}</span>
        </h3>

        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th style="text-align: center;" scope="col">Mã biến thể</th>
                    <th style="text-align: center;" scope="col">Màu sắc</th>
                    <th style="text-align: center;" scope="col">Dung lượng</th>
                    <th style="text-align: center;" scope="col">Giá bán</th>
                    <th style="text-align: center;" scope="col">Số lượng</th>
                    <th style="text-align: center;" scope="col">Hình ảnh</th>
                    <th style="text-align: center;" scope="col">Thông tin</th>
                    <th style="text-align: center;" scope="col">Trạng thái</th>
                    <th style="text-align: center;" scope="col">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productVariants as $product)
                    <tr>
                        <td class="text-center">{{ $product->code ?? 'N/A' }}</td>
                        <td class="text-center">{{ $product->color ?? 'N/A' }}</td>
                        <td class="text-center">
                            {{ $product->storage['ram'] }} / {{ $product->storage['rom'] }}
                        </td>
                        <td class="text-center text-danger fw-bold">
                            {{ number_format($product->price, 0, ',', '.') }}₫
                        </td>
                        <td class="text-center">{{ $product->quantity ?? 'N/A' }}</td>
                        <td style="text-align: center;">
                            <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}"
                                style="width: 50px; height: auto;" />
                        </td>
                        <td style="text-align: center;">
                            <button type="button" class="btn btn-sm btn-primary show-info-btn"
                                data-info='@json($product->info)'>
                                <i class="bi bi-info-circle-fill"></i>
                            </button>
                        </td>
                        <td style="text-align: center;">
                            <select class="form-select form-select-sm detail-status" data-id="{{ $product->id }}">
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
                                        <a class="dropdown-item text-primary edit-variant" href="javascript:void(0);"
                                            data-id="{{ $product->id }}" data-code="{{ $product->code }}"
                                            data-color="{{ $product->color }}"
                                            data-thumbnail="{{ $product->thumbnail }}"
                                            data-ram="{{ $product->storage['ram'] }}"
                                            data-rom="{{ $product->storage['rom'] }}"
                                            data-price="{{ $product->price }}"
                                            data-quantity="{{ $product->quantity }}"
                                            data-operating_system="{{ $product->info['operating_system'] }}"
                                            data-screen_size="{{ $product->info['screen_size'] }}"
                                            data-screen_technology="{{ $product->info['screen_technology'] }}"
                                            data-front_camera="{{ $product->info['front_camera'] }}"
                                            data-rear_camera="{{ $product->info['rear_camera'] }}"
                                            data-chip="{{ $product->info['chip'] }}"
                                            data-battery="{{ $product->info['battery'] }}"
                                            data-cpu_type="{{ $product->info['cpu_type'] }}"
                                            data-edit="{{ route('admin.product.detail.edit') }}">
                                            Sửa
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-danger delete-variant" href="javascript:void(0);"
                                            data-id="{{ $product->id }}"
                                            data-delete="{{ route('admin.product.detail.delete') }}">
                                            Xoá
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Không có biến thể nào</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Modal Info -->
        <div class="modal fade" id="showInfoModal" tabindex="-1" aria-labelledby="showInfoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="showInfoModalLabel">Thông tin</h5>
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

        {{-- Modal edit biến thể --}}
        <div class="modal fade" id="editVariantModal" tabindex="-1" aria-labelledby="editVariantLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form id="editVariantForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5 class="modal-title" id="editVariantLabel">Sửa Danh mục</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" name="id" id="editVariantId">

                            <div class="mb-3">
                                <label for="editCode" class="form-label">Mã biến thể</label>
                                <input type="text" class="form-control" name="code" id="editCode" required>
                            </div>

                            <div class="mb-3">
                                <label for="editColor" class="form-label">Màu sắc</label>
                                <input type="text" class="form-control" name="color" id="editColor"></input>
                            </div>

                            <div class="mb-3">
                                <label for="editStorageRam" class="form-label">Bộ nhớ RAM</label>
                                <input type="text" class="form-control" name="ram" id="editStorageRam" required>
                            </div>

                            <div class="mb-3">
                                <label for="editStorageRom" class="form-label">Bộ nhớ trong (ROM)</label>
                                <input type="text" class="form-control" name="rom" id="editStorageRom" required>
                            </div>

                            <div class="mb-3">
                                <label for="editPrice" class="form-label">Giá bán</label>
                                <input type="number" class="form-control" name="price" id="editPrice" required>
                            </div>

                            <div class="mb-3">
                                <label for="editQuantity" class="form-label">Số lượng</label>
                                <input type="number" class="form-control" name="quantity" id="editQuantity" required>
                            </div>

                            <div class="mb-3">
                                <label for="editThumbnail" class="form-label">Ảnh đại diện sản phẩm</label>
                                <input type="file" class="form-control" name="thumbnail" id="editThumbnail"
                                    accept="image/*">
                                <div class="mt-2 text-center">
                                    <img id="editImagePreview" src="" alt="Preview"
                                        style="max-width: 150px; height: auto; border: 1px solid #ddd; padding: 4px; border-radius: 6px;">
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Thông tin chi tiết (bắt buộc)</label>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="operating_system"
                                            placeholder="Hệ điều hành" id="editOperatingSystem">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="screen_size"
                                            placeholder="Kích thước màn hình" id="editScreenSize">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="screen_technology"
                                            placeholder="Công nghệ màn hình" id="editScreenTechnology">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="front_camera"
                                            placeholder="Camera trước" id="editFrontCamera">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="rear_camera"
                                            placeholder="Camera sau" id="editRearCamera">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="chip"
                                            placeholder="Chip xử lý" id="editChip">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="battery"
                                            placeholder="Dung lượng pin" id="editBattery">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="cpu_type"
                                            placeholder="Loại CPU" id="editCpuType">
                                    </div>
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
        {{-- <div class="d-flex justify-content-center mt-3">
            {{ $products->onEachSide(1)->links() }}
        </div> --}}
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
