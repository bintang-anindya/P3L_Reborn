<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        return response()->json($barang);
    }

    public function index2()
    {
        $barang = Barang::all();
        return view('barang.show', compact('barang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'gambar_barang' => 'nullable|string',
            'berat' => 'required|numeric',
            'status_barang' => 'required|string',
            'tanggal_garansi' => 'nullable|date',
            'deskripsi_barang' => 'nullable|string',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'nullable|date',
            'tenggat_waktu' => 'nullable|date',
            'harga_barang' => 'required|numeric',
            'id_kategori' => 'required|integer',
            'id_penitipan' => 'required|integer',
        ]);

        $barang = Barang::create($validated);

        return response()->json($barang, 201);
    }

    public function show($id)
    {
        $barang = Barang::findOrFail($id);
        return response()->json($barang);
    }

    public function showDetail($id)
    {
        $barang = Barang::findOrFail($id);
        return view('detail', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $barang->update($request->all());

        return response()->json($barang);
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return response()->json(['message' => 'Barang deleted']);
    }

    public function dashboardPenitip()
    {
        // Ambil 10 barang terbaru
        $barangBaru = Barang::latest()->take(10)->get();

        return view('dashboard.penitip', compact('barangBaru'));
    }   

}