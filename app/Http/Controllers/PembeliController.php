<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pembeli;
use App\Models\Penitip;



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
}
