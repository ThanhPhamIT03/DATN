<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Order\OrderDetailController;

Route::controller(OrderDetailController::class)->name('order.list.detail.')->prefix('order/list/detail')
    ->group(function() {
        Route::get('', 'index')->name('index');
});