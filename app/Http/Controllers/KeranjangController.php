<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Barang;
use App\Models\Alamat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KeranjangController extends Controller
{
    // Tampilkan isi keranjang pembeli yang login
    public function index()
    {
        $id_pembeli = Auth::guard('pembeli')->id();
        $pembeli = Auth::guard('pembeli')->user();
        $alamatPembeli = $pembeli->alamats()->get();

        $items = Keranjang::with('barang')
            ->where('id_pembeli', $id_pembeli)
            ->get();
        
        $alamatUtama = $pembeli->alamatUtama;

        return view('pembeli.Keranjang', compact('items', 'pembeli', 'alamatUtama', 'alamatPembeli'));
    }

    // Tambah barang ke keranjang
    public function tambah($id_barang)
    {
        $id_pembeli = Auth::guard('pembeli')->id();

        // Cek apakah barang ada
        $barang = Barang::findOrFail($id_barang);

        // Cek apakah barang sudah ada di keranjang pembeli ini
        $exists = Keranjang::where('id_pembeli', $id_pembeli)
            ->where('id_barang', $id_barang)
            ->exists();

        if (!$exists) {
            Keranjang::create([
                'id_pembeli' => $id_pembeli,
                'id_barang' => $id_barang,
                'tanggal_ditambahkan' => now(),
            ]);
        }

        return redirect()->route('keranjang.index')->with('success', 'Barang berhasil ditambahkan ke keranjang.');
    }

    // Hapus barang dari keranjang
    public function hapus($id_barang)
    {
        $id_pembeli = Auth::guard('pembeli')->id();

        Keranjang::where('id_pembeli', $id_pembeli)
            ->where('id_barang', $id_barang)
            ->delete();

        return redirect()->route('keranjang.index')->with('success', 'Barang berhasil dihapus dari keranjang.');
    }

    public function pilihMetodePengiriman(Request $request)
    {
        $pembeli = Auth::guard('pembeli')->user();
        $id_pembeli = $pembeli->id_pembeli;
        $items = Keranjang::where('id_pembeli', $id_pembeli)->with('barang')->get();

        // Hitung total harga keranjang
        $totalHarga = 0;
        foreach ($items as $item) {
            if ($item->barang) {
                $totalHarga += $item->barang->harga_barang;
            }
        }

        // Validasi input metode pengiriman
        $validator = Validator::make($request->all(), [
            'metode_pengiriman' => 'required|in:kurir,ambil_sendiri',
        ], [
            'metode_pengiriman.required' => 'Metode pengiriman wajib dipilih.',
            'metode_pengiriman.in' => 'Metode pengiriman tidak valid.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('keranjang.index')
                ->withErrors($validator)
                ->withInput()
                ->with('error_metode_pengiriman', 'Harap pilih metode pengiriman yang valid.');
        }

        $ongkir = 0;
        if ($request->metode_pengiriman === 'kurir') {
            // Cek alamat utama pembeli
            $alamatUtama = $pembeli->alamatUtama;
            if (!$alamatUtama || stripos($alamatUtama->detail, 'yogyakarta') === false) {
                return redirect()->route('keranjang.index')
                    ->with('error_metode_pengiriman', 'Alamat utama Anda bukan di Yogyakarta. Silakan perbarui alamat utama.');
            }

            $ongkir = ($totalHarga < 1500000) ? 100000 : 0;

            // Simpan alamat utama sebagai alamat pengiriman
            session()->put('alamat_pengiriman', $alamatUtama->id_alamat);
        } else {
            // Ambil sendiri, ongkir 0
            $ongkir = 0;
            session()->forget('alamat_pengiriman');
        }

        // Simpan metode dan ongkir ke session
        session()->put([
            'metode_pengiriman' => $request->metode_pengiriman,
            'ongkir' => $ongkir,
        ]);

        return redirect()->route('keranjang.index')->with('success', 'Metode pengiriman berhasil dipilih.');
    }

}
