<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Landing page (public)
Route::get('/', function () {
    return view('landingPage');
})->name('landingPage');

// Halaman login & register
Route::get('/login', [UserController::class, 'showLoginForm'])->name('loginPage');
Route::get('/register', [UserController::class, 'showRegisterForm'])->name('registerPage');

// Proses login & register
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/register', [UserController::class, 'register'])->name('register');

// Logout
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// Halaman setelah login (optional redirect)
Route::get('/landingPage', function () {
    return view('landingPage'); // Ganti dengan view yang sesuai
})->middleware('auth')->name('landingPage');

Route::middleware(['web', 'auth:pembeli'])->group(function () {
    Route::get('/dashboard/pembeli', function () {
        return view('dashboard.pembeli');
    })->name('dashboard.pembeli');
});


        Route::get('/dashboard/cs', fn () => view('dashboard.cs'))->name('dashboard.cs');
        Route::get('/dashboard/gudang', fn () => view('dashboard.gudang'))->name('dashboard.gudang');
        Route::get('/dashboard/admin', fn () => view('dashboard.admin'))->name('dashboard.admin');
        Route::get('/dashboard/kurir', fn () => view('dashboard.kurir'))->name('dashboard.kurir');
        Route::get('/dashboard/hunter', fn () => view('dashboard.hunter'))->name('dashboard.hunter');
        Route::get('/dashboard/owner', function () {
            Log::info('Dashboard owner diakses oleh', ['user' => Auth::guard('pegawai')->user()]);
            return view('dashboard.owner');
        })->name('dashboard.owner');

Route::middleware(['web', 'auth:organisasi'])->group(function () {
    Route::get('/dashboard/organisasi', function () {
        return view('dashboard.organisasi');
    })->name('dashboard.organisasi');
});

Route::middleware(['web', 'auth:penitip'])->group(function () {
    Route::get('/dashboard/penitip', function () {
        return view('dashboard.penitip');
    })->name('dashboard.penitip');
});