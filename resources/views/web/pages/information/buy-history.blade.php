@extends('web.pages.information.layouts.master')

@section('script')
    <script type="module">
        $(document).ready(function() {
            // Xử lý khi bấm vào nút lọc đơn hàng
            $(document).on('click', '#btn-fillter', function() {
                $('#filterForm').submit();
            });

            // Xử lý khi bấm vào nút hủy đơn
            $(document).on('click', '.btn-cancel', function(e) {
                e.preventDefault();
                let btn = this;
                let ladda = Ladda.create(btn);
                let url = $(this).data('url');
                let id = $(this).data('order_id');

                Swal.fire({
                    title: 'Bạn có chắc muốn hủy đơn hàng?',
                    text: 'Vui lòng nhập lý do hủy để chúng tôi hỗ trợ tốt hơn.',
                    input: 'textarea',
                    inputPlaceholder: 'Nhập lý do hủy đơn...',
                    showCancelButton: true,
                    confirmButtonText: 'Xác nhận hủy',
                    cancelButtonText: 'Không',
                    inputValidator: (value) => {
                        if (!value) {
                            return 'Bạn cần nhập lý do hủy!';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        ladda.start();

                        $.ajax({
                            url: url,
                            method: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id,
                                reason: result.value
                            },
                            success: function(res) {
                                ladda.stop();

                                if (res.success) {
                                    Swal.fire('Thành công', res.message, 'success')
                                        .then(function() {
                                            location.reload();
                                        });
                                } else {
                                    Swal.fire('Lỗi!', res.message, 'error');
                                }
                            },
                            error: function() {
                                ladda.stop();
                                new bootstrap.Toast(document.getElementById(
                                    'systemError')).show();
                            }
                        });
                    } else {
                        ladda.stop();
                    }
                });
            });

        });
    </script>
@stop

@section('title', 'Lịch sử mua hàng')

@section('content')
    @include('web.pages.information.components.history')
@stop
