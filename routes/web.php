<?php

use App\Http\Controllers\WithdrawController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'dashboard');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('withdraw', WithdrawController::class)
        ->only(['index']);
});
