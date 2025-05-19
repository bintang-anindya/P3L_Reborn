<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PenitipController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\RequestDonasiController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\DonasiController;
use App\Http\Controllers\OrganisasiController;


// LandingPage
Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('/kategori/{id}', [DashboardController::class, 'tampilkanKategori'])->name('kategori');

// -------------------- BARANG --------------------
Route::get('/barang/{id}', [BarangController::class, 'showDetail'])->name('detailBarang');
Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
//Route::get('/barang/{id}', [BarangController::class, 'show'])->name('barang.show');
Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');
Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');

// Halaman login & register
Route::get('/login', [UserController::class, 'showLoginForm'])->name('loginPage');
Route::get('/register', [UserController::class, 'showRegisterForm'])->name('registerPage');

// Proses login & register
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/register', [UserController::class, 'register'])->name('register');

Route::middleware(['auth:pembeli'])->get('/profil', [PembeliController::class, 'profil'])->name('profilPembeli');

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

Route::get('/dashboard/admin', function() {
    return redirect()->route('pegawai.index');
})->name('dashboard.admin');

Route::get('/dashboard/kurir', fn () => view('dashboard.kurir'))->name('dashboard.kurir');
Route::get('/dashboard/hunter', fn () => view('dashboard.hunter'))->name('dashboard.hunter');

Route::get('/dashboard/owner', [DonasiController::class, 'index'])->name('dashboard.owner');

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


Route::prefix('cs')->name('cs.')->group(function () {
    Route::get('/dataPenitip', [PenitipController::class, 'index'])->name('penitip.index');
    Route::post('/dataPenitip', [PenitipController::class, 'store'])->name('penitip.store');
    Route::get('/data-penitip/{id}/edit', [PenitipController::class, 'edit'])->name('penitip.edit');
    Route::put('/data-penitip/{id}', [PenitipController::class, 'update'])->name('penitip.update');
    Route::delete('/data-penitip/{id}', [PenitipController::class, 'destroy'])->name('penitip.destroy');
});

Route::prefix('organisasi')->name('organisasi.')->group(function () {
    Route::get('/requestDonasi', [RequestDonasiController::class, 'index'])->name('requestDonasi.index');
    Route::post('/requestDonasi', [RequestDonasiController::class, 'store'])->name('requestDonasi.store');
    Route::get('/request-donasi/{requestDonasi}/edit', [RequestDonasiController::class, 'edit'])->name('requestDonasi.edit');
    Route::put('/request-donasi/{requestDonasi}', [RequestDonasiController::class, 'update'])->name('requestDonasi.update');
    Route::delete('/request-donasi/{requestDonasi}', [RequestDonasiController::class, 'destroy'])->name('requestDonasi.destroy');
});

// -------------------- Pegawai --------------------
Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
Route::post('/pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');
Route::get('/pegawai/{id}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
Route::put('/pegawai/{id}', [PegawaiController::class, 'update'])->name('pegawai.update');
Route::delete('/pegawai/{id}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');

// -------------------- ACC REQUEST DONASI --------------------
Route::post('/donasi', [DonasiController::class, 'store'])->name('donasi.store');

Route::get('/donasi/history', [DonasiController::class, 'historyPage'])->name('donasi.historyPage');
Route::post('/donasi/history', [DonasiController::class, 'historyFiltered'])->name('donasi.historyFiltered');
Route::get('/donasi/{id}/edit', [DonasiController::class, 'edit'])->name('donasi.edit');
Route::put('/donasi/{id}', [DonasiController::class, 'update'])->name('donasi.update');