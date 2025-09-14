<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Order\ListOrderController;

Route::controller(ListOrderController::class)->name('order.list.')->prefix('order/list')
    ->group(function() {
        Route::get('', 'index')->name('index');
        Route::post('status', 'status')->name('status');
        Route::get('detail','detail')->name('detail');
});