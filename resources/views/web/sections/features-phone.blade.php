<section>
    <div class="container-xl p-4">
        <h4 class="m-0 fearture-phone-heading">Điện thoại nổi bật</h4>
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-4">
            <div class="col" onclick="window.location.href='{{route('auth.login.index')}}'">
                <div class="card position-relative shadow-sm rounded-3 border-0 h-100">
                    <div class="position-absolute bg-danger text-white px-2 py-1 small custom-badge-left">
                        Giảm 15%
                    </div>
                    <div class="position-absolute bg-primary text-white px-2 py-1 small custom-badge-right">
                        Trả góp 0%
                    </div>
                    <img src="{{ asset('./images/iphone-16-pro-max.webp') }}" class="card-img-top img-product" alt="iPhone 16 Pro Max">
                    <div class="card-body p-2">
                        <h6 class="card-title mb-1" style="font-size: 0.95rem; font-weight: 500;">
                            iPhone 16 Pro Max 256GB | Chính hãng VN/A
                        </h6>
                    <div class="mb-1">
                        <span class="text-danger fw-bold" style="font-size: 1.1rem;">29.690.000₫</span>
                        <span class="text-muted text-decoration-line-through small">34.990.000₫</span>
                    </div>
                    <div class="bg-light border rounded px-2 py-1 small text-dark mb-1" style="font-size: 0.75rem;">
                        Member giảm đến 297.000đ
                    </div>
                </div>
            </div>
        </div>
    </div>
  <style>
    .fearture-phone-heading {
        padding: 32px 0 48px 0;
        color: var(--text-heading-color);
        font-size: 32px;
        position: relative; 
        display: inline-block;
    }

    .fearture-phone-heading::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 40px; 
        width: 60%; 
        height: 4px;
        background-color: var(--primary-color, #007bff); 
        border-radius: 2px;
    }
     .img-product {
        height: 180px;
        margin-top: 30px;               
        object-fit: contain;  
        padding: 10px;              
        transition: 0.3s ease-in-out;
    }
    .img-product:hover {
        cursor: pointer;
        scale: 1.04;
    }
    .custom-badge-left {
        top: -10px;
        left: -6px;
        border-top-right-radius: 6px;
        border-top-left-radius: 6px;
        border-bottom-right-radius: 6px;
    }
    .custom-badge-left::after {
        content: "";
        position: absolute;
        bottom: -14px;
        left: 3px;
        transform: translateY(-50%) rotate(-45deg); 
        width: 0;
        height: 0;
        border-top: 6px solid transparent;
        border-bottom: 6px solid transparent;
        border-left: 6px solid #dc3545;
    }
    .custom-badge-right {
        top: -10px;
        right: -6px;
        border-top-left-radius: 6px;
        border-top-right-radius: 6px;
        border-bottom-left-radius: 6px;
    }
    .custom-badge-right::after {
        content: "";
        position: absolute;
        bottom: -14px;
        right: 3px;
        transform: translateY(-50%) rotate(223deg); 
        width: 0;
        height: 0;
        border-top: 6px solid transparent;
        border-bottom: 6px solid transparent;
        border-left: 6px solid #007bff;
    }
  </style>
</section>
