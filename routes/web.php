<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DiskusiController;
use App\Http\Controllers\AlamatController;
use App\Http\Controllers\PenitipController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\RequestDonasiController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\DonasiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\PenitipanController;
use App\Http\Controllers\NotaPenitipanController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PengambilanController;
use App\Http\Controllers\DaftarTransaksiController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\KonfirmasiPengambilanController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\MerchandiseController;

Route::middleware(['web', 'auth:pembeli'])->group(function () {
    Route::get('/alamatManager', [AlamatController::class, 'index'])->name('alamat.manager');
    Route::post('/alamatManager', [AlamatController::class, 'store'])->name('alamat.store');
    Route::put('/alamat/{id}', [AlamatController::class, 'update'])->name('alamat.update');
    Route::delete('/alamat/{id}', [AlamatController::class, 'destroy'])->name('alamat.destroy');
    Route::get('/alamat/cari', [AlamatController::class, 'search'])->name('alamat.search');
    Route::post('/alamat/{id}/set-primary', [AlamatController::class, 'setPrimary'])->name('alamat.setPrimary');
});

// -------------------- PEMBELI --------------------
Route::middleware(['auth:pembeli'])->get('/profil', [PembeliController::class, 'profil'])->name('profilPembeli');
Route::post('/submit-rating', [PembeliController::class, 'submitRating'])->name('submit.rating');
// Profile
Route::get('/profile', [ProfileController::class, 'showProfilePenitip'])->middleware('web', 'auth:penitip')->name('penitip.profil');

// LandingPage
Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('/kategori/{id}', [DashboardController::class, 'tampilkanKategori'])->name('kategori');

// -------------------- BARANG --------------------
Route::get('/barang/{id}', [BarangController::class, 'showDetail'])->name('detailBarang');
Route::get('/pembeli/barang/{id}', [BarangController::class, 'showDetailPembeli'])->name('detailBarangPembeli');
Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');
Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');

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

Route::get('/reset-password', [ChangePasswordController::class, 'showResetForm'])
    ->name('resetPassword')
    ->middleware('signed');


// Organisasi
Route::resource('organisasi', OrganisasiController::class);
Route::get('organisasi/request-donasi', [OrganisasiController::class, 'requestDonasi'])->name('organisasi.requestDonasi.index');
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

Route::get('/dashboard/pembeli', [BarangController::class, 'dashboardPembeli'])->name('dashboard.pembeli');

// --------------- PDF ---------------- //
Route::get('/penitipan/{id}/nota', [NotaPenitipanController::class, 'download'])->name('penitipan.nota');


Route::get('/dashboard/admin', function() {
    return redirect()->route('pegawai.index');
})->name('dashboard.admin');

Route::get('/dashboard/kurir', fn () => view('dashboard.kurir'))->name('dashboard.kurir');
Route::get('/dashboard/hunter', fn () => view('dashboard.hunter'))->name('dashboard.hunter');
Route::get('/dashboard/owner', [PegawaiController::class, 'indexOwner'])->name('dashboard.owner');

// -------------------- donasi --------------- //
Route::get('/owner/donasi', [DonasiController::class, 'index'])->name('donasi.owner');

Route::middleware(['web', 'auth:organisasi'])->group(function () {
    Route::get('/dashboard/organisasi', function () {
        return view('dashboard.organisasi');
    })->name('dashboard.organisasi');
});

Route::get('/dashboard/penitip', [BarangController::class, 'dashboardPenitip'])->name('dashboard.penitip');

// diskusi
Route::get('/diskusi', [DiskusiController::class, 'index'])->name('diskusi.index');
Route::get('/diskusi/{id}', [DiskusiController::class, 'show'])->name('diskusi.show');
Route::post('/diskusi/{id}/balasan', [DiskusiController::class, 'storeBalasan'])->name('diskusi.storeBalasan');

Route::get('/pegawai/reset-password', [UserController::class, 'showResetPasswordPegawai'])->name('pegawai.resetPassword');
Route::post('/pegawai/reset-password/{id}', [UserController::class, 'resetPasswordPegawai'])->name('pegawai.resetPassword.submit');
Route::get('/resetPasswordPegawai', [UserController::class, 'showResetPasswordPegawai'])->name('pegawai.resetPassword');

Route::prefix('cs')->name('cs.')->group(function () {
    Route::get('/dataPenitip', [PenitipController::class, 'index'])->name('penitip.index');
    Route::post('/dataPenitip', [PenitipController::class, 'store'])->name('penitip.store');
    Route::get('/data-penitip/{id}/edit', [PenitipController::class, 'edit'])->name('penitip.edit');
    Route::put('/data-penitip/{id}', [PenitipController::class, 'update'])->name('penitip.update');
    Route::delete('/data-penitip/{id}', [PenitipController::class, 'destroy'])->name('penitip.destroy');
    Route::get('/merchandise', [MerchandiseController::class, 'index'])->name('merchandise.index');
    Route::post('/merchandise/{id}/update', [MerchandiseController::class, 'update'])->name('merchandise.update');
});

// --------------- Live Code ---------------- //
Route::get('/rating-rendah', [PenitipController::class, 'ratingRendah'])->name('penitip.ratingRendah');


// --------------- GUDANG ---------------- //
Route::get('/dashboard/gudang', [PenitipanController::class, 'dashboard'])->name('dashboard.gudang');

Route::prefix('gudang')->name('gudang.')->group(function () {
    Route::get('/inputBarang', [PenitipanController::class, 'index'])->name('inputBarang.index');
    Route::post('/inputBarang', [PenitipanController::class, 'store'])->name('inputBarang.store');
    Route::put('/penitipan/{id}', [PenitipanController::class, 'update'])->name('inputBarang.update');
    Route::delete('/penitipan/{id}', [PenitipanController::class, 'destroy'])->name('inputBarang.destroy');
    Route::get('/daftarTransaksi', [DaftarTransaksiController::class, 'index'])->name('DaftarTransaksi.index');
    Route::post('/daftarTransaksi/{id_transaksi}/diambil', [DaftarTransaksiController::class, 'updateDiambil'])->name('daftarTransaksi.diambil');
    Route::post('/daftarTransaksi/{id_transaksi}/dikirim', [DaftarTransaksiController::class, 'updateDikirim'])->name('daftarTransaksi.dikirim');
    Route::get('/konfirmasi', [KonfirmasiPengambilanController::class, 'index'])->name('konfirmasi.index');
    Route::post('/konfirmasi/{id_transaksi}', [KonfirmasiPengambilanController::class, 'konfirmasi'])->name('konfirmasi.konfirmasi');
    Route::get('/cetak', [PDFController::class, 'index'])->name('cetak.index');
    Route::get('/cetak/pdf/{id_transaksi}', [PDFController::class, 'generatePdf'])->name('cetak.pdf');
});

    // -------------------- Pengambilan -----------------------
Route::prefix('gudang')->group(function() {
    Route::get('/ambilBarang', [PengambilanController::class, 'index']) ->name('gudang.ambilBarang');      
    Route::post('/ambilBarang/{id_barang}/ambil', [PengambilanController::class, 'ambilBarang'])->name('gudang.ambilBarang.ambil');
});

Route::prefix('organisasi')->name('organisasi.')->group(function () {
    Route::get('/requestDonasi', [RequestDonasiController::class, 'index'])->name('requestDonasi.inde   x');
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
Route::get('/owner/request', [DonasiController::class, 'index'])->name('owner.requestPage');
// GET route untuk menampilkan form filter
Route::get('/owner/history', [DonasiController::class, 'historyPage'])->name('owner.historyPage');

// POST route untuk handle filter
Route::post('/owner/history', [DonasiController::class, 'historyFiltered'])->name('owner.historyFiltered');

Route::get('/owner/{id}/edit', [DonasiController::class, 'edit'])->name('owner.edit');
Route::put('/owner/{id}', [DonasiController::class, 'update'])->name('donasi.update');

Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
Route::post('/keranjang/tambah/{id_barang}', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
Route::post('/keranjang/hapus/{id_barang}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');
Route::post('/keranjang/tukar-poin', [KeranjangController::class, 'tukarPoin'])->name('keranjang.tukarPoin');
Route::post('/keranjang/pilihMetodePengiriman', [KeranjangController::class, 'pilihMetodePengiriman'])->name('keranjang.pilihMetodePengiriman');

    // -------------------- Route Transaksi -----------------------
Route::post('/checkout', [TransaksiController::class, 'checkout'])->name('transaksi.checkout');
Route::get('/transaksi/upload-bukti/{id}', [TransaksiController::class, 'uploadBuktiForm'])->name('transaksi.uploadBukti');
Route::post('/transaksi/upload-bukti/{id}', [TransaksiController::class, 'uploadBukti'])->name('transaksi.uploadBukti.store');
Route::get('/transaksi/cancel-if-expired/{id_transaksi}', [TransaksiController::class, 'cancelIfExpired'])->name('transaksi.cancelIfExpired');
Route::get('/transaksi/cancelByCs/{id_transaksi}', [TransaksiController::class, 'cancelByCs'])->name('transaksi.cancelByCs');
Route::get('/transaksi/validasi/{id_transaksi}', [TransaksiController::class, 'validasi'])->name('transaksi.validasi');

Route::get('/dashboard/cs', [DashboardController::class, 'indexCs'])->name('dashboard.cs');

Route::post('/barang/perpanjang/{id_barang}', [BarangController::class, 'perpanjang'])->name('barang.perpanjang');
Route::post('/barang/ambil/{id_barang}', [BarangController::class, 'ambil'])->name('barang.ambil');
// ----------------------- Live Code ------------------------
Route::get('/liveCode', [PembeliController::Class, 'liveCodePembeli'])->name('liveCode.pembeli');

// ----------------------- Laporan --------------------------
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/owner/laporan', [LaporanController::class, 'index'])->name('owner.laporan');
Route::get('/laporan/donasi', [LaporanController::class, 'Donasi'])->name('laporan.donasi');
Route::get('/laporan/donasi/pdf', [LaporanController::class, 'donasiPdf'])->name('laporan.donasi.pdf');
Route::get('/laporan/request-donasi', [LaporanController::class, 'requestDonasi'])->name('laporan.request');
Route::get('/laporan/request-donasi/pdf', [LaporanController::class, 'requestDonasiPdf'])->name('laporan.request.pdf');
Route::get('/laporan/penitip', [LaporanController::class, 'penitip'])->name('laporan.penitip');

// ------------------------- Belum Fix ----------------------
Route::get('laporan/print-penitip/{id}', [LaporanController::class, 'printPenitip'])->name('laporan.printPenitip');
Route::get('/laporan/penitip', [LaporanController::class, 'penitip'])->name('laporan.penitip');
Route::get('/laporan/penitip/cetak', [LaporanController::class, 'printPenitip'])->name('laporan.printPenitip');

Route::get('/laporan/live-code', [LaporanController::class, 'liveCode'])->name('laporan.liveCode');
Route::get('/laporan/live-code/pdf', [LaporanController::class, 'liveCodePdf'])->name('laporan.liveCode.pdf');

