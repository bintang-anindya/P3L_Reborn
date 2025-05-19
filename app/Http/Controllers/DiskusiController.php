<?php

namespace App\Http\Controllers;

use App\Models\Diskusi;
use App\Models\Barang;
use App\Models\Balasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DiskusiController extends Controller
{
    public function index()
    {
        $idPembeli = Auth::guard('pembeli')->id(); // atau sesuai guard yang kamu pakai

        $diskusi = Diskusi::where('id_pembeli', $idPembeli)
                        ->with('barang')
                        ->get();

        return view('diskusi.index', compact('diskusi'));
    }

    public function show($id)
    {
        $diskusi = Diskusi::with([
            'barang',
            'pembeli',
            'balasan.pegawai',
            'balasan.pembeli',
            'anak.balasan.pegawai',
            'anak.balasan.pembeli',
            'anak.pembeli'
        ])->findOrFail($id);

        return view('diskusi.show', compact('diskusi'));
    }

    public function storeBalasan(Request $request, $id)
    {
        $request->validate([
            'isi_balasan' => 'required|string',
        ]);

        $originalDiskusi = Diskusi::findOrFail($id);

        // CASE 1: Jika pembeli yang login, buat diskusi baru dan pindahkan semua balasan lama
        if (Auth::guard('pembeli')->check()) {
            $pembeliId = Auth::guard('pembeli')->id();

            $newDiskusi = new Diskusi();
            $newDiskusi->id_pembeli = $pembeliId;
            $newDiskusi->id_barang = $originalDiskusi->id_barang;
            $newDiskusi->isi_diskusi = $request->isi_balasan;
            $newDiskusi->tanggal_diskusi = Carbon::now();
            $newDiskusi->id_diskusi_induk = $originalDiskusi->id_diskusi; // ⬅️ Ini penting!
            $newDiskusi->save();

            return redirect()->route('diskusi.show', $originalDiskusi->id_diskusi)
                            ->with('success', 'Diskusi berlanjut ditambahkan.');

        // CASE 2: Jika pegawai CS yang login, balas seperti biasa
        } elseif (Auth::guard('pegawai')->check() && Auth::guard('pegawai')->user()->role === 'cs') {
            $pegawaiId = Auth::guard('pegawai')->id();

            $balasan = new Balasan();
            $balasan->id_diskusi = $id;
            $balasan->id_pegawai = $pegawaiId;
            $balasan->isi_balasan = $request->isi_balasan;
            $balasan->tanggal_balasan = Carbon::now();
            $balasan->save();

            return redirect()->route('diskusi.show', $id)->with('success', 'Balasan berhasil dikirim.');
        }

        return abort(403, 'Akses ditolak.');
    }
}
