<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('/accounts', AccountController::class)
        ->name('index', 'account')
        ->name('store', 'store.account')
        ->name('update', 'update.account')
        ->name('destroy', 'destroy.account');
});
