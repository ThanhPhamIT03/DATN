<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Info\HistoryController;

Route::name('web.info.history.')->prefix('info/history')
    ->controller(HistoryController::class)
    ->middleware('auth')
    ->group(function() {
        Route::get('/', 'index')->name('index');
        Route::delete('cancel', 'cancel')->name('cancel');
});
