@extends('web.layouts.master')

@section('title', 'Danh sách bài viết')

@section('script')
    <script type="module"></script>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
    <li class="breadcrumb-item" aria-current="page">Bài viết</li>
@stop

@section('content')
    <div class="container-xl mt-2">
        <h3 class="mb-4">Danh sách bài viết</h3>

        @foreach ($blogs as $blog)
            <a href="{{ route('web.blog.detail', $blog->id)}}" class="text-decoration-none text-dark">
                <div class="row mb-4 pb-3 blog-item">
                    <!-- Ảnh -->
                    <div class="col-md-4">
                        <div class="img-wrapper">
                            <img src="{{ asset('storage/' . $blog->thumbnail) }}" alt="{{ $blog->title }}"
                                class="img-fluid rounded shadow-sm">
                        </div>
                    </div>

                    <!-- Thông tin -->
                    <div class="col-md-8 d-flex flex-column justify-content-center">
                        <h5 class="mb-2">{{ $blog->title }}</h5>
                        <p class="mb-1 text-muted">
                            Người đăng: <strong>{{ $blog->author ?? 'Admin' }}</strong>
                        </p>
                        <p class="mb-0 text-muted">
                            {{ $blog->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>
            </a>
        @endforeach

        <!-- Pagination -->
        <div class="mt-4">
            {{ $blogs->onEachSide(1)->links() }}
        </div>
    </div>

    <style>
        /* Làm cả khối có hiệu ứng hover */
        .blog-item {
            transition: background-color 0.2s ease;
        }

        .blog-item:hover {
            background-color: #f8f9fa;
        }

        /* Hiệu ứng ảnh phóng to */
        .img-wrapper {
            overflow: hidden;
            border-radius: 0.375rem;
            /* giống rounded */
        }

        .img-wrapper img {
            transition: transform 0.3s ease;
        }

        .img-wrapper:hover img {
            transform: scale(1.05);
        }
    </style>

@stop
