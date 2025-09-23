@extends('admin.layouts.master')

@section('title', 'Thêm bài viết')

@section('script')
    <script type="module">
        $(document).ready(function() {
            let blockIndex = 0;

            $('#add-block').on('click', function() {
                blockIndex++;

                let block = `
                <div class="card p-3 mt-3 content-block" data-index="${blockIndex}">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Nội dung ${blockIndex}</h6>
                        <button type="button" class="btn btn-sm btn-danger remove-block">Xóa</button>
                    </div>
                    <div class="mb-3 mt-2">
                        <label class="form-label">Tiêu đề</label>
                        <input type="text" name="blocks[${blockIndex}][title]" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ảnh</label>
                        <input type="file" name="blocks[${blockIndex}][image]" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nội dung</label>
                        <textarea name="blocks[${blockIndex}][content]" rows="3" class="form-control"></textarea>
                    </div>
                </div>
            `;

                $('#content-blocks').append(block);
            });

            // Xóa block
            $(document).on('click', '.remove-block', function() {
                $(this).closest('.content-block').remove();
            });
        });
    </script>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Quản lý bài viết</a></li>
    <li class="breadcrumb-item" aria-current="page">Thêm bài viết mới</li>
@stop

@section('content')
    <div class="container mt-2 pb-4">
        <h3 class="mb-4">Thêm bài viết mới</h3>
        <form id="create-post-form" enctype="multipart/form-data" action="{{ route('admin.blog.create.add') }}" method="POST">
            @csrf

            <!-- Tiêu đề bài viết -->
            <div class="mb-3">
                <label for="title" class="form-label">Tiêu đề bài viết</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>

            <!-- Ảnh đại diện -->
            <div class="mb-3">
                <label for="thumbnail" class="form-label">Ảnh đại diện</label>
                <input type="file" name="thumbnail" id="thumbnail" class="form-control" accept="image/*">
            </div>

            <hr>

            <!-- Nội dung chi tiết -->
            <h5>Nội dung chi tiết</h5>
            <div id="content-blocks"></div>

            <!-- Nút thêm block -->
            <button type="button" class="btn btn-outline-primary mt-3" id="add-block">
                + Thêm nội dung
            </button>

            <!-- Submit -->
            <div class="mt-4">
                <button type="submit" class="btn btn-success">Lưu bài viết</button>
            </div>
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
