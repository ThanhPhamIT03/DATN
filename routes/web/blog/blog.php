<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Blog\BlogController;

Route::controller(BlogController::class)->name('web.blog.')->prefix('web/blog')
    ->group(function() {
        Route::get('list', 'list')->name('list');
        Route::get('detail/{id}', 'detail')->name('detail');
    });