<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pembeli;
use App\Models\Penitip;
use App\Models\Transaksi;
use App\Models\Barang; // Import Barang model if not already

class PembeliController extends Controller
{
    public function profil()
    {
        // Eager load 'transaksi' with nested relationships 'barangs.penitip' and 'pegawai',
        // and also 'alamats' for the main address display.
        // Make sure to load the new rating columns as well.
        $pembeli = Auth::guard('pembeli')->user()->load(['transaksi' => function($query) {
            $query->with(['barangs.penitip', 'pegawai']);
        }, 'alamats']);

        if (!$pembeli) {
            return redirect()->route('login')->withErrors(['message' => 'Anda belum login sebagai pembeli.']);
        }

        return view('pembeli.profil', compact('pembeli'));
    }

    public function submitRating(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:transaksi,id_transaksi',
            'seller_id' => 'required|exists:penitip,id_penitip', // Ensure seller exists
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
            'rating_pembeli_value' => 'nullable|integer|min:1|max:5',
            'is_rated_by_pembeli' => 'nullable|integer|min:1|max:5',
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

        // Update seller's total rating and count
        $penitip->total_rating += $rating;
        $penitip->jumlah_perating += 1; // Assuming 'jumlah_perating' tracks number of ratings
        $penitip->save();

        // Find the transaction and update its rating status
        $transaksi = Transaksi::find($transactionId);
        if ($transaksi) {
            $transaksi->rating_pembeli_value = $rating;
            $transaksi->is_rated_by_pembeli = true;
            // Optionally, you could save the comment here if you add a comment column to `transaksi`
            $transaksi->save();
        } else {
            return back()->with('error', 'Transaksi tidak ditemukan.');
        }

        return redirect()->route('profilPembeli')->with('success', 'Rating Anda berhasil dikirim!');
    }

    public function liveCodePembeli()
    {
        // Ensure to use the correct guard if 'Auth::user()' is not providing the 'pembeli' user
        $pembeli = Auth::guard('pembeli')->user(); // Changed to explicit guard

        // Assuming 'transaksiBarang' is the correct relationship name for barang items in a transaction
        // If it's a direct 'barangs' relationship, adjust accordingly.
        $Transaksis = Transaksi::with(['barangs.penitip']) // Assumed 'barangs' relationship for items and nested 'penitip'
                                ->where('status_transaksi', '=', 'disiapkan')
                                ->where('total_harga', '>', 100000)
                                ->orderBy('tanggal_transaksi', 'desc')
                                ->get();

        return view('pembeli.liveCode', compact('pembeli', 'Transaksis'));
    }

    // The 'klaimMerchandise' method should ideally be defined in your Pembeli model as a relationship
    // For example:
    // in App\Models\Pembeli.php:
    // public function klaimMerchandise()
    // {
    //     return $this->hasMany(PembeliMerchandise::class, 'id_pembeli', 'id_pembeli');
    // }
}
