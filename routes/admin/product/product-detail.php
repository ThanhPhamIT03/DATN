<?php

use App\Http\Controllers\Admin\Product\ProductDetailController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;

Route::controller(ProductDetailController::class)
    ->middleware(RoleMiddleware::class . ':admin,sadmin')
    ->name('product.detail.')
    ->prefix('product/detail')
    ->group(function() {
        Route::get('', 'index')->name('index');
        Route::post('add', 'add')->name('add');
        Route::post('status', 'status')->name('status');
        Route::put('edit', 'edit')->name('edit');
        Route::delete('delete', 'delete')->name('delete');
});