// resources/js/main.js
import $ from 'jquery';
window.$ = $;
window.jQuery = $;

export function initUI() {
    const $categoryBtn = $('.category');
    const $searchBtn = $('.search-container');
    const $categoryBlock = $('.category-block');
    const $searchHistory = $('.search-history');
    const $accBtn = $('#account');
    const $modalLogin = $('.modal-login');
    const $overlay = $('.overlay');

    function closeAll() {
        $categoryBlock.slideUp(200);
        $searchHistory.slideUp(200);
        $modalLogin.slideUp(200);
        $categoryBtn.removeClass('active');
        $overlay.fadeOut(200);
    }

    $categoryBtn.on('click', function (e) {
        e.stopPropagation();
        const isVisible = $categoryBlock.is(':visible');
        closeAll();
        if (!isVisible) {
            $categoryBlock.slideDown(200);
            $categoryBtn.addClass('active');
            $overlay.fadeIn(200);
        }
    });

    $searchBtn.on('click', function (e) {
        e.stopPropagation();
        const isVisible = $searchHistory.is(':visible');
        closeAll();
        if (!isVisible) {
            $searchHistory.slideDown(200);
            $overlay.fadeIn(200);
        }
    });

    $accBtn.on('click', function (e) {
        e.stopPropagation();
        const isVisible = $modalLogin.is(':visible');
        closeAll();
        if (!isVisible) {
            $modalLogin.slideDown(200);
            $overlay.fadeIn(200);
        }
    });

    $(document).on('click', function (e) {
        const $target = $(e.target);
        if (
            !$target.closest('.category, .category-block, #account, .modal-login, .search-container, .search-history').length
            && !$target.is('.overlay')
        ) {
            closeAll();
        }
    });

    $overlay.on('click', closeAll);
}

// Tự động khởi tạo
$(document).ready(initUI);
