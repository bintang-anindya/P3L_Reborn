<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alamat;
use App\Models\Pembeli; 

class AlamatController extends Controller
{
    public function index()
    {
        $id_pembeli = session('id_pembeli');
        $pembeli = Pembeli::with('alamat')->findOrFail($id_pembeli);

        $alamats = $pembeli->alamat ? collect([$pembeli->alamat]) : collect([]);

        return view('AlamatManager', compact('pembeli', 'alamats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'detail' => 'required|string|max:255',
        ]);

        $alamat = Alamat::create([
            'detail' => $request->detail
        ]);

        // Update pembeli login agar id_alamat = alamat yg baru dibuat
        $id_pembeli = session('id_pembeli');
        $pembeli = Pembeli::findOrFail($id_pembeli);
        $pembeli->id_alamat = $alamat->id_alamat;
        $pembeli->save();

        return redirect()->back()->with('success', 'Alamat berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'detail' => 'required|string|max:255',
        ]);

        $id_pembeli = session('id_pembeli');
        $pembeli = Pembeli::with('alamat')->findOrFail($id_pembeli);

        if (!$pembeli->alamat || $pembeli->id_alamat != $id) {
            return redirect()->back()->withErrors('Anda tidak memiliki izin untuk mengubah alamat ini.');
        }

        $alamat = Alamat::findOrFail($id);
        $alamat->update([
            'detail' => $request->detail
        ]);

        return redirect()->back()->with('success', 'Alamat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $id_pembeli = session('id_pembeli');
        $pembeli = Pembeli::with('alamat')->findOrFail($id_pembeli);

        if (!$pembeli->alamat || $pembeli->id_alamat != $id) {
            return redirect()->back()->withErrors('Anda tidak memiliki izin untuk menghapus alamat ini.');
        }

        $alamat = Alamat::findOrFail($id);
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
        $pembeli = Pembeli::with('alamat')->findOrFail($id_pembeli);

        $hasil_pencarian = collect([]);

        if ($pembeli->alamat && stripos($pembeli->alamat->detail, $keyword) !== false) {
            $hasil_pencarian->push($pembeli->alamat);
        }

        if ($hasil_pencarian->isEmpty()) {
            return redirect()->route('alamat.manager')->with('not_found', 'Alamat tidak ditemukan.');
        }

        $alamats = $hasil_pencarian; // tampilkan hasil

        return view('alamatManager', compact('pembeli', 'alamats', 'hasil_pencarian'));
    }

}
