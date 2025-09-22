@extends('web.pages.information.layouts.master')

@section('script')
    <script type="module">
        $(document).ready(function() {
            $('#btn-update').on('click', function() {
                $('#updateForm').submit();
            });
            $('#btn-add-address').on('click', function() {
                $('#addAddressForm').submit();
            });

            $('.btn-delete').on('click', function(e) {
                e.preventDefault();

                let btn = this;
                let key = $(btn).data('key');
                let url = $(btn).data('url');

                let ladda = Ladda.create(btn);
                ladda.start();

                $.ajax({
                    url: url,
                    method: 'DELETE',
                    data: {
                        key: key,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        ladda.stop();

                        if (res.success) {
                            Swal.fire('Thành công!', res.message, 'success').then(function() {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Lỗi', res.message, 'error');
                        }
                    },
                    error: function() {
                        ladda.stop();
                        Swal.fire('Lỗi!', 'Lỗi hệ thống.', 'error');
                    }
                });
            });

            $(document).on('submit', '#sendOtpForm', function(e) {
                e.preventDefault();
                let phone = $('#phone_verify').val();

                $.post("{{ route('auth.reset.sendOtp') }}", {
                    _token: "{{ csrf_token() }}",
                    phone: phone
                }, function(res) {
                    if (res.success) {
                        $('#otp_phone').val(phone);

                        // Ẩn step 1, hiện step 2
                        $('#sendOtpForm').hide();
                        $('#updatePasswordForm').show();

                        Swal.fire('Thành công', res.message,'success');
                    } else {
                        Swal.fire('Lỗi!', res.message, 'error');
                    }
                });
            });

            $(document).on('submit', '#updatePasswordForm', function(e) {
                e.preventDefault();

                $.post("{{ route('auth.reset.password') }}", $(this).serialize(), function(res) {
                    if (res.success) {
                        Swal.fire('Thành công', res.message, 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Lỗi!', res.message, 'error');
                    }
                });
            });
        });
    </script>
@stop

@section('title', 'Thông tin tài khoản')

@section('content')
    @include('web.pages.information.components.account-info')
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
