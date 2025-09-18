<div class="col-md-4 info-menu">
    <ul class="info-menu-list">
        <li class="info-menu-item {{ (Route::currentRouteName() == 'web.info.index' ? 'active' : '') }}">
            <a href="{{ route('web.info.index') }}" class="info-menu-link">
                <i class="bi bi-house me-3"></i> Tổng quan <i class="bi bi-chevron-right"></i>
            </a>
        </li>
        <li class="info-menu-item {{ (Route::currentRouteName() == 'web.info.history.index' ? 'active' : '') }}">
            <a href="{{ route('web.info.history.index') }}" class="info-menu-link">
                <i class="bi bi-cart me-3"></i> Lịch sử mua hàng <i class="bi bi-chevron-right"></i>
            </a>
        </li>
        <li class="info-menu-item" id="info-btn">
            <a href="#" class="info-menu-link">
                <i class="bi bi-person me-3"></i> Thông tin cá nhân <i class="bi bi-chevron-right"></i>
            </a>
        </li>
        <li class="info-menu-item" id="warranty-btn">
            <a href="#" class="info-menu-link">
                <i class="bi bi-search me-3"></i> Tra cứu bảo hành <i class="bi bi-chevron-right"></i>
            </a>
        </li>
        <li class="info-menu-item" id="warranty-policy-btn">
            <a href="#" class="info-menu-link">
                <i class="bi bi-shield-check me-3"></i> Chính sách bảo hành <i class="bi bi-chevron-right"></i>
            </a>
        </li>
        <li class="info-menu-item" id="support-btn">
            <a href="#" class="info-menu-link">
                <i class="bi bi-chat-dots me-3"></i> Góp ý - Phản hồi - Hỗ trợ <i class="bi bi-chevron-right"></i>
            </a>
        </li>
        <li class="info-menu-item" id="policy-btn">
            <a href="#" class="info-menu-link">
                <i class="bi bi-file-earmark-text me-3"></i> Điều khoản sử dụng <i class="bi bi-chevron-right"></i>
            </a>
        </li>
        <li class="info-menu-item logout-item">
            <form method="POST" action="{{ route('auth.logout.logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="info-menu-link logout-btn">
                    <i class="bi bi-box-arrow-right me-3"></i> Đăng xuất <i class="bi bi-chevron-right"></i>
                </button>
            </form>
        </li>
    </ul>
</div>

