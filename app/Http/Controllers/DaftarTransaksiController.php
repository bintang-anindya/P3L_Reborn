<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Barang;
use App\Models\TransaksiBarang;

class DaftarTransaksiController extends Controller
{
    public function index()
    {
        // Ambil transaksi dengan status 'sedang disiapkan' beserta item barangnya
        $transactions = Transaksi::with(['transaksiBarang.barang'])
                        ->where('status_transaksi', 'sedang disiapkan')
                        ->orderBy('tanggal_transaksi', 'desc')
                        ->get();

        return view('gudang.daftarTransaksi', compact('transactions'));
    }

    public function updateDiambil($id_transaksi)
    {
        $transaksi = Transaksi::findOrFail($id_transaksi);

        $transaksi->update([
            'status_transaksi' => 'diambil pembeli'
        ]); 

        return redirect()->route('gudang.DaftarTransaksi.index')->with('success', 'Status transaksi berhasil diubah');
    }
}