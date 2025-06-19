<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CategoryController;
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

    Route::resource('/categories', CategoryController::class)
        ->name('index', 'category')
        ->name('store', 'store.category')
        ->name('update', 'update.category')
        ->name('destroy', 'destroy.category');
});
