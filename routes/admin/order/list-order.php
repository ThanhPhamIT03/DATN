<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Order\ListOrderController;
use App\Http\Middleware\RoleMiddleware;

Route::controller(ListOrderController::class)
    ->middleware(RoleMiddleware::class . ':admin,sadmin')
    ->name('order.list.')
    ->prefix('order/list')
    ->group(function() {
        Route::get('', 'index')->name('index');
        Route::post('status', 'status')->name('status');
        Route::get('export','export')->name('export');
});