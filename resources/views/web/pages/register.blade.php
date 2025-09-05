@extends('web.layouts.master-empty')

@section('title', 'Đăng ký')

@section('script')
    <script type="module">
        $(document).ready(function() {
            // Toggle hiện/ẩn mật khẩu
            $('.toggle-password').on('click', function() {
                const inputSelector = $(this).data('target');
                const input = $(inputSelector);
                const iconShow = $(this).find('.toggle-icon-show');
                const iconHide = $(this).find('.toggle-icon-hide');

                // Đổi type input
                const isPassword = input.attr('type') === 'password';
                input.attr('type', isPassword ? 'text' : 'password');

                // Đổi icon
                iconShow.toggleClass('d-none', !isPassword);
                iconHide.toggleClass('d-none', isPassword);
            });

            // Validate form
            $('#register-form').validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 2
                    },
                    date: {
                        required: true,
                        date: true
                    },
                    phone: {
                        required: true,
                        digits: true,
                        minlength: 9,
                        maxlength: 15
                    },
                    email: {
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 6
                    },
                    password_confirm: {
                        required: true,
                        equalTo: "#password"
                    }
                },
                messages: {
                    name: {
                        required: "Vui lòng nhập họ và tên",
                        minlength: "Họ và tên phải ít nhất 2 ký tự"
                    },
                    date: {
                        required: "Vui lòng chọn ngày sinh",
                        date: "Ngày sinh không hợp lệ"
                    },
                    phone: {
                        required: "Vui lòng nhập số điện thoại",
                        digits: "Số điện thoại chỉ được nhập số",
                        minlength: "Số điện thoại quá ngắn",
                        maxlength: "Số điện thoại quá dài"
                    },
                    email: {
                        email: "Email không hợp lệ"
                    },
                    password: {
                        required: "Vui lòng nhập mật khẩu",
                        minlength: "Mật khẩu tối thiểu 6 ký tự"
                    },
                    password_confirm: {
                        required: "Vui lòng nhập lại mật khẩu",
                        equalTo: "Mật khẩu nhập lại không khớp"
                    }
                },
                errorClass: 'is-invalid',
                errorElement: 'div',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function(element, errorClass) {
                    $(element).addClass(errorClass);
                    // Ẩn toggle password icon khi lỗi
                    $(element).closest('.position-relative').find('.toggle-password').addClass(
                    'd-none');
                },
                unhighlight: function(element, errorClass) {
                    $(element).removeClass(errorClass);
                    // Hiện toggle password icon lại
                    $(element).closest('.position-relative').find('.toggle-password').removeClass(
                        'd-none');
                }
            });

            $('#btn-register').on('click', function() {
                document.getElementById('register-form').requestSubmit();
            });
        });
    </script>
@stop

@section('content')
    <div id="register-page"
        style="background-color: var(--bgr-gray); min-height: 100vh; position: relative; padding: 1.5rem 0 4rem 0;">
        <div class="regis-block w-100 w-md-75 mx-auto" style="max-width: 800px;" data-aos="fade-up" data-aos-duration="1000"
            data-aos-delay="300">
            <h4 class="mb-4 text-center" style="color: var(--primary-color); font-size: 30px; text-transform: uppercase;">
                Đăng ký tài khoản thành viên
            </h4>

            <div class="divider">
                <span>Đăng ký bằng tài khoản mạng xã hội</span>
            </div>
            <div class="d-flex justify-content-center gap-3 mt-4">
                <a href="#" class="btn-login-social d-flex align-items-center justify-content-center">
                    <img src="{{ asset('/images/google.webp') }}" alt="Google" width="20" height="20"
                        class="me-2">
                    <span class="text-dark fw-medium">Google</span>
                </a>
                <a href="#" class="btn-login-social d-flex align-items-center justify-content-center">
                    <img src="{{ asset('./images/zalo.png') }}" alt="Zalo" width="20" height="20" class="me-2">
                    <span class="text-dark fw-medium">Zalo</span>
                </a>
            </div>

            <div class="divider mt-4">
                <span>Hoặc đăng ký bằng số điện thoại</span>
            </div>

            <!-- FORM -->
            <form id="register-form" class="form-section mt-4" method="POST" action="{{ route('auth.register.store') }}">
                @csrf
                <h5>Thông tin cá nhân</h5>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="fullname" class="form-label">Họ và tên (bắt buộc)</label>
                        <input type="text" class="form-control input-custom" name="name" id="fullname"
                            placeholder="Nhập họ và tên" required>
                    </div>
                    <div class="col-md-6">
                        <label for="dob" class="form-label">Ngày sinh (bắt buộc)</label>
                        <input type="date" class="form-control input-custom" name="date" id="dob"
                            placeholder="dd/mm/yyyy" required>
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Số điện thoại (bắt buộc)</label>
                        <input type="tel" class="form-control input-custom" name="phone" id="phone"
                            placeholder="Nhập số điện thoại" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email <span class="text-muted">(Không bắt
                                buộc)</span></label>
                        <input type="email" class="form-control input-custom" name="email" id="email"
                            placeholder="Nhập email">
                        <div class="form-note mt-1">Hóa đơn VAT khi mua hàng sẽ được gửi qua email này</div>
                    </div>
                </div>

                <h5 class="mt-4">Tạo mật khẩu</h5>
                <div class="row g-3 mb-3 position-relative">
                    <!-- Mật khẩu -->
                    <div class="col-md-6 position-relative">
                        <label for="password" class="form-label">Mật khẩu (bắt buộc)</label>
                        <input type="password" class="form-control input-custom" name="password" id="password"
                            placeholder="Nhập mật khẩu của bạn" required>

                        <!-- Toggle icon -->
                        <span class="toggle-password position-absolute end-0 me-3" data-target="#password"
                            style="cursor: pointer; top: 42%;">
                            <i class="bi bi-eye toggle-icon-show"></i>
                            <i class="bi bi-eye-slash toggle-icon-hide d-none"></i>
                        </span>

                        <small class="form-text text-muted mt-1 d-block">
                            Mật khẩu tối thiểu 6 ký tự, có ít nhất 1 chữ và 1 số
                        </small>
                    </div>

                    <!-- Nhập lại mật khẩu -->
                    <div class="col-md-6 position-relative">
                        <label for="confirm-password" class="form-label">Nhập lại mật khẩu (bắt buộc)</label>
                        <input type="password" class="form-control input-custom" name="password_confirm"
                            id="confirm-password" placeholder="Nhập lại mật khẩu" required>

                        <!-- Toggle icon -->
                        <span class="toggle-password position-absolute end-0 me-3 fluid" data-target="#confirm-password"
                            style="cursor: pointer; top: 42%;">
                            <i class="bi bi-eye toggle-icon-show"></i>
                            <i class="bi bi-eye-slash toggle-icon-hide d-none"></i>
                        </span>
                    </div>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" name="regis_promo" type="checkbox" id="subscribe">
                    <label class="form-check-label" for="subscribe">
                        Đăng ký nhận tin khuyến mãi
                    </label>
                </div>

                <div class="terms mb-5">
                    Bằng việc Đăng ký, bạn đã đọc và đồng ý với
                    <a href="#" target="_blank">Điều khoản sử dụng</a> và
                    <a href="#" target="_blank">Chính sách bảo mật của chúng tôi</a>.
                </div>

                <div class="d-flex justify-content-center gap-3 mb-5">
                    <span>Bạn đã có tài khoản?
                        <a href="{{ route('auth.login.index') }}" class="regis-redirect">Đăng nhập ngay</a>
                    </span>
                </div>
            </form>
        </div>

        <!-- Nút đăng ký dính dưới -->
        <button type="button" class="btn btn-primary" id="btn-register"
            style="
                position: fixed;
                bottom: 16px;
                left: 0;
                right: 0;
                margin: auto;
                width: 100%;
                max-width: 800px;
                height: 48px;
                z-index: 1050;
            ">
            Đăng ký
        </button>
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

    <style>
        .btn-login-social {
            width: 200px;
            height: 48px;
            border-radius: 8px;
            border: 1px solid #dbdbdb;
            text-decoration: none;
            background-color: var(--bgr-gray);
            transition: background-color 0.3s ease-in-out;
        }

        .btn-login-social:hover {
            cursor: pointer;
            background-color: #ebeaea;
        }

        input.is-invalid {
            border-color: #dc3545;
        }
    </style>
@stop
