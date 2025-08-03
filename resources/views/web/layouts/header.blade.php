<section class="header">
    <div class="header-top d-flex align-items-center justify-content-center">
        <ul class="d-flex align-items-center justify-content-center m-0 list-unstyled">
            <li style="font-size: 14px;"><strong>🚚 Miễn phí vận chuyển với đơn hàng trên 300K!</strong></li>
        </ul>
    </div>
    <div class="header-bottom">
        <div class="container-xl header-nav d-flex align-items-center justify-content-between">
            <div class="header-logo">
                <a href="{{ route('home.index') }}">
                    <img src="{{ asset('images/logo-website.png') }}">
                </a>
            </div>
            <div class="header-menu d-flex align-items-center justify-content-between">
                <div class="category btn-cus me-3">
                    <i class="bi bi-card-list"></i>
                    <span>Danh mục</span>
                    <i class="bi bi-chevron-down icon icon-down"></i>
                </div>

                <div class="call-buy btn-cus me-3">
                    <i class="bi bi-telephone"></i>
                    <span style="font-size: 14px;">0337.005.347</span>
                </div>
            </div>
            
            <form class="search-container d-flex justify-content-between ps-2">
                <input type="text" placeholder="Nhập từ khoá tìm kiếm ..." required>
                <button type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>

            <div class="header-action d-flex align-items-center justify-content-between">
                <div class="btn-cus me-3 ms-3" id="cart">
                    <span>Giỏ hàng</span>
                    <i class="bi bi-cart3 icon-act"></i>
                </div>
                <div class="btn-cus" id="account">
                    <span>Đăng nhập</span>
                    <i class="bi bi-person-circle icon-act"></i>
                </div>
            </div>
        </div>
    </div>
<style> 
    
</style>
</section>
