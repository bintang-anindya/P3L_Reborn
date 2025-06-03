<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\Log;

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

    public function dashboardPenitip(Request $request)
    {
        if (!auth('penitip')->check()) {
            return redirect()->route('loginPage')->with('error', 'Anda harus login sebagai penitip');
        }

        $penitip = auth('penitip')->user();
        $search = $request->input('search');

        $barangTitipan = Barang::with(['penitipan', 'kategori'])
            ->whereHas('penitipan', function ($query) use ($penitip) {
                $query->where('id_penitip', $penitip->id_penitip);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_barang', 'like', "%{$search}%")
                        ->orWhere('deskripsi_barang', 'like', "%{$search}%")
                        ->orWhere('harga_barang', 'like', "%{$search}%");
                });
            })
            ->orderBy('tanggal_masuk', 'desc')
            ->get();

        return view('dashboard.penitip', compact('barangTitipan', 'search'));
    }
    
    public function dashboardPembeli()
    {
        // Ambil 10 barang terbaru
        $barangBaru = Barang::orderBy('tanggal_masuk', 'desc')->take(10)->get();

        return view('dashboard.pembeli', compact('barangBaru'));
    } 
}