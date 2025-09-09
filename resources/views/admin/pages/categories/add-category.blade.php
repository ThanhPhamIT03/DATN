@extends('admin.layouts.master')

@section('title', 'Thêm danh mục mới')

@section('script')
    <script type="module">
        // Preview ảnh
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').attr('src', e.target.result);
                    $('#imagePreview').show();
                }
                if (this.files && this.files[0]) {
                    reader.readAsDataURL(this.files[0]);
                } else {
                    $('#imagePreview').hide();
                    $('#imagePreview').attr('src', '#');
                }
            });
        });
    </script>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Danh mục</a></li>
    <li class="breadcrumb-item" aria-current="page">Thêm danh mục mới</li>
@stop

@section('content')
    <div class="container mt-2 pb-4">
        <h3 class="mb-4">Thêm Danh Mục</h3>

        <form action="{{ route('admin.category.add.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Tên danh mục -->
            <div class="mb-3">
                <label for="name" class="form-label">Tên danh mục</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                    value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Loại</label>
                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                    <option value="">-- Chọn loại --</option>
                    <option value="product" {{ old('type') == 'product' ? 'selected' : '' }}>Sản phẩm</option>
                    <option value="service" {{ old('type') == 'service' ? 'selected' : '' }}>Dịch vụ</option>
                </select>
            </div>

            <!-- Mô tả -->
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                    rows="4">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Hình ảnh -->
            <div class="mb-3">
                <label for="image" class="form-label">Hình ảnh</label>
                <input class="form-control @error('image') is-invalid @enderror" type="file" id="image"
                    name="image" accept="image/*">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                <!-- Preview ảnh -->
                <div class="mt-3">
                    <img id="imagePreview" src="#" alt="Preview" class="img-fluid"
                        style="max-height: 200px; display: none;">
                </div>
            </div>

            <!-- Nút submit -->
            <button type="submit" class="btn btn-primary">Thêm danh mục</button>
        </form>
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
