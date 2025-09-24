<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Brand\BrandController;
use App\Http\Middleware\RoleMiddleware;

Route::controller(BrandController::class)
    ->middleware(RoleMiddleware::class . ':sadmin')
    ->name('brand.')->prefix('brand')
    ->group(function() {
        Route::get('list', 'index')->name('list.index');
        Route::post('add', 'add')->name('list.add');
        Route::post('status', 'status')->name('list.status');
        Route::put('edit', 'edit')->name('list.edit');
        Route::delete('delete', 'delete')->name('list.delete');
});