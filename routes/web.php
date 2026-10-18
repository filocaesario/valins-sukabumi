<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MasterGponController;
use App\Http\Controllers\ValinsController; // Buka komentar ini jika Controller Valins sudah ada
use App\Http\Controllers\NavbarTabController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman Depan
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome'); // Ini adalah halaman awal bawaan Laravel
})->name('home');

/*
|--------------------------------------------------------------------------
| Halaman Kebijakan Privasi, Syarat Ketentuan & Hubungi Kami
|--------------------------------------------------------------------------
*/
Route::view('/kebijakan-privasi', 'legal.privacy-policy')->name('privacy.policy');
Route::view('/syarat-ketentuan', 'legal.terms-conditions')->name('terms.conditions');
Route::view('/hubungi-kami', 'contact-us')->name('contact.us');

// Alias pengalihan rute lama / bahasa Inggris untuk kompatibilitas tautan
Route::redirect('/privacy-policy', '/kebijakan-privasi');
Route::redirect('/privacy', '/kebijakan-privasi');
Route::redirect('/terms', '/syarat-ketentuan');
Route::redirect('/terms-conditions', '/syarat-ketentuan');
Route::redirect('/contact', '/hubungi-kami');
Route::redirect('/contact-us', '/hubungi-kami');
Route::redirect('/bantuan', '/hubungi-kami');

/*
|--------------------------------------------------------------------------
| Dashboard (Setelah Login)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Grup Rute Wajib Login (Sistem Utama)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Rute Bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 1. RUTE KE FOLDER MASTER GPON
    // Memanggil MasterGponController yang akan mengembalikan view('master-gpon.index')
    Route::get('/master-gpon', [MasterGponController::class, 'index'])->name('master-gpon.index');
    Route::post('/master-gpon/import', [MasterGponController::class, 'importExcel'])->name('master-gpon.import');

    // 2. RUTE KE FOLDER VALINS (Menggunakan ValinsController)
    Route::get('/valins', [ValinsController::class, 'index'])->name('valins.index');
    Route::get('/valins/create', [ValinsController::class, 'create'])->name('valins.create');
    Route::post('/valins', [ValinsController::class, 'store'])->name('valins.store');
    Route::get('/valins/{id}/edit', [ValinsController::class, 'edit'])->name('valins.edit');
    Route::put('/valins/{id}', [ValinsController::class, 'update'])->name('valins.update');
    Route::delete('/valins/{id}', [ValinsController::class, 'destroy'])->name('valins.destroy');

  // Rute fallback jika user merefresh URL /navbar-tabs atau mengaksesnya langsung
    Route::get('/navbar-tabs', function () {
        return redirect()->route('dashboard');
    });

    // CRUD Tab Dinamis
    Route::put('/navbar-tabs/{id}', [NavbarTabController::class, 'update'])->name('navbar-tabs.update');

    // Halaman khusus untuk masing-masing tab
    Route::get('/tab/{slug}', [NavbarTabController::class, 'show'])->name('navbar.custom');
});

/*
|--------------------------------------------------------------------------
| Sistem Autentikasi (Bawaan Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
