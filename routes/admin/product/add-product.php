<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Product\AddProductController;

Route::controller(AddProductController::class)->name('product.')->prefix('product')
    ->group(function() {
        Route::get('add', 'index')->name('add.index');
        Route::post('add', 'add')->name('add.store');
});