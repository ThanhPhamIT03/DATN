<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Info\HistoryController;

Route::name('web.info.history.')->prefix('info/history')->controller(HistoryController::class)
    ->group(function() {
        Route::get('/', 'index')->name('index');
});
