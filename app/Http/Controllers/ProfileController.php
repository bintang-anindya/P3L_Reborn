<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Penitip;
use App\Models\Pegawai;
use App\Models\Penitipan;
use App\Models\Barang;

class ProfileController extends Controller
{
    public function showProfilePenitip()
    {
        $guard = session('guard');

        if ($guard == 'penitip') {
            $user = Auth::guard('penitip')->user();
            $penitip = $user;

            // Ambil semua transaksi penitipan dari penitip ini
            $riwayatTransaksi = $penitip->penitipan()->get();

            // Ambil semua barang yang dititipkan oleh penitip ini
            $barangTitipan = Barang::where('id_penitipan', $penitip->id_penitip)->get();

            return view('penitip.profil', compact(
                'user',
                'penitip',
                'riwayatTransaksi',
                'barangTitipan'
            ));

        } elseif ($guard == 'pegawai') {
            $user = Auth::guard('pegawai')->user();
            $pegawai = $user;

            return view('penitip.profil', compact('user', 'pegawai'));
        }

        return redirect()->route('login')->withErrors(['error' => 'Tidak ada guard yang aktif']);
    }
}