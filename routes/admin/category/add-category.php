<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Category\AddCategoryController;

Route::controller(AddCategoryController::class)->name('category.')->prefix('category')->group(function() {
    Route::get('add', 'index')->name('add.index');
    Route::post('/', 'add')->name('add.store');
});

