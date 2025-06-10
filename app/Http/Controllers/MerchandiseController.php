<?php

namespace App\Http\Controllers;

use App\Models\PembeliMerchandise;
use Illuminate\Http\Request;
use Carbon\Carbon; // Untuk memudahkan manipulasi tanggal

class MerchandiseController extends Controller
{
    public function index()
    {
        // Mengambil data klaim merchandise dengan relasi nama pembeli dan nama merchandise
        $klaimMerchandise = PembeliMerchandise::with(['pembeli', 'merchandise'])
            ->orderBy('id_pembeli_merchandise', 'asc') // Urutkan sesuai kebutuhan
            ->get();

        return view('cs.merchandise', compact('klaimMerchandise'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'tanggal_ambil' => 'required|date',
        ]);

        $klaim = PembeliMerchandise::find($id);

        if (!$klaim) {
            return redirect()->back()->with('error', 'Klaim merchandise tidak ditemukan.');
        }

        $klaim->tanggal_ambil_merchandise = $request->input('tanggal_ambil');
        $klaim->status_merchandise = 'diambil'; // Atau status lain yang Anda inginkan
        $klaim->save();

        return redirect()->back()->with('success', 'Tanggal ambil merchandise berhasil diperbarui.');
    }
}