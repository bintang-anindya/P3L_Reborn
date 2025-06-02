<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alamat;
use App\Models\Pembeli;

class AlamatController extends Controller
{
    public function index()
    {
        $id_pembeli = session('pembeli_id');
        if (!$id_pembeli) {
            return redirect()->route('login')->withErrors('Silakan login terlebih dahulu.');
        }

        $pembeli = Pembeli::with('alamats')->findOrFail($id_pembeli);
        $alamats = $pembeli->alamats;

        return view('alamatManager', compact('pembeli', 'alamats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'detail' => 'required|string|max:255',
        ]);

        $id_pembeli = session('pembeli_id');

        Alamat::create([
            'detail' => $request->detail,
            'id_pembeli' => $id_pembeli,
        ]);

        return back()->with('success', 'Alamat berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'detail' => 'required|string|max:255',
        ]);

        $id_pembeli = session('pembeli_id');
        $alamat = Alamat::where('id_pembeli', $id_pembeli)->where('id_alamat', $id)->firstOrFail();

        $alamat->update([
            'detail' => $request->detail,
        ]);

        return back()->with('success', 'Alamat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $id_pembeli = session('pembeli_id');
        $pembeli = Pembeli::findOrFail($id_pembeli);
        $alamat = Alamat::where('id_pembeli', $id_pembeli)->where('id_alamat', $id)->firstOrFail();

        // Hapus alamat
        $alamat->delete();

        // Jika alamat yang dihapus adalah alamat utama
        if ($pembeli->id_alamat_utama == $id) {
            // Cari alamat lain milik pembeli, kalau ada
            $alamat_lain = Alamat::where('id_pembeli', $id_pembeli)->first();
            if ($alamat_lain) {
                $pembeli->id_alamat_utama = $alamat_lain->id_alamat;
            } else {
                // Kalau tidak ada alamat lain, kosongkan
                $pembeli->id_alamat_utama = null;
            }
            $pembeli->save();
        }

        return back()->with('success', 'Alamat berhasil dihapus.');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $id_pembeli = session('pembeli_id');
        $pembeli = Pembeli::with('alamats')->findOrFail($id_pembeli);

        $hasil_pencarian = $pembeli->alamats->filter(function ($alamat) use ($keyword) {
            return stripos($alamat->detail, $keyword) !== false;
        });

        if ($hasil_pencarian->isEmpty()) {
            return back()->with('not_found', 'Alamat tidak ditemukan.');
        }

        $alamats = $hasil_pencarian;

        return view('alamatManager', compact('pembeli', 'alamats', 'hasil_pencarian'));
    }

    public function setPrimary($id)
    {
        $id_pembeli = session('pembeli_id');
        $pembeli = Pembeli::findOrFail($id_pembeli);

        $alamat = Alamat::where('id_pembeli', $id_pembeli)
            ->where('id_alamat', $id)
            ->firstOrFail();

        $pembeli->id_alamat_utama = $alamat->id_alamat;
        $pembeli->save();

        return back()->with('success', 'Alamat utama berhasil diatur.');
    }
}
