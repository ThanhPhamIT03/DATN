<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Info\AccountController;

Route::name('web.info.account.')->prefix('info/account')
    ->controller(AccountController::class)
    ->middleware('auth')
    ->group(function() {
        Route::get('/', 'index')->name('index');
        Route::put('/update', 'update')->name('update');
        Route::post('add-address', 'addAddress')->name('add.address');
        Route::delete('delete-address', 'deleteAddress')->name('delete.address');
});
