<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Search\SearchController;

Route::controller(SearchController::class)->name('web.search.')
    ->prefix('/search')
    ->group(function() {
        
        // Index
        Route::get('/result', 'index')->name('index');
        Route::delete('delete', 'delete')->name('delete');
});