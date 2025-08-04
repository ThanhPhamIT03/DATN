<section class="footer">
    <div class="container-xl pt-4 pb-4">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="footer-card">
                    <h4>Giới thiệu</h4>
                    <p style="color: var(--text-color); font-size: 15px; letter-spacing: 0.5px;">Sơn Thảo Mobile – trang mua sắm trực tuyến của hệ thống cửa hàng điện thoại uy tín, 
                        cung cấp điện thoại, phụ kiện chính hãng, giúp bạn dễ dàng tiếp cận công nghệ mới nhất.
                    </p>
                    <img src="{{ asset('./images/logo_bct.png')}}">
                    <ul class="footer-social d-flex align-content-center">
                        <li><a href="#"><i class="bi bi-facebook"></i></a></li>
                        <li><a href="#"><i class="bi bi-youtube"></i></a></li>
                        <li><a href="#"><i class="bi bi-instagram"></i></a></li>
                        <li><a href="#"><i class="bi bi-tiktok"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="footer-card">
                    <h4>Thông tin liên hệ</h4>
                    <ul class="contact-list">
                        <li><i class="bi bi-geo-alt"></i> <a href="https://maps.app.goo.gl/a6LSxcijhYrhSPht8" class="link-map">3 P. Phạm Khắc Quảng, Giang Biên, Long Biên, Hà Nội, Việt Nam</a></li>
                        <li><i class="bi bi-telephone"></i> 0337.005.347</li>
                        <li><i class="bi bi-phone-vibrate"></i> 0337.005.347</li>
                        <li><i class="bi bi-envelope"></i> thanhphamit.03@gmail.com</li>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="footer-card">
                    <h4>Liên kết</h4>
                    <ul class="footer-link">
                        <li><a href="#">Sản phẩm khuyến mãi</a></li>
                        <li><a href="#">Sản phẩm nổi bật</a></li>
                        <li><a href="#">Tất cả sản phẩm</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="footer-card">
                    <h4>Hỗ trợ</h4>
                    <ul class="footer-suport">
                        <li><a href="#">Tìm kiếm</a></li>
                        <li><a href="#">Giới thiệu</a></li>
                        <li><a href="#">Chính sách đổi trả</a></li>
                        <li><a href="#">Chính sách bảo mật</a></li>
                        <li><a href="#">Điều khoản dịch vụ</a></li>
                        <li><a href="#">Liên hệ</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <style>
        .footer {
            border-top: 1px solid #dbdbdb;
            border-bottom: 1px solid #dbdbdb;
        }
        .footer-card h4  {
            color: var(--text-heading-color);
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: 400;
        }
        .footer-card img {
            object-fit: cover;
            width: 150px;
            height: 50px;
            transform: translateX(-4%);
        }
        .footer-social {
            list-style-type: none;
            padding: 0;
            margin: 26px 0 0 0;
        }
        .footer-social li {
            margin-right: 10px;
            padding: 12px;
            border: 1px solid #dbdbdb;
            border-radius: 6px;
        }
        .footer-social li:hover {
            border-color: var(--primary-color);
            cursor: pointer;
        }
        .footer-social li a {
            text-decoration: none;
            color: var(--text-color);
            font-size: 18px;
            transition: color 0.3s ease;
        }
        .footer-social li:hover a {
            color: var(--primary-color);
        }
        .footer-social li a i {
            text-shadow: 0 0 1px currentColor;
        }
        .footer-card .contact-list {
            margin: 0;
            list-style-type: none;
            padding: 0;
        }
        .footer-card .contact-list li {
            padding: 8px 0;
            font-size: 15px;
            color: var(--text-color);
        }
        .footer-link {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        .footer-link li {
            padding: 8px 0;
        }
        .footer-link li a {
            text-decoration: none;
            color: var(--text-color);
            font-size: 15px;
            transition: ease-in-out 0.2s;
        }
        .footer-link li a:hover {
            cursor: pointer;
            color: var(--primary-color);
            text-decoration: underline;
        }
        .link-map {
            text-decoration: none;
            color: var(--text-color);
            transition: ease-in-out 0.2s;
        }
        .link-map:hover {
            cursor: pointer;
            color: var(--primary-color);
            text-decoration: underline;
        }
        .footer-suport {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        .footer-suport li {
            padding: 8px 0;
        }
        .footer-suport li a {
            color: var(--text-color);
            text-decoration: none;
            transition: ease-in-out 0.2s;
        }
        .footer-suport li a:hover {
            cursor: pointer;
            color: var(--primary-color);
        }
    </style>
</section>
<section class="sub-footer d-flex">
    <div class="m-auto">Copyright &copy; 2025 <a href="https://sonthao.mobile.com">Son Thao Mobile</a>. Powered by <a href="https://www.facebook.com/thanhpham.dev03">Thanh Pham</a></div>
    <style>
        .sub-footer {
            height: 80px;
            color: var(--text-color);
        }
        .sub-footer a {
            color: var(--text-color);
            text-decoration: none;
            font-weight: 600;
            transition: ease-in-out 0.2s;
        }
        .sub-footer a:hover {
            color: var(--primary-color);
            cursor: pointer;
            
        }
    </style>
</section>