<?php

use App\Http\Controllers\Admin\Product\FeaturedProductController;
use Illuminate\Support\Facades\Route;

Route::controller(FeaturedProductController::class)->name('product.featured.')->prefix('product/featured')
    ->group(function() {
        Route::get('', 'index')->name('index');
        Route::post('status', 'status')->name('status');
        Route::post('add', 'add')->name('add');
        // Route::delete('/delete', 'delete')->name('list.delete');
});