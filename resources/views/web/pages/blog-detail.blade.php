@extends('web.layouts.master')

@section('title', $blog->title)

@section('script')
    <script type="module"></script>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
    <li class="breadcrumb-item"><a href="{{ route('web.blog.list') }}">Bài viết</a></li>
    <li class="breadcrumb-item" aria-current="page">{{ $blog->title }}</li>
@stop

@section('content')
    <div class="container-xl mt-2">
        <!-- Ảnh nền -->
        <div class="mb-4">
            <img src="{{ asset('storage/' . $blog->thumbnail) }}" alt="{{ $blog->title }}" class="img-fluid w-100 rounded"
                style="object-fit: cover;">
        </div>

        <!-- Thông tin bài viết -->
        <div class="bg-white p-4 rounded shadow-sm">

            <!-- Tiêu đề -->
            <h2 class="fw-bold mb-3">{{ $blog->title }}</h2>

            <!-- Tác giả và ngày -->
            <div class="d-flex align-items-center">
                <img src="{{ asset('./images/default-avatar.png') }}" alt="{{ $blog->author ?? 'Admin' }}"
                    class="rounded-circle me-2" style="width:40px; height:40px; object-fit:cover;">
                <div>
                    <p class="mb-0 fw-semibold">{{ $blog->author ?? 'Admin' }}</p>
                    <small class="text-muted">
                        <i class="bi bi-calendar-event me-1"></i>
                        Ngày cập nhật: {{ $blog->updated_at->format('d/m/Y') }}
                    </small>
                </div>
            </div>

            <!-- Nội dung chi tiết -->
            <div class="content fs-6">
                @forelse($blog->container as $item)
                    <div class="mb-4">
                        {{-- Hình ảnh --}}
                        @if ($item->thumbnail)
                            <div class="mb-4 text-center">
                                <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}"
                                    class="img-fluid rounded shadow-sm" style="max-height: 350px; object-fit: cover;">
                            </div>
                        @endif

                        {{-- Tiêu đề --}}
                        @if ($item->title)
                            <h4 class="fw-bold mb-4">{{ $item->title }}</h4>
                        @endif

                        {{-- Nội dung --}}
                        @if ($item->content)
                            <p class="mb-0">{!! nl2br(e($item->content)) !!}</p>
                        @endif
                    </div>
                @empty
                    <p class="text-muted">Bài viết này chưa có nội dung chi tiết.</p>
                @endforelse
            </div>

        </div>
    </div>
@stop
