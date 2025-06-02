<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriBarang;

class KategoriBarangController extends Controller
{
    public function index()
    {
        return response()->json(KategoriBarang::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi_kategori' => 'nullable|string'
        ]);

        $kategori = KategoriBarang::create($validated);

        return response()->json($kategori, 201);
    }

    public function show($id)
    {
        return response()->json(KategoriBarang::findOrFail($id));
    }
}