<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Category\AddCategoryController;
use App\Http\Middleware\RoleMiddleware;

Route::controller(AddCategoryController::class)
    ->middleware(RoleMiddleware::class . ':sadmin')
    ->name('category.')
    ->prefix('category')
    ->group(function() {
        Route::get('add', 'index')->name('add.index');
        Route::post('/', 'add')->name('add.store');
});

