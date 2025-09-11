<?php

use App\Http\Controllers\Admin\Product\FeaturedProductController;
use Illuminate\Support\Facades\Route;

Route::controller(FeaturedProductController::class)->name('product.')->prefix('product')
    ->group(function() {
        Route::get('featured', 'index')->name('featured.index');
        Route::post('featured/status', 'status')->name('featured.status');
        Route::post('/add', 'add')->name('featured.add');
        // Route::delete('/delete', 'delete')->name('list.delete');
});