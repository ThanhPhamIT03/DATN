<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Order\RequestOrderController;
use App\Http\Middleware\RoleMiddleware;

Route::controller(RequestOrderController::class)
    ->middleware(RoleMiddleware::class . ':admin,sadmin')
    ->name('order.request.')
    ->prefix('order/request')
    ->group(function() {
        Route::get('', 'index')->name('index');
        Route::post('status', 'status')->name('status');
    });