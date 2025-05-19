<?php

namespace App\Http\Controllers;

use App\Models\RequestDonasi;
use Illuminate\Http\Request;

class RequestDonasiController extends Controller
{
    // Menampilkan halaman utama dan list request donasi
    public function index(Request $request)
    {
        $organisasiId = session('organisasi_id');
        if (!$organisasiId) {
            return redirect()->route('login')->with('error', 'Anda harus login sebagai organisasi.');
        }

        $query = RequestDonasi::where('id_organisasi', $organisasiId);

        if ($request->has('search')) {
            $query->where('keterangan_request', 'like', '%' . $request->search . '%');
        }

        $requests = $query->paginate(10);

        return view('organisasi.requestDonasi', compact('requests'));
    }

    // Menyimpan request donasi baru
    public function store(Request $request)
    {
        // Validasi inputan
        $request->validate([
            'keterangan_request' => 'required|string|max:255',
        ]);

        // Menyimpan data request donasi
        RequestDonasi::create([
            'keterangan_request' => $request->keterangan_request,
            'id_organisasi' => session('organisasi_id'),  // Mengambil ID organisasi dari session
            'status_donasi' => 'menunggu',
        ]);

        return redirect()->route('organisasi.requestDonasi.index')->with('success', 'Request Donasi berhasil dikirim!');
    }

    // Menampilkan form edit request donasi
    public function edit($id)
    {
        $organisasiId = session('organisasi_id');
        $requestDonasi = RequestDonasi::findOrFail($id);

        // Pastikan request donasi milik organisasi yang login
        if ($requestDonasi->id_organisasi !== $organisasiId) {
            return redirect()->route('organisasi.requestDonasi.index')->with('error', 'Anda tidak berhak mengedit request donasi ini.');
        }

        return view('organisasi.requestDonasi', [
            'editRequest' => $requestDonasi,
        ]);
    }

    // Mengupdate request donasi
    public function update(Request $request, $id)
    {
        // Validasi inputan untuk keterangan_request
        $request->validate([
            'keterangan_request' => 'required|string|max:255',
        ]);

        // Ambil data request donasi berdasarkan ID
        $requestDonasi = RequestDonasi::findOrFail($id);

        // Pastikan request donasi milik organisasi yang login
        if ($requestDonasi->id_organisasi !== session('organisasi_id')) {
            return redirect()->route('organisasi.requestDonasi.index')->with('error', 'Anda tidak berhak mengedit request donasi ini.');
        }

        // Mengupdate hanya keterangan_request (status tidak diubah)
        $requestDonasi->update([
            'keterangan_request' => $request->keterangan_request,
        ]);

        return redirect()->route('organisasi.requestDonasi.index')->with('success', 'Request Donasi berhasil diperbarui!');
    }

    // Menghapus request donasi
    public function destroy($id)
    {
        // Ambil data request donasi berdasarkan ID
        $requestDonasi = RequestDonasi::findOrFail($id);

        // Pastikan request donasi milik organisasi yang login
        if ($requestDonasi->id_organisasi !== session('organisasi_id')) {
            return redirect()->route('organisasi.requestDonasi.index')->with('error', 'Anda tidak berhak menghapus request donasi ini.');
        }

        // Menghapus data request donasi
        $requestDonasi->delete();

        return redirect()->route('organisasi.requestDonasi.index')->with('success', 'Request Donasi berhasil dihapus!');
    }
}


