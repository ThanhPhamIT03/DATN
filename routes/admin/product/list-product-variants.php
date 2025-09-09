<?php

use App\Http\Controllers\Admin\Product\ListProductVariantsController;
use Illuminate\Support\Facades\Route;

Route::controller(ListProductVariantsController::class)->name('product.')->prefix('product')
    ->group(function() {
        Route::get('list-variants', 'index')->name('list.variants.index');
});