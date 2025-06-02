<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    // Tampilkan isi keranjang pembeli yang login
    public function index()
    {
        $id_pembeli = Auth::id(); // Asumsi guard pembeli

        $items = Keranjang::with('barang')
            ->where('id_pembeli', $id_pembeli)
            ->get();

        return view('pembeli.Keranjang', compact('items'));
    }

    // Tambah barang ke keranjang
    public function tambah($id_barang)
    {
        $id_pembeli = Auth::id();

        // Cek apakah barang ada
        $barang = Barang::findOrFail($id_barang);

        // Cek apakah barang sudah ada di keranjang pembeli ini
        $exists = Keranjang::where('id_pembeli', $id_pembeli)
            ->where('id_barang', $id_barang)
            ->exists();

        if (!$exists) {
            Keranjang::create([
                'id_pembeli' => $id_pembeli,
                'id_barang' => $id_barang,
            ]);
        }

        return redirect()->route('keranjang.index')->with('success', 'Barang berhasil ditambahkan ke keranjang.');
    }

    // Hapus barang dari keranjang
    public function hapus($id_barang)
    {
        $id_pembeli = Auth::id();

        Keranjang::where('id_pembeli', $id_pembeli)
            ->where('id_barang', $id_barang)
            ->delete();

        return redirect()->route('keranjang.index')->with('success', 'Barang berhasil dihapus dari keranjang.');
    }
}
