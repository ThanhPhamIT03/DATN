@extends('web.layouts.master')

@section('title', 'Trang chủ')

@section('script')
    <script type="module">
        $(document).ready(function () {
            const $categoryBtn = $('.category');
            const $searchBtn = $('.search-container');
            const $categoryBlock = $('.category-block');
            const $searchHistory = $('.search-history');

            // Toggle hiển thị kèm hiệu ứng trượt
            $categoryBtn.on('click', function (e) {
                e.stopPropagation(); 

                if ($categoryBlock.is(':visible')) {
                    $categoryBlock.slideUp(200);
                    $categoryBtn.removeClass('active');
                } else {
                    $categoryBlock.slideDown(200);
                    $categoryBtn.addClass('active');
                }
            });
            $searchBtn.on('click', function(e) {
                e.stopPropagation();

                if ($searchHistory.is(':visible')) {
                    $searchHistory.slideUp(200);
                } else {
                    $searchHistory.slideDown(200);
                }
            });

            // Click ra ngoài thì ẩn và remove class
            $(document).on('click', function (e) {
                if (!$(e.target).closest('.category, .category-block').length) {
                    $categoryBlock.slideUp(200);
                    $categoryBtn.removeClass('active');
                }
                if (!$(e.target).closest('.search-container, .search-history').length) {
                    $searchHistory.slideUp(200);
                }
            });
        });
    </script>
@stop

@section('content')
    
@stop

