@extends('admin.layouts.master')

@section('title', 'Sản phẩm nổi bật')

@section('script')
    <script type="module">
        // Trạng thái
        $('.product-featured').change(function() {
            $.ajax({
                url: "{{ route('admin.product.featured.status') }}",
                type: "POST",
                data: {
                    id: $(this).data('id'),
                    is_featured: $(this).val(),
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    if (res.success) {
                        Swal.fire({
                            title: 'Thành công',
                            text: res.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire('Lỗi', res.message, 'error');
                    }
                },
                error: function() {
                    Swal.fire('Lỗi', 'Không thể cập nhật trạng thái!', 'error');
                }
            });
        });
    </script>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Sản phẩm</a></li>
    <li class="breadcrumb-item" aria-current="page">Sản phẩm nổi bật</li>
@stop

@section('content')
    <div class="container mt-2 pb-4">

        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <!-- Nút mở modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFeaturedModal">
                    <i class="bi bi-plus-circle me-1"></i> Thêm sản phẩm nổi bật
                </button>
            </div>
        </div>

        {{-- Modal thêm sản phẩm nổi bật --}}
        <div class="modal fade" id="addFeaturedModal" tabindex="-1" aria-labelledby="addFeaturedModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('admin.product.featured.add') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addFeaturedModalLabel">Thêm sản phẩm nổi bật</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="id" class="form-label">Chọn sản phẩm</label>
                                <select name="id" id="id" class="form-select" required>
                                    <option value="">-- Chọn sản phẩm --</option>
                                    @foreach ($productsIsFeatured as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
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

        <h3 class="mb-4">
            Danh sách Sản phẩm nổi bật
        </h3>

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
                            <select class="form-select form-select-sm product-featured" data-id="{{ $product->id }}">
                                <option value="1" {{ $product->is_featured == 1 ? 'selected' : '' }}>On</option>
                                <option value="0" {{ $product->is_featured == 0 ? 'selected' : '' }}>Off</option>
                            </select>
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
            {{ $products->onEachSide(1)->links() }}
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
