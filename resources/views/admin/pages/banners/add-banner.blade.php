@extends('admin.layouts.master')

@section('title', 'Thêm banner mới')

@section('script')
    <script type="module">
        $(document).ready(function() {
            $('#image').change(function(e) {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#preview-image').attr('src', e.target.result).removeClass('d-none');
                }
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Banner</a></li>
    <li class="breadcrumb-item" aria-current="page">Thêm banner mới</li>
@stop

@section('content')
    <div class="container mt-2 pb-4">
        <h3 class="mb-4">Thêm Banner Mới</h3>

        <form action="{{ route('admin.banner.add.new') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Title -->
            <div class="mb-3">
                <label for="title" class="form-label">Tiêu đề</label>
                <input type="text" name="title" id="title" class="form-control" placeholder="Nhập tiêu đề banner"
                    required>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea name="description" id="description" rows="3" class="form-control" placeholder="Nhập mô tả ngắn"></textarea>
            </div>

            <!-- Link -->
            <div class="mb-3">
                <label for="link" class="form-label">Đường dẫn</label>
                <input type="url" name="link" id="link" class="form-control" placeholder="https://example.com">
            </div>

            <!-- Image -->
            <div class="mb-3">
                <label for="image" class="form-label">Hình ảnh</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*" required>

                <!-- Preview -->
                <div class="mt-3">
                    <img id="preview-image" src="" alt="Preview" class="img-thumbnail d-none"
                        style="max-height: 200px;">
                </div>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn btn-primary">Thêm mới</button>
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
