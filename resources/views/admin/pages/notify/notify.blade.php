@extends('admin.layouts.master')

@section('title', 'Danh sách thông báo')

@section('script')
    <script type="module"></script>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
    <li class="breadcrumb-item" aria-current="page">Danh sách thông báo</li>
@stop

@section('content')
    <div class="container mt-2 pb-4">
        <h3 class="mb-4 fw-bold">Danh sách thông báo</h3>

        <div class="d-flex justify-content-between mb-3">
            <div>
                <span class="fw-semibold">Bạn có {{ $notifications->count() }} thông báo</span>
            </div>
            <button id="markAllRead" class="btn btn-sm btn-outline-primary" data-url="#">
                Đánh dấu tất cả là đã đọc
            </button>
        </div>

        <ul class="list-group shadow-sm">
            @forelse($notifications as $noti)
                <li
                    class="list-group-item d-flex align-items-start 
                        {{ $noti->is_read ? '' : 'bg-light' }}">
                    <div class="me-3 mt-1">
                        <i
                            class="bi bi-bell-fill 
                              {{ $noti->type == 'request' ? 'text-danger' : 'text-primary' }}"></i>
                    </div>
                    <div class="flex-fill">
                        @if ($noti->type == 'request')
                            <div class="fw-semibold">Yêu cầu hủy đơn</div>
                            <small class="text-muted">
                                Bạn vừa nhận được yêu cầu hủy đơn #{{ $noti->notifiable->order_code }}
                            </small>
                        @elseif($noti->type == 'order')
                            <div class="fw-semibold">Đơn hàng mới</div>
                            <small class="text-muted">
                                Bạn vừa nhận được yêu cầu xác nhận đơn #{{ $noti->notifiable->order_code ?? '' }}
                            </small>
                        @endif
                        <br>
                        <small class="text-primary">{{ $noti->created_at->diffForHumans() }}</small>
                    </div>

                    @if ($noti->is_read == 1)
                        <span class="badge bg-success ms-3">Đã đọc</span>
                    @else
                        <span class="badge bg-warning ms-3">Chưa đọc</span>
                    @endif
                </li>
            @empty
                <li class="list-group-item text-center text-danger">
                    Hiện không có thông báo nào!
                </li>
            @endforelse
        </ul>

        {{-- phân trang --}}
        <div class="mt-3">
            {{ $notifications->links() }}
        </div>
    </div>
@endsection
