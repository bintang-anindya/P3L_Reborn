<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DiskusiController;
use App\Http\Controllers\AlamatController;

//alamatManager
Route::get('/alamatManager', [AlamatController::class, 'index'])->name('alamat.manager');
Route::post('/alamat', [AlamatController::class, 'store'])->name('alamat.store');
Route::put('/alamat/{id}', [AlamatController::class, 'update'])->name('alamat.update');
Route::delete('/alamat/{id}', [AlamatController::class, 'destroy'])->name('alamat.destroy');
Route::get('/alamat/cari', [AlamatController::class, 'search'])->name('alamat.search');

// Landing page (public)
// Route::get('/', function () {
//     return view('dashboard');
// })->name('dashboard');

// Profile
Route::get('/profile', [ProfileController::class, 'showProfilePenitip'])->middleware('web', 'auth:penitip')->name('profile.penitip');


// Halaman login & register
Route::get('/login', [UserController::class, 'showLoginForm'])->name('loginPage');
Route::get('/register', [UserController::class, 'showRegisterForm'])->name('registerPage');

// Halaman Change Password
Route::get('/change-password', [ChangePasswordController::class, 'showForm'])->name('changePasswordPage');
Route::post('/change-password', [ChangePasswordController::class, 'changePasswordSubmit'])->name('changePasswordSubmit');

// Reset password form (untuk pembeli saja)
// Menampilkan form reset password (GET)
Route::get('/resetPassword', [ChangePasswordController::class, 'showResetForm'])
    ->name('resetPasswordPage')
    ->middleware('signed');
// Menangani pengiriman form reset password (POST)
Route::post('/reset-password', [ChangePasswordController::class, 'resetPassword'])
    ->name('resetPasswordSubmit');

// Organisasi
Route::resource('organisasi', OrganisasiController::class);
Route::post('/organisasi/delete', [OrganisasiController::class, 'destroy'])->name('organisasi.destroy');

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('/kategori/{id}', [DashboardController::class, 'tampilkanKategori'])->name('kategori');

// -------------------- BARANG --------------------
Route::get('/barang/{id}', [BarangController::class, 'showDetail'])->name('detailBarang');
Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
// Route::get('/barang', [BarangController::class, 'index2'])->name('barang.index2');
//Route::get('/barang/{id}', [BarangController::class, 'show'])->name('barang.show');
Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');
Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');

// Proses login & register
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/register', [UserController::class, 'register'])->name('register');

// Logout
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// Halaman setelah login (optional redirect)
Route::get('/dashboard', function () {
    return view('dashboard'); // Ganti dengan view yang sesuai
})->middleware('auth')->name('dashboard');

Route::middleware(['web', 'auth:pembeli'])->group(function () {
    Route::get('/dashboard/pembeli', function () {
        return view('dashboard.pembeli');
    })->name('dashboard.pembeli');
});

Route::get('/dashboard/penitip', [BarangController::class, 'dashboardPenitip'])->name('dashboard.penitip');

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

// diskusi
Route::get('/diskusi', [DiskusiController::class, 'index'])->name('diskusi.index');
Route::get('/diskusi/{id}', [DiskusiController::class, 'show'])->name('diskusi.show');
Route::post('/diskusi/{id}/balasan', [DiskusiController::class, 'storeBalasan'])->name('diskusi.storeBalasan');

Route::get('/pegawai/reset-password', [UserController::class, 'showResetPasswordPegawai'])->name('pegawai.resetPassword');
Route::post('/pegawai/reset-password/{id}', [UserController::class, 'resetPasswordPegawai'])->name('pegawai.resetPassword.submit');
Route::get('/resetPasswordPegawai', [UserController::class, 'showResetPasswordPegawai'])->name('pegawai.resetPassword');
