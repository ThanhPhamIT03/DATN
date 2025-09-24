<?php

use App\Http\Controllers\Admin\Product\FeaturedProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;

Route::controller(FeaturedProductController::class)
    ->middleware(RoleMiddleware::class . ':admin,sadmin')
    ->name('product.featured.')
    ->prefix('product/featured')
    ->group(function() {
        Route::get('', 'index')->name('index');
        Route::post('status', 'status')->name('status');
        Route::post('add', 'add')->name('add');
        // Route::delete('/delete', 'delete')->name('list.delete');
});