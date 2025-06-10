<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pembeli;



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
    public function showRiwayat($id)
    {
        $pembeli = Pembeli::with(['alamat', 'transaksis.barangs'])->findOrFail($id);
        return view('pembeli.show', compact('pembeli'));
    }

    public function klaimMerchandise()
    {
        return $this->hasMany(PembeliMerchandise::class, 'id_pembeli', 'id_pembeli');
    }
}
