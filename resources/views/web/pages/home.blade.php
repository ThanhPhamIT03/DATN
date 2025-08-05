@extends('web.layouts.master')

@section('title', 'Trang chủ')

@section('script')
    <script type="module">
        $(document).ready(function () {
            const $categoryBtn = $('.category');
            const $searchBtn = $('.search-container');
            const $categoryBlock = $('.category-block');
            const $searchHistory = $('.search-history');
            const $accBtn = $('#account');
            const $modalLogin = $('.modal-login');
            const $overlay = $('.overlay');

            // --- Toggle Category ---
            $categoryBtn.on('click', function (e) {
                e.stopPropagation();
                const isVisible = $categoryBlock.is(':visible');
                $('.category-block, .modal-login, .search-history').slideUp(200); // ẩn cái khác
                $categoryBtn.removeClass('active');

                if (!isVisible) {
                    $categoryBlock.slideDown(200);
                    $categoryBtn.addClass('active');
                    $overlay.fadeIn(200);
                } else {
                    $overlay.fadeOut(200);
                }
            });

            // --- Toggle Search ---
            $searchBtn.on('click', function (e) {
                e.stopPropagation();
                const isVisible = $searchHistory.is(':visible');
                $('.category-block, .modal-login').slideUp(200);
                $categoryBtn.removeClass('active');

                if (!isVisible) {
                    $searchHistory.slideDown(200);
                    $overlay.fadeIn(200);
                } else {
                    $searchHistory.slideUp(200);
                    $overlay.fadeOut(200);
                }
            });

            // --- Toggle Modal Login ---
            $accBtn.on('click', function (e) {
                e.stopPropagation();
                const isVisible = $modalLogin.is(':visible');
                $('.category-block, .search-history').slideUp(200);
                $categoryBtn.removeClass('active');

                if (!isVisible) {
                    $modalLogin.slideDown(200);
                    $overlay.fadeIn(200);
                } else {
                    $modalLogin.slideUp(200);
                    $overlay.fadeOut(200);
                }
            });

            // --- Click ngoài (document) ---
            $(document).on('click', function (e) {
                const $target = $(e.target);

                if (
                    !$target.closest('.category, .category-block, #account, .modal-login, .search-container, .search-history').length
                    && !$target.is('.overlay')
                ) {
                    $('.category-block, .modal-login, .search-history').slideUp(200);
                    $categoryBtn.removeClass('active');
                    $overlay.fadeOut(200);
                }
            });

            // --- Click overlay để đóng tất cả ---
            $overlay.on('click', function () {
                $('.category-block, .modal-login, .search-history').slideUp(200);
                $categoryBtn.removeClass('active');
                $overlay.fadeOut(200);
            });

            // -- Slide message ---
            const $slider = $('.slider-message');
            const $items = $slider.find('li');
            const itemHeight = $items.outerHeight();

            // Gộp tất cả <li> vào 1 container để dịch chuyển
            $slider.wrapInner('<div class="slider-inner"></div>');
            const $inner = $slider.find('.slider-inner');

            $inner.css({
                position: 'relative',
                top: 0,
            });

            // Set chiều cao phù hợp
            $items.css({
                height: itemHeight,
            });

            let index = 0;
            const total = $items.length;

            setInterval(function () {
                index++;

                $inner.animate({
                    top: `-${index * itemHeight}px`
                }, 500, function () {
                    // Nếu hết danh sách thì quay lại đầu
                    if (index >= total) {
                        $inner.css('top', 0);
                        index = 0;
                    }
                });
            }, 3000);

        });

        // Slider
        $(document).ready(function () {
            const $slider = $('.slide-container');
            const slideCount = $slider.children().length;
            let currentIndex = 0;

            function goToSlide(index) {
                const offset = -index * 100;
                $slider.css('transform', `translateX(${offset}%)`);
            }

            function nextSlide() {
                currentIndex = (currentIndex + 1) % slideCount;
                goToSlide(currentIndex);
            }

            // Tự động chuyển slide mỗi 4 giây
            setInterval(nextSlide, 4000);
        });

        // Xử lý phần yêu thích
        $(document).ready(function () {
            $('.favorite-toggle').on('click', function () {
                const $outline = $(this).find('.icon-outline');
                const $fill = $(this).find('.icon-fill');

                $outline.toggleClass('d-none');
                $fill.toggleClass('d-none');
            });
        });
    </script>
@stop

@section('content')
    @include('web.sections.slide')
    @include('web.sections.category-slide')
    @include('web.sections.features-phone')
    <div class="overlay" style="display: none;"></div>
@stop

