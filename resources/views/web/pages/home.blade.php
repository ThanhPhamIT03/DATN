@extends('web.layouts.master')

@section('title', 'Trang chủ')

@section('script')
    <script type="module">
        $(document).ready(function () {
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
    @include('web.sections.features-tablet')
    @include('web.sections.accessory')
    @include('web.sections.old-product')
    @include('web.sections.features-blog')
    <div class="overlay" style="display: none;"></div>
@stop

