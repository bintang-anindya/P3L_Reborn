<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alamat;
use App\Models\Pembeli;

class AlamatController extends Controller
{
    public function index()
    {
        $pembelis = Pembeli::with('alamat')->get();
        $alamats = Alamat::all();
        return view('alamatManager', compact('pembelis', 'alamats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'detail' => 'required|string|max:255',
        ]);

        Alamat::create([
            'detail' => $request->detail
        ]);

        return redirect()->back()->with('success', 'Alamat berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'detail' => 'required|string|max:255',
        ]);

        $alamat = Alamat::findOrFail($id);
        $alamat->update([
            'detail' => $request->detail
        ]);

        return redirect()->back()->with('success', 'Alamat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $alamat = Alamat::findOrFail($id);
        $alamat->delete();

        return redirect()->back()->with('success', 'Alamat berhasil dihapus.');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $hasil_pencarian = Alamat::where('detail', 'like', "%{$keyword}%")->get();

        if ($hasil_pencarian->isEmpty()) {
            return redirect()->route('alamat.manager')->with('not_found', 'Alamat tidak ditemukan.');
        }

        $pembelis = Pembeli::with('alamat')->get();
        $alamats = Alamat::all();

        return view('alamatManager', compact('pembelis', 'alamats', 'hasil_pencarian'));
    }

}
