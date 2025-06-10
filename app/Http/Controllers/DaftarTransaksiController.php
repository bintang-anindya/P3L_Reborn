<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Pegawai;
use App\Models\Pengiriman;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DaftarTransaksiController extends Controller
{
    public function index()
    {
        $transactions = Transaksi::with(['transaksiBarang.barang', 'pembeli'])
                        ->where('status_transaksi', 'disiapkan')
                        ->orderBy('tanggal_transaksi', 'desc')
                        ->get();

        // Ambil kurir (pegawai dengan id_role = 4)
        $kurirs = Pegawai::where('id_role', 4)->get();

        return view('gudang.daftarTransaksi', compact('transactions', 'kurirs'));
    }

    public function updateDiambil(Request $request, $id_transaksi)
{
    $request->validate([
        'tanggal_ambil' => 'required|date|after_or_equal:today'
    ]);

    $transaksi = Transaksi::findOrFail($id_transaksi);

    DB::beginTransaction();
    try {
        // Update transaction status
        $transaksi->update([
            'status_transaksi' => 'diambil pembeli',
            'tenggat_waktu' => now()->addDays(2)
        ]);

        // Update pickup date for all items in the transaction
        foreach ($transaksi->transaksiBarang as $transaksiBarang) {
            $transaksiBarang->barang->update([
                'tanggal_ambil' => $request->tanggal_ambil
            ]);
        }

        DB::commit();

        return redirect()->route('gudang.DaftarTransaksi.index')
               ->with('success', 'Status transaksi berhasil diubah dan tanggal pengambilan disimpan');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()
               ->with('error', 'Gagal mengupdate transaksi: ' . $e->getMessage());
    }
}
        public function updateDikirim(Request $request, $id_transaksi)
    {
        $request->validate([
            'tanggal_pengiriman' => 'required|date|after_or_equal:today',
            'id_kurir' => [
                'required',
                'exists:pegawai,id_pegawai,id_role,4'
            ]
        ]);

        DB::beginTransaction();
        try {
            Log::info("Mulai update status transaksi menjadi dikirim untuk ID: {$id_transaksi}");

            // Update status transaksi
            $transaksi = Transaksi::findOrFail($id_transaksi);
            Log::info("Transaksi ditemukan: ", $transaksi->toArray());

            $transaksi->update([
                'status_transaksi' => 'dikirim'
            ]);
            Log::info("Status transaksi berhasil diupdate ke 'dikirim'.");

            // Buat record pengiriman
            $pengiriman = Pengiriman::create([
                'id_transaksi' => $id_transaksi,
                'id_pegawai' => $request->id_kurir,
                'tanggal_pengiriman' => $request->tanggal_pengiriman,
                'status_pengiriman' => 'dalam_perjalanan',
            ]);
            Log::info("Pengiriman berhasil dibuat: ", $pengiriman->toArray());

            DB::commit();

            Log::info("Transaksi dan pengiriman berhasil disimpan.");

            return redirect()->route('gudang.DaftarTransaksi.index')
                ->with('success', 'Transaksi berhasil dikirim dan data pengiriman telah disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Gagal mengupdate transaksi: " . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Gagal mengupdate transaksi: ' . $e->getMessage());
        }
    }
}
