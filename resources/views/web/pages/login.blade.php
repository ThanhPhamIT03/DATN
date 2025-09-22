@extends('web.layouts.master-empty')

@section('title', 'Đăng nhập')

@section('script')
    <script type="module">
        $(document).ready(function() {
            // Toggle password
            $('.toggle-password').on('click', function() {
                const input = $('#password');
                const iconShow = $(this).find('.toggle-icon-show');
                const iconHide = $(this).find('.toggle-icon-hide');

                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    iconShow.addClass('d-none');
                    iconHide.removeClass('d-none');
                } else {
                    input.attr('type', 'password');
                    iconShow.removeClass('d-none');
                    iconHide.addClass('d-none');
                }
            });

            // Hiện icon khi nhập mật khẩu
            $('#password').on('input', function() {
                const val = $(this).val();
                if (val.length > 5) {
                    $('.toggle-password').removeClass('d-none');
                } else {
                    $('.toggle-password').addClass('d-none');
                }
            });

            // jQuery Validate
            $('#login-form').validate({
                rules: {
                    phone_number: {
                        required: true,
                        digits: true,
                        minlength: 9,
                        maxlength: 11
                    },
                    password: {
                        required: true,
                        minlength: 6
                    }
                },
                messages: {
                    phone_number: {
                        required: "Vui lòng nhập số điện thoại.",
                        digits: "Số điện thoại chỉ được chứa số.",
                        minlength: "Số điện thoại tối thiểu 9 chữ số.",
                        maxlength: "Số điện thoại tối đa 11 chữ số."
                    },
                    password: {
                        required: "Vui lòng nhập mật khẩu.",
                        minlength: "Mật khẩu tối thiểu 6 ký tự."
                    }
                },
                errorElement: "div",
                errorClass: "invalid-feedback",
                highlight: function(element) {
                    $(element).addClass("is-invalid");
                },
                unhighlight: function(element) {
                    $(element).removeClass("is-invalid");
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                }
            });
        });
    </script>
@stop

@section('content')
    <div id="login-page" class="container-fluid">
        <div class="row justify-content-center align-items-center" style="height: 100vh">
            <!-- Cột bên trái -->
            <div class="col-md-6 h-100 d-flex align-items-center justify-content-center" data-aos="fade-right"
                data-aos-duration="1000" data-aos-delay="300" style="background-color: var(--bgr-gray);">
                <div class="w-100 login-banner" style="padding: 0 120px;">
                    <div class="login-banner-img d-flex mb-4">
                        <img src="{{ asset('./images/default/logo-website.png') }}">
                    </div>
                    <div class="login-banner-title">
                        <h4>Đăng nhập để không bỏ lỡ các ưu đãi hấp dẫn từ <span>Sơn Thảo Mobile</span></h4>
                    </div>
                    <div class="offer-box">
                        <ul class="offer-list">
                            <li>
                                <i class="bi bi-gift-fill me-2"></i><strong>Miễn phí giao hàng</strong> cho thành viên và
                                cho đơn hàng giá trị từ 300K.
                            </li>
                            <li>
                                <i class="bi bi-gift-fill me-2"></i><strong>Tặng voucher sinh nhật lên đến 500K</strong> cho
                                thành viên.
                            </li>
                            <li>
                                <i class="bi bi-gift-fill me-2"></i>Thu cũ đổi mới trợ giá <strong>lên đến 1 triệu.</strong>
                            </li>
                            <li>
                                <i class="bi bi-gift-fill me-2"></i>Thăng hạng <strong>nhận voucher lên đến 400K.</strong>
                            </li>
                            <li>
                                <i class="bi bi-gift-fill me-2"></i><strong>Ưu đãi lên đến 10%</strong> đối với học sinh -
                                sinh viên.
                            </li>
                        </ul>
                        <div class="text-center mb-3">
                            <a class="view-promotion-detail" href="#">
                                Xem chi tiết các chính sách ưu đãi <i class="bi bi-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cột bên phải -->
            <div class="col-md-6 h-100 d-flex align-items-center justify-content-center" data-aos="zoom-in"
                data-aos-duration="1000" data-aos-delay="100">
                <div class="w-100 login-block" style="padding: 32px 120px;">
                    <h4 class="text-center">Đăng nhập thành viên</h4>
                    <form class="form-login" id="login-form" method="POST" action="{{ route('auth.login.login')}}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="phone_number">Số điện thoại</label>
                            <input type="text" class="form-control input-custom" id="phone_number"
                                value="{{ session('phone') ?? old('phone') }}" name="phone"
                                placeholder="Nhập số điện thoại của bạn" required>
                        </div>
                        <div class="mb-3 position-relative">
                            <label class="form-label" for="password">Mật khẩu</label>
                            <input type="password" class="form-control pe-5 input-custom" id="password" name="password"
                                placeholder="Nhập mật khẩu của bạn" required>

                            <span class="toggle-password position-absolute end-0 me-3 d-none"
                                style="cursor: pointer; top: 55%;">
                                <i class="bi bi-eye toggle-icon-show"></i>
                                <i class="bi bi-eye-slash toggle-icon-hide d-none"></i>
                            </span>
                        </div>
                        <div class="mb-3 text-end">
                            <a href="{{ route('auth.reset.index') }}" class="small text-decoration-none" style="color: var(--primary-color)">Quên
                                mật khẩu?</a>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn-login">Đăng nhập</button>
                        </div>
                    </form>
                    <div class="divider">
                        <span>Hoặc đăng nhập bằng</span>
                    </div>
                    <div class="d-flex justify-content-center gap-3 mt-4">
                        <a href="{{ route('google.login') }}" class="btn-login-social d-flex align-items-center justify-content-center">
                            <img src="{{ asset('/images/google.webp') }}" alt="Google" width="20" height="20"
                                class="me-2">
                            <span class="text-dark fw-medium">Google</span>
                        </a>

                        <a href="#" class="btn-login-social d-flex align-items-center justify-content-center">
                            <img src="{{ asset('./images/zalo.png') }}" alt="Zalo" width="20" height="20"
                                class="me-2">
                            <span class="text-dark fw-medium">Zalo</span>
                        </a>
                    </div>
                    <div class="d-flex justify-content-center gap-3 mt-4">
                        <span>Bạn chưa có tài khoản?
                            <a href="{{ route('auth.register.index') }}" class="regis-redirect">Đăng ký ngay</a>
                        </span>
                    </div>
                    <div class="d-flex justify-content-start gap-3 mt-4">
                        <a class="btn btn-outline-primary" href="{{ route('home.index') }}"><i class="bi bi-arrow-left"></i>
                            Quay lại trang chủ</a>
                    </div>
                </div>
            </div>
        </div>
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
