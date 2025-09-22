@extends('web.layouts.master-empty')

@section('title', 'Đổi mật khẩu')

@section('script')
    <script type="module">
        // Step 1: gửi OTP
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

                    Swal.fire('Thành công', res.message, 'success');
                } else {
                    Swal.fire('Lỗi!', res.message, 'error');
                }
            }).fail(function(err) {
                Swal.fire('Lỗi!', 'Có lỗi xảy ra, vui lòng thử lại', 'error');
            });
        });

        // Step 2: xác nhận OTP và đổi mật khẩu
        $(document).on('submit', '#updatePasswordForm', function(e) {
            e.preventDefault();

            $.post("{{ route('auth.reset.password') }}", $(this).serialize(), function(res) {
                if (res.success) {
                    Swal.fire('Thành công', res.message, 'success').then(() => {
                        window.location.href =
                        "{{ route('auth.login.index') }}"; 
                    });
                } else {
                    Swal.fire('Lỗi!', res.message, 'error');
                }
            }).fail(function(err) {
                Swal.fire('Lỗi!', 'Có lỗi xảy ra, vui lòng thử lại', 'error');
            });
        });
    </script>
@stop

@section('content')
    <div class="container d-flex align-items-center justify-content-center" style="min-height:100vh;">
        <div class="card shadow p-4" style="max-width: 500px; width: 100%;">
            <h4 class="mb-4 text-center">Đổi mật khẩu</h4>

            <!-- Step 1: Gửi OTP -->
            <form id="sendOtpForm">
                @csrf
                <div class="step step-1">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control" id="phone_verify" name="phone_verify"
                        placeholder="Nhập số điện thoại" required>
                    <button type="submit" class="btn btn-primary w-100 mt-3">Gửi mã OTP</button>
                </div>
            </form>

            <!-- Step 2: Xác nhận OTP + đổi mật khẩu -->
            <form id="updatePasswordForm" style="display: none;">
                @csrf
                <input type="hidden" name="phone" id="otp_phone">
                <div class="step step-2">
                    <label for="otp" class="form-label">Mã xác nhận (OTP)</label>
                    <input type="text" class="form-control" id="otp" name="otp" placeholder="Nhập mã OTP"
                        required>

                    <label for="new_password" class="form-label mt-3">Mật khẩu mới</label>
                    <input type="password" class="form-control" id="new_password" name="new_password"
                        placeholder="Nhập mật khẩu mới" required>

                    <label for="new_password_confirmation" class="form-label mt-3">Xác nhận mật khẩu mới</label>
                    <input type="password" class="form-control" id="new_password_confirmation"
                        name="new_password_confirmation" placeholder="Nhập lại mật khẩu mới" required>

                    <button type="submit" class="btn btn-success w-100 mt-3">Cập nhật mật khẩu</button>
                </div>
            </form>
        </div>
    </div>
@stop
