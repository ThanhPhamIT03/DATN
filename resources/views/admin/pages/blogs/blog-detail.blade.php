@extends('admin.layouts.master')

@section('title', 'Chi tiết bài viết')

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
    <li class="breadcrumb-item"><a href="#">Quản lý bài viết</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.blog.list.index') }}">Danh sách bài viết</a></li>
    <li class="breadcrumb-item" aria-current="page">Chi tiết</li>
@stop

@section('content')
    <div class="container mt-2 pb-4">
        <h3 class="mb-4">Chi tiết bài viết</h3>

        <h5>Chỉnh sửa tiêu đề</h5>
        <form enctype="multipart/form-data" action="{{ route('admin.blog.list.edit.title') }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $blog->id }}">
            <!-- Tiêu đề bài viết -->
            <div class="mb-3">
                <label for="title" class="form-label">Tiêu đề bài viết</label>
                <input type="text" name="title" value="{{ $blog->title }}" class="form-control" required>
            </div>

            <!-- Ảnh đại diện -->
            <div class="mb-3">
                <label for="thumbnail" class="form-label">Ảnh nền</label>
                <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                    class="form-control @error('thumbnail') is-invalid @enderror">
                @error('thumbnail')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="mt-3">
                    <img id="thumbnailPreview" src="{{ $blog->thumbnail ? asset('storage/' . $blog->thumbnail) : '#' }}"
                        alt="Preview" class="img-fluid rounded-2"
                        style="max-height: 200px; {{ $blog->thumbnail ? '' : 'display:none;' }}">
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-success">Lưu thay đổi</button>
            </div>
        </form>

        <h5 class="mt-4">Chỉnh sửa nội dung</h5>
        @forelse($blog->container as $content)
            <form enctype="multipart/form-data" action="{{ route('admin.blog.list.edit.content') }}" method="POST" class="mt-4">
                @csrf
                @method('PUT')

                <input type="hidden" name="id" value="{{ $content->id}}">
                <!-- Tiêu đề bài viết -->
                <div class="mb-3">
                    <label for="title" class="form-label">Tiêu đề</label>
                    <input type="text" name="title" value="{{ $content->title }}" class="form-control" required>
                </div>

                <!-- Ảnh đại diện -->
                <div class="mb-3">
                    <label for="thumbnail" class="form-label">Ảnh nền</label>
                    <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                        class="form-control @error('thumbnail') is-invalid @enderror">
                    @error('thumbnail')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="mt-3">
                        <img id="thumbnailPreview"
                            src="{{ $content->thumbnail ? asset('storage/' . $content->thumbnail) : '#' }}" alt="Preview"
                            class="img-fluid rounded-2"
                            style="max-height: 200px; {{ $content->thumbnail ? '' : 'display:none;' }}">
                    </div>
                </div>

                {{-- Nội dung --}}
                <div class="mb-3">
                    <label class="form-label">Nội dung</label>
                    <textarea name="content" rows="3" class="form-control">{{ $content->content }}</textarea>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                </div>
            </form>
        @empty
            <div class="alert alert-info text-center">
                Chưa có nội dung cho bài viết này.
            </div>
        @endforelse
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
