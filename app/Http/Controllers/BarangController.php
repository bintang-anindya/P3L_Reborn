<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\Log;

class BarangController extends Controller
{
    public function show($id)
    {
        // Load barang dengan relasi yang diperlukan
        $barang = Barang::with([
            'gambarTambahan',
            'penitipan.penitip' => function($query) {
                // Eager load dengan menambahkan data total produk terjual
                $query->withCount([
                    'penitipan as total_produk_terjual' => function($subQuery) {
                        $subQuery->join('barang', 'penitipan.id_penitipan', '=', 'barang.id_penitipan')
                                 ->join('transaksi_barang', 'barang.id_barang', '=', 'transaksi_barang.id_barang');
                    }
                ]);
            }
        ])->findOrFail($id);

        return view('barang.detail', compact('barang'));
    }

    // Method alternatif jika Anda ingin menggunakan raw query untuk performa lebih baik
    public function showAlternative($id)
    {
        $barang = Barang::with([
            'gambarTambahan',
            'penitipan.penitip'
        ])->findOrFail($id);

        // Hitung total produk terjual secara manual jika diperlukan
        if ($barang->penitipan && $barang->penitipan->penitip) {
            $totalProdukTerjual = \DB::table('transaksi_barang')
                ->join('barang', 'transaksi_barang.id_barang', '=', 'barang.id_barang')
                ->join('penitipan', 'barang.id_penitipan', '=', 'penitipan.id_penitipan')
                ->where('penitipan.id_penitip', $barang->penitipan->penitip->id_penitip)
                ->count();
            
            // Attach data ke object penitip
            $barang->penitipan->penitip->total_produk_terjual_calculated = $totalProdukTerjual;
        }

        return view('barang.detail', compact('barang'));
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