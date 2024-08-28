<?php

use App\Http\Controllers\CardsController;
use App\Http\Controllers\WithdrawController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'withdraw');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::redirect('/dashboard', '/withdraw');

    Route::resource('withdraw', WithdrawController::class)
        ->only(['index']);

    Route::resource('cards', CardsController::class);
});
