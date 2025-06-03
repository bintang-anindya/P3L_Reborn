<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Carbon\Carbon;

class PengambilanController extends Controller
{
    public function index()
    {
        $barang_expired = Barang::with(['penitipan.penitip'])
            ->where('tenggat_waktu', '<=', Carbon::now())
            ->where('status_barang', '!=', 'diambil kembali')
            ->orderBy('tenggat_waktu', 'asc')
            ->get();

        return view('gudang.ambilBarang', compact('barang_expired'));
    }

    public function ambilBarang($id_barang)
    {
        $barang = Barang::findOrFail($id_barang);
        
        $barang->update([
            'status_barang' => 'diambil kembali',
            'tanggal_ambil' => Carbon::now()->addWeek() // 1 minggu dari sekarang
        ]);

        return redirect()->route('gudang.ambilBarang')->with('success', 'Barang berhasil diambil');
    }
}