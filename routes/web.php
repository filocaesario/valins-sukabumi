<?php

use App\Http\Controllers\ValinsController;
use Illuminate\Support\Facades\Route;

// Pastikan route '/' mengarah ke controller kita, BUKAN ke view('welcome')
Route::get('/', [ValinsController::class, 'index'])->name('valins.index');

// Tambahkan dua baris ini:
Route::get('/valins/{id}/edit', [ValinsController::class, 'edit'])->name('valins.edit');
Route::put('/valins/{id}', [ValinsController::class, 'update'])->name('valins.update');

Route::get('/valins/create', [ValinsController::class, 'create'])->name('valins.create');
Route::post('/valins', [ValinsController::class, 'store'])->name('valins.store');

Route::delete('/valins/{id}', [ValinsController::class, 'destroy'])->name('valins.destroy');
