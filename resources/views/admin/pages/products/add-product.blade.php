@extends('admin.layouts.master')

@section('title', 'Thêm sản phẩm')

@section('script')
    <script type="module">
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
    </script>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Sản phẩm</a></li>
    <li class="breadcrumb-item" aria-current="page">Thêm sản phẩm</li>
@stop

@section('content')
    <div class="container mt-2 pb-4">
        <h3 class="mb-4">Thêm Sản phẩm</h3>

        <form action="{{ route('admin.product.add.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Danh mục -->
            <div class="mb-3">
                <label for="category_id" class="form-label">Danh mục</label>
                <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror"
                    required>
                    <option value="">-- Chọn danh mục --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tên sản phẩm -->
            <div class="mb-3">
                <label for="name" class="form-label">Tên sản phẩm</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Brand -->
            <div class="mb-3">
                <label for="brand" class="form-label">Thương hiệu</label>
                <select name="brand" id="brand" class="form-select @error('brand') is-invalid @enderror" required>
                    <option value="">-- Chọn thương hiệu --</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}</option>
                    @endforeach
                </select>
                @error('brand')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Model -->
            <div class="mb-3">
                <label for="model" class="form-label">Model</label>
                <input type="text" name="model" id="model"
                    class="form-control @error('model') is-invalid @enderror" value="{{ old('model') }}">
                @error('model')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea name="description" id="description" rows="4"
                    class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Display price --}}
            <div class="mb-3">
                <label for="price" class="form-label">Giá bán</label>
                <input type="number" name="price" id="price"
                    class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}">
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Discount --}}
            <div class="mb-3">
                <label for="discount" class="form-label">Giamr giá (%)</label>
                <input type="number" name="discount" id="discount"
                    class="form-control @error('discount') is-invalid @enderror" value="{{ old('discount') }}">
                @error('discount')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Thumbnail -->
            <div class="mb-3">
                <label for="thumbnail" class="form-label">Ảnh đại diện</label>
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

            <!-- Condition -->
            <div class="mb-3">
                <label for="condition" class="form-label">Tình trạng</label>
                <select name="condition" id="condition" class="form-select @error('condition') is-invalid @enderror"
                    required>
                    <option value="">-- Chọn trạng thái --</option>
                    <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>New</option>
                    <option value="used" {{ old('condition') == 'used' ? 'selected' : '' }}>Used</option>
                </select>
                @error('condition')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit -->
            <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
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
