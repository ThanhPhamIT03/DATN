<?php

use App\Http\Controllers\Admin\Product\ListProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;

Route::controller(ListProductController::class)
    ->middleware(RoleMiddleware::class . ':admin,sadmin')
    ->name('product.list.')
    ->prefix('product/list')
    ->group(function() {
        Route::get('list', 'index')->name('index');
        Route::post('status', 'status')->name('status');
        Route::put('edit', 'edit')->name('edit');
        Route::delete('delete', 'delete')->name('delete');
});