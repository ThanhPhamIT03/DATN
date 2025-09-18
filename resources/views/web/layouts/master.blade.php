<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Default Page')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        @include('web.layouts.header')

        <main class="main-content">
            <div class="content" style="background-color: var(--bgr-gray)">
                @hasSection('breadcrumb')
                    <div class="container-xl">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                @yield('breadcrumb')
                            </ol>
                        </nav>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>

        <div class="position-fixed top-0 end-0 p-4" style="z-index: 9999">
            <div id="deleteHistory" class="toast text-bg-success border-0 fs-6" role="alert" aria-live="assertive"
                aria-atomic="true" data-bs-delay="3000" data-bs-autohide="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <div class="fw-bold mb-1">Thông báo! <i class="bi bi-bell"></i></div>
                        <div class="small text-white">Xóa lịch sử tìm kiếm thành công.</div>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Đóng"></button>
                </div>
            </div>
        </div>

        @include('web.layouts.footer')
    </div>
    @yield('script')
    <script type="module">
        $(document).ready(function() {
            $('#del-history').on('click', function() {
                let url = $(this).data('url');

                $.ajax({
                    url: url,
                    method: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        if (res.success) {
                            showToast('Xóa lịch sử tìm kiếm thành công.', 'success');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        } else {
                            showToast(res.message || 'Xóa thất bại!', 'danger');
                        }
                    },
                    error: function() {
                        showToast('Có lỗi xảy ra!', 'danger');
                    }
                });
            });

            function showToast(message, type) {
                let toastEl = $('#deleteHistory');
                toastEl.removeClass('text-bg-success text-bg-danger');
                toastEl.addClass(type === 'success' ? 'text-bg-success' : 'text-bg-danger');
                toastEl.find('.toast-body .small').text(message);
                let toast = new bootstrap.Toast(toastEl[0]);
                toast.show();
            }

            $(document).on('click', '#history-item', function() {
                let url = $(this).data('url'); 
                let keyword = $(this).data('keyword'); 

                window.location.href = url + '?keyword=' + encodeURIComponent(keyword);
            });
        });
    </script>
</body>

</html>
