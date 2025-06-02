<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\DonasiController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\PenitipanController;
use App\Http\Controllers\NotaPenitipanController;

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

// --------------- GUDANG ---------------- //
Route::get('/dashboard/gudang', [PenitipanController::class, 'index'])->name('dashboard.gudang');
Route::post('/gudang', [PenitipanController::class, 'store'])->name('penitipan.store');
Route::put('/penitipan/{id}', [PenitipanController::class, 'update'])->name('penitipan.update');
Route::delete('/penitipan/{id}', [PenitipanController::class, 'destroy'])->name('penitipan.destroy');

// --------------- Gambar Tambahan ---------------- //
Route::delete('/gambar/{id}', [GambarBarangController::class, 'destroy'])->name('gambar.destroy');

// --------------- PDF ---------------- //
Route::get('/penitipan/{id}/nota', [NotaPenitipanController::class, 'download'])->name('penitipan.nota');


Route::get('/dashboard/admin', function() {
    return redirect()->route('pegawai.index');
})->name('dashboard.admin');

// Route::get('/dashboard/pembeli', function() {
//     return redirect()->route('barang.index');
// })->name('dashboard.pembeli');

Route::get('/dashboard/kurir', fn () => view('dashboard.kurir'))->name('dashboard.kurir');
Route::get('/dashboard/hunter', fn () => view('dashboard.hunter'))->name('dashboard.hunter');

// Route::get('/dashboard/owner', function() {
//     return view('dashboard.owner');
// })->name('dashboard.owner');
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