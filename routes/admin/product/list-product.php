<?php

use App\Http\Controllers\Admin\Product\ListProductController;
use Illuminate\Support\Facades\Route;

Route::controller(ListProductController::class)->name('product.')->prefix('product')
    ->group(function() {
        Route::get('list', 'index')->name('list.index');
});