<?php

// app/Http/Controllers/TransaksiController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\JunctionTransaksiBarang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    /**
     * Proses checkout dari keranjang.
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'poin_tukar' => 'nullable|integer|min:0',
            'metode_pengiriman' => 'required|in:kurir,ambil_sendiri'
        ], [
            'metode_pengiriman.required' => 'Metode pengiriman wajib dipilih.',
            'metode_pengiriman.in' => 'Metode pengiriman tidak valid.'
        ]);

        $pembeli = Auth::guard('pembeli')->user();

        // Hitung total harga dari keranjang
        $items = $pembeli->keranjang()->with('barang')->get();
        if ($items->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }

        $totalHarga = $items->sum(fn($item) => $item->barang->harga_barang);
        $ongkir = ($totalHarga >= 1500000) ? 0 : 100000;
        $poinTukar = min($request->input('poin_tukar', 0), $pembeli->poin_pembeli);
        $faktorDiskon = ($totalHarga > 500000) ? 1.2 : 1;
        $nilaiDiskon = $poinTukar * 10000 * $faktorDiskon;
        $nilaiDiskon = min($nilaiDiskon, $totalHarga + $ongkir);
        $totalPembayaran = $totalHarga + $ongkir - $nilaiDiskon;

        // Buat transaksi
        $transaksi = Transaksi::create([
            'tanggal_transaksi' => Carbon::now(),
            'status_transaksi' => 'Menunggu Pembayaran',
            'total_harga' => $totalPembayaran,
            'id_pembeli' => $pembeli->id_pembeli,
            'id_pegawai' => 0,
            'bukti_transaksi' => null,
            'nomor_transaksi'=> 'kosong',
            'poin_tukar' => $poinTukar,
            'metode' => $request->input('metode_pengiriman') // <- Perbaikan
        ]);

        // Generate nomor transaksi: tahun.bulan.id_transaksi
        $nomorTransaksi = Carbon::now()->format('Y.m') . '.' . $transaksi->id_transaksi;
        $transaksi->nomor_transaksi = $nomorTransaksi;
        $transaksi->save();

        // Tambah barang ke junction table & ubah status barang jadi sold out
        foreach ($items as $item) {
            JunctionTransaksiBarang::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'id_barang' => $item->barang->id_barang
            ]);

            // Update status barang menjadi sold out
            $item->barang->status_barang = 'sold out';
            $item->barang->save();
        }

        // Hapus keranjang
        $pembeli->keranjang()->delete();

        // Kurangi poin pembeli (jika ada)
        if ($poinTukar > 0) {
            $pembeli->poin_pembeli -= $poinTukar;
            $pembeli->save();
        }

        return redirect()->route('transaksi.uploadBukti', $transaksi->id_transaksi);
    }

    /**
     * Tampilkan form upload bukti transaksi.
     */
    public function uploadBuktiForm($id_transaksi)
    {
        $transaksi = Transaksi::findOrFail($id_transaksi);
        return view('transaksi.upload_bukti', compact('transaksi'));
    }

    /**
     * Simpan bukti transaksi.
     */
    public function uploadBukti(Request $request, $id_transaksi)
    {
        $request->validate([
            'bukti_transaksi' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $transaksi = Transaksi::findOrFail($id_transaksi);

        if ($request->hasFile('bukti_transaksi')) {
            $file = $request->file('bukti_transaksi');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destination = public_path('assets/images/bukti_transaksi');
            $file->move($destination, $filename);

            // Simpan file bukti transaksi
            $transaksi->bukti_transaksi = 'assets/images/bukti_transaksi/' . $filename;

            // Ubah status menjadi 'Menunggu Validasi'
            $transaksi->status_transaksi = 'Menunggu Validasi';

            $transaksi->save();
        }

        return redirect()->route('dashboard.pembeli')->with('success', 'Bukti transaksi berhasil diunggah. Silakan tunggu validasi.');
    }


    public function cancelIfExpired($id_transaksi)
    {
        $transaksi = Transaksi::with('junctionTransaksiBarang.barang', 'pembeli')->findOrFail($id_transaksi);
        $transaksi->status_transaksi = 'Batal';
        $transaksi->save;

            $createdAt = Carbon::parse($transaksi->tanggal_transaksi);
            $now = Carbon::now();

                // Batalkan transaksi
                $transaksi->status_transaksi = 'Batal';
                $transaksi->save();

                // Kembalikan poin
                $poinTukar = $transaksi->hitungPoinTukar($transaksi); // Tambahkan helper
                if ($poinTukar > 0) {
                    $pembeli = $transaksi->pembeli;
                    $pembeli->poin_pembeli += $poinTukar;
                    $pembeli->save();
                }

                // Kembalikan status barang
                foreach ($transaksi->junctionTransaksiBarang as $junction) {
                    $barang = $junction->barang;
                    $barang->status_barang = 'tersedia';
                    $barang->save();
                }

                return redirect()->route('dashboard.pembeli')->with('error', 'Transaksi dibatalkan karena melebihi batas waktu.');

        // Jika bukti sudah diunggah atau belum 1 menit
        return redirect()->route('transaksi.uploadBukti', $id_transaksi);
    }

    public function validasi($id_transaksi)
    {
        $transaksi = Transaksi::findOrFail($id_transaksi);

        $transaksi->status_transaksi = 'disiapkan';

        // Ambil id pegawai yang sedang login
        $id_pegawai = auth('pegawai')->user()->id_pegawai; // atau auth('pegawai')->id() jika guard khusus pegawai

        $transaksi->id_pegawai = $id_pegawai;

        $transaksi->save();

        return redirect()->back()->with('success', 'Transaksi berhasil divalidasi.');
    }

    public function cancelByCs($id_transaksi)
    {
        $transaksi = Transaksi::with('TransaksiBarang.barang', 'pembeli')->findOrFail($id_transaksi);
        $transaksi->status_transaksi = 'Batal';
        $id_pegawai = auth('pegawai')->user()->id_pegawai; // atau auth('pegawai')->id() jika guard khusus pegawai

        $transaksi->id_pegawai = $id_pegawai;
        $transaksi->save;

            $createdAt = Carbon::parse($transaksi->tanggal_transaksi);
            $now = Carbon::now();

                // Batalkan transaksi
                $transaksi->status_transaksi = 'Batal';
                $transaksi->save();

                // Kembalikan poin
                $poinTukar = $transaksi->hitungPoinTukar($transaksi); // Tambahkan helper
                if ($poinTukar > 0) {
                    $pembeli = $transaksi->pembeli;
                    $pembeli->poin_pembeli += $poinTukar;
                    $pembeli->save();
                }

                // Kembalikan status barang
                foreach ($transaksi->TransaksiBarang as $junction) {
                    $barang = $junction->barang;
                    $barang->status_barang = 'tersedia';
                    $barang->save();
                }

                return redirect()->route('dashboard.cs');
    }

}
