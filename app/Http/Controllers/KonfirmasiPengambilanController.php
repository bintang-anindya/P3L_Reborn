<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class KonfirmasiPengambilanController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['pembeli', 'barang'])
            ->where('status_transaksi', 'diambil pembeli')
            ->get();

        return view('gudang.konfirmasi', compact('transaksis'));
    }


    public function konfirmasi($id_transaksi)
    {
        $transaksi = Transaksi::findOrFail($id_transaksi);
        $transaksi->status_transaksi = 'transaksi selesai';
        $transaksi->save();

        return redirect()->route('gudang.konfirmasi.index')
                         ->with('success', 'Transaksi Selesai.');
    }
}