<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Info\InformationController;

Route::name('web.info.')->prefix('info')->controller(InformationController::class)->group(function() {
    Route::get('/', 'index')->name('index');
});