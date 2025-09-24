<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Blogs\ListBlogController;
use App\Http\Middleware\RoleMiddleware;

Route::controller(ListBlogController::class)
    ->middleware(RoleMiddleware::class . ':admin,sadmin')
    ->name('blog.list.')
    ->prefix('blog/list')
    ->group(function() {
        Route::get('', 'index')->name('index');
        Route::delete('delete', 'delete')->name('delete');
        Route::get('detail/{id}', 'viewEdit')->name('view.edit');
        Route::put('edit-title', 'editTitle')->name('edit.title');
        Route::put('edit-content', 'editContent')->name('edit.content');
    });