<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Banner\AddBannerController;
use App\Http\Middleware\RoleMiddleware;

Route::controller(AddBannerController::class)
    ->middleware(RoleMiddleware::class . ':sadmin')
    ->name('banner.')
    ->prefix('banner')
    ->group(function() {
        Route::get('add', 'index')->name('add.index');
        Route::post('/', 'add')->name('add.new');
});

