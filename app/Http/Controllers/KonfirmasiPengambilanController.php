<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Barang; // Import model Barang
use App\Models\Pembeli; // Import model Pembeli
use App\Models\Penitip; // Import model Penitip
use App\Models\Pegawai; // Import model Pegawai (jika hunter adalah pegawai)
use Carbon\Carbon; // Untuk memudahkan manipulasi tanggal
use Illuminate\Support\Facades\Log;

class KonfirmasiPengambilanController extends Controller
{
    public function index()
    {
        // Eager load relasi yang dibutuhkan untuk tampilan
        // Menggunakan transaksiBarangs.barang karena transaksi ke barang via pivot table
        $transaksis = Transaksi::with(['pembeli', 'transaksiBarangs.barang'])
            ->where('status_transaksi', 'diambil pembeli')
            ->get();

        return view('gudang.konfirmasi', compact('transaksis'));
    }

   public function konfirmasi($id_transaksi)
    {
        Log::info("Memulai fungsi konfirmasi untuk Transaksi ID: {$id_transaksi}");

        try {
            // Eager load dengan relasi yang benar
            $transaksi = Transaksi::with([
                'pembeli',
                'transaksiBarangs.barang.penitipan.penitip',
                'transaksiBarangs.barang.penitipan',
                'transaksiBarangs.barang.kategori'
            ])->findOrFail($id_transaksi);

            Log::info("Transaksi ID {$id_transaksi} ditemukan. Status: {$transaksi->status_transaksi}");

            if ($transaksi->status_transaksi === 'transaksi selesai') {
                Log::warning("Transaksi ID {$id_transaksi} sudah berstatus 'transaksi selesai'. Menghentikan proses.");
                return redirect()->back()->with('error', 'Transaksi ini sudah selesai.');
            }

            $penghasilanPenitipPerTransaksi = [];
            $totalKomisiHunterDariTransaksi = 0;

            Log::info("Jumlah transaksiBarangs dalam transaksi {$id_transaksi}: " . $transaksi->transaksiBarangs->count());

            foreach ($transaksi->transaksiBarangs as $index => $transaksiBarang) {
                Log::info("Memproses transaksiBarang ke-{$index} dengan ID: " . ($transaksiBarang->id_transaksiBarang ?? 'Tidak Diketahui'));

                $barang = $transaksiBarang->barang;

                // --- Pengecekan Log Validasi Data Penting ---
                if (!$barang) {
                    Log::error("Validasi GAGAL: Objek Barang null untuk transaksiBarang ID: " . ($transaksiBarang->id_transaksiBarang ?? 'Tidak Diketahui'));
                    continue;
                }
                if (!$barang->penitipan) {
                    Log::error("Validasi GAGAL: Relasi Penitipan null untuk Barang ID: " . ($barang->id_barang ?? 'Tidak Diketahui') . " (dari transaksiBarang ID: " . ($transaksiBarang->id_transaksiBarang ?? 'Tidak Diketahui') . ")");
                    continue;
                }
                if (!$barang->penitipan->penitip) {
                    Log::error("Validasi GAGAL: Relasi Penitip null untuk Penitipan ID: " . ($barang->penitipan->id_penitipan ?? 'Tidak Diketahui') . " (dari Barang ID: " . ($barang->id_barang ?? 'Tidak Diketahui') . ")");
                    continue;
                }
                Log::info("Validasi data LENGKAP untuk Barang ID: " . $barang->id_barang);


                $hargaBarang = $barang->harga_barang;
                $statusPerpanjangan = (bool)$barang->status_perpanjangan;
                $tanggalMasuk = Carbon::parse($barang->tanggal_masuk);
                $tanggalJual = Carbon::parse($transaksi->tanggal_transaksi);

                // --- DEFINISIKAN PERSENTASE KOMISI SEBAGAI KONSTANTA LOKAL ---
                $KOMISI_HUNTER_PERCENT = 5; // 5%
                $KOMISI_REUSEMART_STANDAR_PERCENT = 20; // 20%
                $KOMISI_REUSEMART_PERPANJANGAN_PERCENT = 30; // 30%
                $BONUS_PENITIP_PERCENT_FROM_RM = 10; // 10% dari komisi ReuseMart awal

                Log::debug("Detail Barang ID {$barang->id_barang}: Harga: {$hargaBarang}, Perpanjangan: " . ($statusPerpanjangan ? 'Ya' : 'Tidak') . ", Tanggal Masuk: {$tanggalMasuk->toDateString()}, Tanggal Jual: {$tanggalJual->toDateString()}");

                // 1. Hitung Komisi ReuseMart Awal
                $komisiReuseMartPercentAktual = $statusPerpanjangan ? $KOMISI_REUSEMART_PERPANJANGAN_PERCENT : $KOMISI_REUSEMART_STANDAR_PERCENT;
                $komisiReuseMartInitial = $hargaBarang * ($komisiReuseMartPercentAktual / 100);
                Log::debug("Komisi ReuseMart Aktual %: {$komisiReuseMartPercentAktual}%, Komisi ReuseMart Awal Barang ID {$barang->id_barang}: {$komisiReuseMartInitial}");

                // 2. Hitung Komisi Hunter (jika ada hunter di penitipan)
                $komisiHunter = 0;
                if ($barang->penitipan->id_hunter) {
                    $komisiHunter = $hargaBarang * ($KOMISI_HUNTER_PERCENT / 100);
                    Log::debug("Komisi Hunter untuk Barang ID {$barang->id_barang} (Hunter ID: {$barang->penitipan->id_hunter}): {$komisiHunter}");
                    $totalKomisiHunterDariTransaksi += $komisiHunter;
                } else {
                    Log::debug("Barang ID {$barang->id_barang} tidak memiliki Hunter.");
                }

                // 3. Hitung Bonus Penitip
                $bonusPenitip = 0;
                // Jika terjual kurang dari 7 hari DAN status_perpanjangan adalah FALSE (belum pernah diperpanjang)
                if ($tanggalMasuk->diffInDays($tanggalJual) < 7 && !$statusPerpanjangan) {
                    $bonusPenitip = $komisiReuseMartInitial * ($BONUS_PENITIP_PERCENT_FROM_RM / 100);
                    Log::debug("Bonus Penitip untuk Barang ID {$barang->id_barang}: {$bonusPenitip}");
                } else {
                    Log::debug("Tidak ada Bonus Penitip untuk Barang ID {$barang->id_barang}. Kondisi: Kurang 7 hari: " . ($tanggalMasuk->diffInDays($tanggalJual) < 7 ? 'Ya' : 'Tidak') . ", Status Perpanjangan: " . ($statusPerpanjangan ? 'Ya' : 'Tidak'));
                }

                // 4. Hitung Penghasilan Penitip
                $penghasilanPenitipBarangIni = $hargaBarang - $komisiReuseMartInitial + $bonusPenitip;
                $penitipId = $barang->penitipan->penitip->id_penitip;
                Log::debug("Penghasilan Penitip Barang ID {$barang->id_barang} (Penitip ID: {$penitipId}): {$penghasilanPenitipBarangIni}");

                if (!isset($penghasilanPenitipPerTransaksi[$penitipId])) {
                    $penghasilanPenitipPerTransaksi[$penitipId] = 0;
                }
                $penghasilanPenitipPerTransaksi[$penitipId] += $penghasilanPenitipBarangIni;

                // 5. Hitung Komisi Final ReuseMart (Setelah dikurangi Komisi Hunter dan Bonus Penitip)
                $finalKomisiReuseMart = max(0, $komisiReuseMartInitial - $komisiHunter - $bonusPenitip);
                Log::debug("Komisi Final ReuseMart Barang ID {$barang->id_barang}: {$finalKomisiReuseMart}");

                // --- Pengecekan Log Update Data Barang ---
                $dataToUpdate = [
                    'status_barang' => 'sold out',
                    'tanggal_keluar' => Carbon::now(),
                    'komisi_hunter' => (int)round($komisiHunter),
                    'komisi_reusemart' => (int)round($finalKomisiReuseMart),
                    'bonus_penitip' => (int)round($bonusPenitip)
                ];
                Log::info("Mencoba update Barang ID {$barang->id_barang} dengan data: " . json_encode($dataToUpdate));

                $updated = $barang->update($dataToUpdate);

                if ($updated) {
                    Log::info("BERHASIL update Barang ID {$barang->id_barang}.");
                } else {
                    Log::error("GAGAL update Barang ID {$barang->id_barang}. Pastikan kolom ada di \$fillable model Barang. Data yang dicoba diupdate: " . json_encode($dataToUpdate));
                    Log::error("Fillable properties for Barang model: " . json_encode($barang->getFillable()));
                }
            }

            // Update saldo penitip
            foreach ($penghasilanPenitipPerTransaksi as $penitipId => $earnings) {
                Log::info("Mengupdate saldo Penitip ID {$penitipId} dengan penambahan: {$earnings}");
                $penitipUpdated = Penitip::where('id_penitip', $penitipId)
                                         ->increment('saldo_penitip', $earnings);
                if ($penitipUpdated) {
                    Log::info("BERHASIL update saldo Penitip ID {$penitipId}.");
                } else {
                    Log::error("GAGAL update saldo Penitip ID {$penitipId}.");
                }
            }

            // Catat komisi hunter
            if ($totalKomisiHunterDariTransaksi > 0) {
                Log::info("Total komisi hunter untuk transaksi {$id_transaksi}: Rp" . number_format($totalKomisiHunterDariTransaksi, 0));
            } else {
                Log::info("Tidak ada komisi hunter untuk transaksi {$id_transaksi}.");
            }

            // Update poin pembeli
            $poinDidapat = floor($transaksi->total_harga / 10000);
            Log::info("Mengupdate poin Pembeli ID {$transaksi->pembeli->id_pembeli} dengan penambahan: {$poinDidapat} poin. Total harga transaksi: {$transaksi->total_harga}");
            $pembeliUpdated = $transaksi->pembeli()->increment('poin_pembeli', $poinDidapat);
            if ($pembeliUpdated) {
                Log::info("BERHASIL update poin Pembeli ID {$transaksi->pembeli->id_pembeli}.");
            } else {
                Log::error("GAGAL update poin Pembeli ID {$transaksi->pembeli->id_pembeli}.");
            }

            // Update status transaksi
            Log::info("Mengupdate status Transaksi ID {$id_transaksi} menjadi 'transaksi selesai'.");
            $transaksiUpdated = $transaksi->update(['status_transaksi' => 'transaksi selesai']);
            if ($transaksiUpdated) {
                Log::info("BERHASIL update status Transaksi ID {$id_transaksi}.");
            } else {
                Log::error("GAGAL update status Transaksi ID {$id_transaksi}.");
            }

            Log::info("Fungsi konfirmasi untuk Transaksi ID: {$id_transaksi} SELESAI.");
            return redirect()->route('gudang.konfirmasi.index')->with('success', 'Transaksi berhasil diselesaikan.');

        } catch (\Exception $e) {
            Log::error("Error saat menjalankan fungsi konfirmasi untuk Transaksi ID: " . $id_transaksi);
            Log::error("Pesan Error: " . $e->getMessage());
            Log::error("File: " . $e->getFile() . " pada baris: " . $e->getLine());
            Log::error("Trace: " . $e->getTraceAsString());

            return redirect()->back()->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi. (Detail error telah dicatat).');
        }
    }
}