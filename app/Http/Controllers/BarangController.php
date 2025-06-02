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

    public function showDetailPembeli($id)
    {
        $barang = Barang::findOrFail($id);
        return view('pembeli/detail', compact('barang'));
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
    
    public function dashboardPembeli()
    {
        // Ambil 10 barang terbaru
        $barangBaru = Barang::orderBy('tanggal_masuk', 'desc')->take(10)->get();

        return view('dashboard.pembeli', compact('barangBaru'));
    } 
}