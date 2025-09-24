<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Banner\ListBannerController;
use App\Http\Middleware\RoleMiddleware;

Route::controller(ListBannerController::class)
    ->middleware(RoleMiddleware::class . ':sadmin')
    ->name('banner.')
    ->prefix('banner')
    ->group(function() {
        Route::get('list', 'index')->name('list.index');
        Route::post('status', 'status')->name('list.status');
        Route::put('edit', 'edit')->name('list.edit');
        Route::delete('delete', 'delete')->name('list.delete');
});