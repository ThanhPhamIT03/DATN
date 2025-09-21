<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Order\RequestOrderController;

Route::controller(RequestOrderController::class)->name('order.request.')->prefix('order/request')
    ->group(function() {
        Route::get('', 'index')->name('index');
        Route::post('status', 'status')->name('status');
    });