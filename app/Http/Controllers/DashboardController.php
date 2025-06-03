<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        $barangBaru = $this->getBarangBaru();

        return view('dashboard', compact('barangBaru'));
    }

    public function tampilkanKategori($id)
    {
        $kategori = KategoriBarang::findOrFail($id);

        $barang = Barang::where('id_kategori', $id)->where('status_barang', 'tersedia')->get();

        $barangBaru = $this->getBarangBaru();

        return view('dashboard', compact('kategori', 'barang', 'barangBaru'));
    }

    public function getBarangBaru()
    {
        return Barang::where('status_barang', 'tersedia')
                        ->orderBy('tanggal_masuk', 'desc')
                        ->take(10)
                        ->get();
    }

    public function indexCs()
    {
        $transaksis = Transaksi::with('pembeli')
            ->where('status_transaksi', 'Menunggu Validasi')
            ->get();

        // ARAHKAN VIEW SESUAI ROUTE
        return view('dashboard.cs', compact('transaksis'));
    }
}