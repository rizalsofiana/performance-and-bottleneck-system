<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// TODO: ganti dengan AuthController::login (Sanctum/session) setelah modul
// autentikasi backend dibangun. Untuk saat ini hanya placeholder agar form
// (murni HTML, tanpa JavaScript) bisa di-submit dan diarahkan ke dashboard.
Route::post('/login', function () {
    return redirect()->route('dashboard');
});

// TODO: ganti dengan halaman dashboard SmartHRIS yang sesungguhnya
// setelah modul dashboard dikonversi ke Blade (saat ini masih placeholder
// agar redirect setelah login tidak mengarah ke halaman 404).
Route::get('/dashboard', function () {
    return view('welcome');
})->name('dashboard');
