<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Blogs\ListBlogController;

Route::controller(ListBlogController::class)->name('blog.list.')->prefix('blog/list')
    ->group(function() {
        Route::get('', 'index')->name('index');
        Route::delete('delete', 'delete')->name('delete');
        Route::get('detail/{id}', 'viewEdit')->name('view.edit');
        Route::put('edit-title', 'editTitle')->name('edit.title');
        Route::put('edit-content', 'editContent')->name('edit.content');
    });