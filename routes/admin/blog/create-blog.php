<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Blogs\CreateBlogController;

Route::controller(CreateBlogController::class)->name('blog.create.')->prefix('blog/create')
    ->group(function() {
        Route::get('', 'index')->name('index');
        Route::post('add', 'add')->name('add');
    });