@extends('admin.layouts.master')

@section('title', 'Danh sách bài viết')

@section('script')
    <script type="module">
        $(document).ready(function() {
            var $input = $('#keywordInput');
            var $clear = $('.clear-btn');

            function toggleClear() {
                if ($input.val().length > 0) {
                    $clear.show();
                } else {
                    $clear.hide();
                }
            }

            toggleClear();

            $input.on('input', toggleClear);

            $clear.click(function() {
                $input.val('');
                $clear.hide();
                $input.focus();
                $('#keywordForm').submit();
            });

            // Xử lý khi bấm vào nút xóa
            $(document).on('click', '.delete-blog', function() {
                let id = $(this).data('id');
                let url = $(this).data('delete');

                Swal.fire({
                    title: "Bạn có chắc muốn xóa?",
                    text: "Hành động này không thể hoàn tác!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#6c757d",
                    confirmButtonText: "Xoá",
                    cancelButtonText: "Huỷ"
                }).then((result) => {
                    if(result.isConfirmed) {
                        $.ajax({
                            url: url,
                            method: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id
                            },
                            success: function(res) {
                                if(res.success) {
                                    Swal.fire("Đã xoá!", res.message, "success").then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire("Lỗi", res.message, "error");
                                }
                            },
                            error: function() {
                                Swal.fire("Lỗi", "Không thể xoá bài viết!", "error");
                            }
                        });
                    }
                });
            });
        });
    </script>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="#">Quản lý bài viết</a></li>
    <li class="breadcrumb-item" aria-current="page">Danh sách bài viết</li>
@stop

@section('content')
    <div class="container mt-2 pb-4">
        <h3 class="mb-4">Danh sách bài viết</h3>

        {{-- Form tìm kiếm --}}
        <form id="keywordForm" method="GET" action="{{ route('admin.blog.list.index') }}">
            <div class="row mb-3">
                <div class="col-md-6 input-clear-wrapper">
                    <input type="text" name="keyword" id="keywordInput" class="form-control"
                        placeholder="Tìm theo tiêu đề bài viết..." value="{{ request('keyword') }}">
                    <button type="button" class="clear-btn">&times;</button>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i>
                        Tìm kiếm</button>
                </div>
            </div>
        </form>

        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th style="text-align: center;" scope="col">Tiêu đề</th>
                    <th style="text-align: center;" scope="col">Người đăng</th>
                    <th style="text-align: center;" scope="col">Hình ảnh</th>
                    <th style="text-align: center;" scope="col">Ngày đăng</th>
                    <th style="text-align: center;" scope="col" style="width: 150px;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($blogs as $blog)
                    <td class="text-center text-truncate" style="max-width: 200px;">
                        {{ $blog->title }}
                    </td>
                    <td class="text-center">{{ $blog->author ?? 'N/A' }}</td>
                    <td style="text-align: center;">
                        <img src="{{ asset('storage/' . $blog->thumbnail) }}" alt="{{ $blog->title }}"
                            style="width: 100px; height: auto;" />
                    </td>
                    <td class="text-center">{{ $blog->created_at ?? 'N/A' }}</td>
                    <td style="text-align: center;">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                Hành động
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item text-danger delete-blog" href="javascript:void(0);"
                                        data-id="{{ $blog->id }}" data-delete="{{ route('admin.blog.list.delete') }}">
                                        Xoá
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-success detail-blog" href="javascript:void(0);"
                                        data-id="{{ $blog->id }}" data-detail="#">
                                        Xem chi tiết
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                @empty
                    <td colspan="4" class="text-center text-danger">Không có bài viết nào!</td>
                @endforelse
            </tbody>
        </table>

        {{-- Phân trang --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $blogs->onEachSide(1)->links() }}
        </div>
    </div>
@stop
