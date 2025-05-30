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

        // Ambil id_pembeli dari session
        $id_pembeli = session('pembeli_id');

        // Buat alamat dengan id_pembeli yang sedang aktif
        $alamat = Alamat::create([
            'detail' => $request->detail,
            'id_pembeli' => $id_pembeli,
        ]);

        return redirect()->back()->with('success', 'Alamat berhasil ditambahkan.');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'detail' => 'required|string|max:255',
        ]);

        $id_pembeli = session('id_pembeli');
        $pembeli = Pembeli::with('alamats')->findOrFail($id_pembeli);

        $alamat = $pembeli->alamats->where('id_alamat', $id)->first();
        if (!$alamat) {
            return redirect()->back()->withErrors('Anda tidak memiliki izin untuk mengubah alamat ini.');
        }

        $alamat->update([
            'detail' => $request->detail,
        ]);
        return redirect()->back()->with('success', 'Alamat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $id_pembeli = session('id_pembeli');
        $pembeli = Pembeli::with('alamats')->findOrFail($id_pembeli);

        $alamat = $pembeli->alamats->where('id_alamat', $id)->first();
        if (!$alamat) {
            return redirect()->back()->withErrors('Anda tidak memiliki izin untuk menghapus alamat ini.');
        }

        $alamat->delete();

        // Kosongkan id_alamat pada pembeli
        $pembeli->id_alamat = null;
        $pembeli->save();

        return redirect()->back()->with('success', 'Alamat berhasil dihapus.');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $id_pembeli = session('id_pembeli');
        $pembeli = Pembeli::with('alamats')->findOrFail($id_pembeli);

        $hasil_pencarian = $pembeli->alamats->filter(function($alamat) use ($keyword) {
            return stripos($alamat->detail, $keyword) !== false;
        });

        if ($hasil_pencarian->isEmpty()) {
            return redirect()->route('alamat.manager')->with('not_found', 'Alamat tidak ditemukan.');
        }

        $alamats = $hasil_pencarian;

        return view('AlamatManager', compact('pembeli', 'alamats', 'hasil_pencarian'));
    }

    public function setPrimary($id)
    {
        $id_pembeli = session('pembeli_id');
        $pembeli = Pembeli::findOrFail($id_pembeli);

        // Pastikan alamat yang dipilih milik user
        $alamat = Alamat::where('id_pembeli', $id_pembeli)
                        ->where('id_alamat', $id)
                        ->firstOrFail();

        $pembeli->id_alamat_utama = $alamat->id_alamat;
        $pembeli->save();

        return redirect()->back()->with('success', 'Alamat utama berhasil diset.');
    }

}
