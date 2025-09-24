<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Blogs\CreateBlogController;
use App\Http\Middleware\RoleMiddleware;

Route::controller(CreateBlogController::class)
    ->middleware(RoleMiddleware::class . ':admin,sadmin')
    ->name('blog.create.')
    ->prefix('blog/create')
    ->group(function() {
        Route::get('', 'index')->name('index');
        Route::post('add', 'add')->name('add');
    });