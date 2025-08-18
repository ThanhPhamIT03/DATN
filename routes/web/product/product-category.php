<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Product\ProductCategoryController;

Route::name('web.product-category.')->prefix('/product-category')
    ->controller(ProductCategoryController::class)
    ->group(function() {

        Route::get('/', 'index')->name('index');
});