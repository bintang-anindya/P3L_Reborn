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
        // Ambil user penitip yang login
        $penitip = auth('penitip')->user();

        // Ambil barang yang dititipkan penitip berdasarkan id_penitip
        $barangTitipan = \App\Models\Barang::where('id_penitip', $penitip->id_penitip)->get();

        // Kirim ke view
        return view('dashboard.penitip', compact('barangTitipan'));
    }

    }
    
    public function dashboardPembeli()
    {
        // Ambil 10 barang terbaru
        $barangBaru = Barang::orderBy('tanggal_masuk', 'desc')->take(10)->get();

        return view('dashboard.pembeli', compact('barangBaru'));
    } 
}