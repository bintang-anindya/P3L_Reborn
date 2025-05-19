<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\KategoriBarang;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil barang baru
        $barangBaru = $this->getBarangBaru();

        return view('Dashboard', compact('barangBaru'));
    }

    public function tampilkanKategori($id)
    {
        // Ambil kategori berdasarkan id
        $kategori = KategoriBarang::findOrFail($id);

        // Ambil barang berdasarkan kategori yang dipilih
        $barang = Barang::where('id_kategori', $id)->where('status_barang', 'tersedia')->get();

        // Ambil barang baru
        $barangBaru = $this->getBarangBaru();

        // Kirimkan kategori, barang, dan barang baru ke view
        return view('landingPage', compact('kategori', 'barang', 'barangBaru'));
    }


    public function getBarangBaru()
    {
        return Barang::where('status_barang', 'tersedia')
                        ->orderBy('tanggal_masuk', 'desc')
                        ->take(10)
                        ->get();
    }
}