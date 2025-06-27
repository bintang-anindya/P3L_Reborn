<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pembeli;
use App\Models\Penitip;
use App\Models\Transaksi;



class PembeliController extends Controller
{
    public function profil()
    {
        $pembeli = Auth::guard('pembeli')->user();

        if (!$pembeli) {
            return redirect()->route('login')->withErrors(['message' => 'Anda belum login sebagai pembeli.']);
        }

        return view('pembeli.profil', compact('pembeli'));
    }

    public function submitRating(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:transaksi,id_transaksi',
            'seller_id' => 'required|exists:penitip,id_penitip',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        $transactionId = $request->input('transaction_id');
        $sellerId = $request->input('seller_id');
        $rating = $request->input('rating');
        $comment = $request->input('comment');

        // Find the seller
        $penitip = Penitip::find($sellerId);

        if (!$penitip) {
            return back()->with('error', 'Penitip tidak ditemukan.');
        }

        $penitip->total_rating += $rating;
        $penitip->jumlah_perating += 1;
        $penitip->save();

        return redirect()->route('profilPembeli')->with('success', 'Rating Anda berhasil dikirim!');
    }

    public function liveCodePembeli()
    {
        $pembeli = Auth::user();
        $Transaksis = Transaksi::with(['transaksiBarang.barang'])
                        ->whereIn('status_transaksi', ['disiapkan', 'Dibatalkan Pembeli'])
                        ->orderBy('tanggal_transaksi', 'desc')
                        ->get();

        return view('pembeli.liveCode', compact('pembeli', 'Transaksis'));
    }

    public function klaimMerchandise()
    {
        return $this->hasMany(PembeliMerchandise::class, 'id_pembeli', 'id_pembeli');
    }

    public function cancelByPembeli($id_transaksi)
    {
        $transaksi = Transaksi::with('TransaksiBarang.barang', 'pembeli')->findOrFail($id_transaksi);

        $transaksi->status_transaksi = 'Dibatalkan Pembeli';
        $transaksi->save();

        $pembeli = $transaksi->pembeli;

        $totalHargaAwal = $transaksi->total_harga + ($transaksi->poin_tukar * 100);

        $ongkir = ($totalHargaAwal >= 1500000) ? 0 : 100000;
        $totalHarga = $totalHargaAwal - $ongkir;

        if ($totalHarga > 500000) {
            $poinReward = floor(($totalHarga / 10000) * 1.2);
        } else {
            $poinReward = floor(($totalHarga / 10000) * 1);
        }

        $pembeli->poin_pembeli -= $poinReward;

        if ($transaksi->poin_tukar > 0) {
            $pembeli->poin_pembeli += $transaksi->poin_tukar;
        }

        if ($pembeli->poin_pembeli < 0) {
            $pembeli->poin_pembeli = 0;
        }

        $pembeli->save();

        foreach ($transaksi->TransaksiBarang as $junction) {
            $barang = $junction->barang;
            $barang->status_barang = 'tersedia';
            $barang->save();
        }

        $pembeli = Auth::user();
        $Transaksis = Transaksi::with(['transaksiBarang.barang'])
                        ->whereIn('status_transaksi', ['disiapkan', 'Dibatalkan Pembeli'])
                        ->orderBy('tanggal_transaksi', 'desc')
                        ->get();

        return view('pembeli.liveCode', compact('pembeli', 'Transaksis'));
    }
}
