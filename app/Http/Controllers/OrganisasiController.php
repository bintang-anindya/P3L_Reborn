<?php

namespace App\Http\Controllers;

use App\Models\Organisasi;
use Illuminate\Http\Request;

class OrganisasiController extends Controller
{
    // Tampilkan semua data organisasi
    public function index()
    {
        $organisasis = Organisasi::all();
        return view('organisasi.index', compact('organisasis'));
    }

    // Tampilkan form tambah organisasi
    public function create()
    {
        return view('organisasi.create');
    }

    // Simpan data organisasi baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_organisasi' => 'required',
            'username_organisasi' => 'required|unique:organisasi,username_organisasi',
            'email_organisasi' => 'required|email|unique:organisasi,email_organisasi',
            'password_organisasi' => 'required|min:6',
            'alamat_organisasi' => 'required',
            'no_telp_organisasi' => 'required',
        ]);

        Organisasi::create($request->all());

        return redirect()->route('organisasi.index')->with('success', 'Organisasi berhasil ditambahkan.');
    }

    // Tampilkan detail organisasi
    public function show($id)
    {
        $organisasi = Organisasi::findOrFail($id);
        return view('organisasi.show', compact('organisasi'));
    }

    // Tampilkan form edit organisasi
    public function edit($id)
    {
        $organisasi = Organisasi::findOrFail($id);
        return view('organisasi.edit', compact('organisasi'));
    }

    // Update data organisasi
    public function update(Request $request, $id)
    {
        $organisasi = Organisasi::findOrFail($id);

        $request->validate([
            'nama_organisasi' => 'required',
            'username_organisasi' => 'required|unique:organisasi,username_organisasi,' . $id . ',id_organisasi',
            'email_organisasi' => 'required|email|unique:organisasi,email_organisasi,' . $id . ',id_organisasi',
            'alamat_organisasi' => 'required',
            'no_telp_organisasi' => 'required',
        ]);

        $organisasi->update($request->all());

        return redirect()->route('organisasi.index')->with('success', 'Data organisasi berhasil diperbarui.');
    }

    // Hapus organisasi
    public function destroy(Request $request)
    {
        $request->validate([
            'nama_organisasi' => 'required|string',
        ]);

        $organisasi = Organisasi::where('nama_organisasi', $request->nama_organisasi)->first();

        if ($organisasi) {
            $organisasi->delete();
            return redirect()->route('organisasi.index')->with('success', 'Organisasi berhasil dihapus.');
        }

        return redirect()->route('organisasi.index')->with('error', 'Organisasi tidak ditemukan.');
    }

}
