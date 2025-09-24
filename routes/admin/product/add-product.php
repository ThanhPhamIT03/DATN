<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Product\AddProductController;
use App\Http\Middleware\RoleMiddleware;

Route::controller(AddProductController::class)
    ->middleware(RoleMiddleware::class . ':admin,sadmin')
    ->name('product.')
    ->prefix('product')
    ->group(function() {
        Route::get('add', 'index')->name('add.index');
        Route::post('add', 'add')->name('add.store');
});