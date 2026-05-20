<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FinansaiController;
use App\Http\Controllers\KategorijaController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::middleware(['auth'])->group(function () {

    Route::get('/finansai', [FinansaiController::class, 'index'])->name('finansai');

    Route::post('/finansai/store', [FinansaiController::class, 'store'])->name('finansai.store');

    Route::put('/finansai/update/{id}', [FinansaiController::class, 'update'])->name('finansai.update');

    Route::delete('/finansai/delete/{id}', [FinansaiController::class, 'destroy'])->name('finansai.delete');
});

Route::resource('kategorijos', KategorijaController::class);