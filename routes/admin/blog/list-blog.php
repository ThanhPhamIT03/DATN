<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Blogs\ListBlogController;

Route::controller(ListBlogController::class)->name('blog.list.')->prefix('blog/list')
    ->group(function() {
        Route::get('', 'index')->name('index');
    });