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
        // $request->validate([
        //     'tanggal_ambil_merchandise' => 'required|date',
        // ]);

        $klaim = PembeliMerchandise::find($id);

        if (!$klaim) {
            return redirect()->back()->with('error', 'Klaim merchandise tidak ditemukan.');
        }

        try {
            // Recommendation: Use Carbon::parse() to explicitly convert the string to a Carbon instance.
            // This ensures consistent date object handling, especially if your database column is a date/datetime type.
            $klaim->tanggal_ambil_merchandise = Carbon::parse($request->input('tanggal_ambil_merchandise'));
            $klaim->status_merchandise = 'diambil';
            $klaim->save();
            \Log::error("Berhasil updating merchandise claim ID {$id}: " . $e->getMessage());

            // === PERBAIKAN DI SINI ===
            // Mengarahkan ke route 'cs.merchandise.index' agar kembali ke halaman daftar
            return redirect()->route('cs.merchandise.index')->with('success', 'Tanggal ambil merchandise berhasil diperbarui.');
            // =========================

        } catch (\Exception $e) {
            // It's good practice to log unexpected errors for debugging.
            \Log::error("Error updating merchandise claim ID {$id}: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui tanggal pengambilan. Silakan coba lagi.');
        }
    }
}