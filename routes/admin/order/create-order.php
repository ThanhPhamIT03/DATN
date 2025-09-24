<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Order\CreateOrderController;

Route::controller(CreateOrderController::class)->name('order.create.')->prefix('order/create')
    ->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('search-user', 'searchUser')->name('search.user');
        Route::get('search-product', 'searchProduct')->name('search.product');
        Route::get('search-variant', 'searchVariant')->name('search.variant');
        Route::post('store', 'store')->name('store');
    });

