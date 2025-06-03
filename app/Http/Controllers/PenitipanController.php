<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\KategoriBarang;
use App\Models\Penitipan;
use App\Models\Penitip;
use App\Models\Barang;
use App\Models\GambarBarang;
use App\Models\Pegawai;
use Carbon\Carbon;

class PenitipanController extends Controller
{
    public function dashboard()
    {
        return view('dashboard.gudang');
    }

    public function index(Request $request) // Add Request $request parameter here
    {
        $kategoriList = KategoriBarang::all();
        
        $search = $request->input('search');

        $barangList = Barang::with(['penitipan.penitip', 'penitipan.pegawai', 'kategori'])
            ->when($search, function($query) use ($search) {
                return $query->where(function($q) use ($search) {
                    $q->where('nama_barang', 'like', "%{$search}%")
                    ->orWhere('deskripsi_barang', 'like', "%{$search}%")
                    ->orWhere('harga_barang', 'like', "%{$search}%")
                    ->orWhereHas('penitipan', function($q) use ($search) {
                        $q->where('pesan', 'like', "%{$search}%")
                            ->orWhere('id_penitipan', 'like', "%{$search}%")
                            ->orWhereHas('penitip', function($q) use ($search) {
                                $q->where('nama_penitip', 'like', "%{$search}%");
                            })
                            ->orWhereHas('pegawai', function($q) use ($search) {
                                $q->where('nama_pegawai', 'like', "%{$search}%");
                            });
                    })
                    ->orWhereHas('kategori', function($q) use ($search) {
                        $q->where('nama_kategori', 'like', "%{$search}%");
                    });
                });
            })
            ->orderBy('tanggal_masuk', 'desc')
            ->paginate(10); 

        $penitipList = Penitip::all();
        $pegawais = Pegawai::all();

        return view('gudang.inputBarang', compact('kategoriList', 'barangList', 'penitipList', 'pegawais'));
    }

    public function store(Request $request)
    {
        Log::info('Memulai proses penyimpanan penitipan.', ['request' => $request->all()]);

        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'pesan' => 'required|string',
            'berat' => 'required|numeric|min:0',
            'deskripsi_barang' => 'required|string',
            'harga_barang' => 'required|numeric|min:0',
            'id_kategori' => 'required|exists:kategori_barang,id_kategori',
            'tanggal_masuk' => 'required|date',
            'tanggal_garansi' => 'nullable|date',
            'gambar_barang' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'id_penitip' => 'required|exists:penitip,id_penitip',
            'gambar_tambahan.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            // Convert tanggal_masuk to Carbon object
            $tanggalMasuk = Carbon::parse($request->tanggal_masuk);
            $tenggatWaktu = $tanggalMasuk->copy()->addDays(30);

            $penitipan = Penitipan::create([
                'pesan' => $request->pesan,
                'id_pegawai' => $request->id_pegawai,
                'id_penitip' => $request->id_penitip,
                'tanggal_masuk' => $tanggalMasuk, // Store as Carbon object
                'tenggat_waktu' => $tenggatWaktu, // Store as Carbon object
            ]);

            Log::info('Penitipan berhasil dibuat.', ['penitipan' => $penitipan]);

            // Upload gambar
            $path = $request->file('gambar_barang')->store('barang', 'public');
            Log::info('Gambar berhasil diunggah.', ['path' => $path]);

            // Simpan barang
            $barang = Barang::create([
                'nama_barang' => $request->nama_barang,
                'berat' => $request->berat,
                'status_barang' => 'tersedia',
                'tanggal_garansi' => $request->tanggal_garansi ? Carbon::parse($request->tanggal_garansi) : null,
                'deskripsi_barang' => $request->deskripsi_barang,
                'tanggal_masuk' => $tanggalMasuk, // Store as Carbon object
                'harga_barang' => $request->harga_barang,
                'tenggat_waktu' => $tenggatWaktu, // Store as Carbon object
                'id_penitipan' => $penitipan->id_penitipan,
                'gambar_barang' => $path,
                'id_kategori' => $request->id_kategori,
            ]);

            if ($request->hasFile('gambar_tambahan')) {
                foreach ($request->file('gambar_tambahan') as $gambar) {
                    $pathTambahan = $gambar->store('barang/tambahan', 'public');
                    GambarBarang::create([
                        'path_gambar' => $pathTambahan,
                        'id_barang' => $barang->id_barang
                    ]);
                }
            }

            Log::info('Barang berhasil disimpan.', ['barang' => $barang]);

            return redirect()->route('gudang.inputBarang.index')->with('success', 'Transaksi berhasil disimpan.');
        } catch (\Exception $e) {
            Log::error('Terjadi kesalahan saat menyimpan data penitipan.', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function edit($id)
    {
        $penitipan = Penitipan::findOrFail($id);
        $pegawais = Pegawai::all(); // Fixed variable name
        $penitipList = Penitip::all(); // Fixed variable name
        return view('penitipan.edit', compact('penitipan', 'pegawais', 'penitipList'));
    }

    public function update(Request $request, $id_penitipan)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'pesan' => 'required|string',
            'berat' => 'required|numeric|min:0',
            'deskripsi_barang' => 'required|string',
            'harga_barang' => 'required|numeric|min:0',
            'id_kategori' => 'required|exists:kategori_barang,id_kategori',
            'tanggal_masuk' => 'required|date',
            'tanggal_garansi' => 'nullable|date',
            'id_penitip' => 'required|exists:penitip,id_penitip',
            'id_pegawai' => 'required|exists:pegawai,id_pegawai',
            'gambar_tambahan.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $tanggalMasuk = Carbon::parse($request->tanggal_masuk);
            $tenggatWaktu = $tanggalMasuk->copy()->addDays(30);

            // Update data penitipan
            $penitipan = Penitipan::findOrFail($id_penitipan);
            $penitipan->update([
                'pesan' => $request->pesan,
                'id_pegawai' => $request->id_pegawai,
                'id_penitip' => $request->id_penitip,
                'tanggal_masuk' => $tanggalMasuk,
                'tenggat_waktu' => $tenggatWaktu,
            ]);

            // Update data barang yang terkait
            $barang = Barang::where('id_penitipan', $id_penitipan)->firstOrFail();
            $barang->update([
                'nama_barang' => $request->nama_barang,
                'berat' => $request->berat,
                'deskripsi_barang' => $request->deskripsi_barang,
                'harga_barang' => $request->harga_barang,
                'id_kategori' => $request->id_kategori,
                'tanggal_garansi' => $request->tanggal_garansi ? Carbon::parse($request->tanggal_garansi) : null,
                'tanggal_masuk' => $tanggalMasuk,
                'tenggat_waktu' => $tenggatWaktu,
            ]);

            // Handle gambar jika diupdate
            if ($request->hasFile('gambar_barang')) {
                if ($barang->gambar_barang && Storage::exists('public/' . $barang->gambar_barang)) {
                    Storage::delete('public/' . $barang->gambar_barang);
                }
                
                // Simpan gambar baru
                $path = $request->file('gambar_barang')->store('barang', 'public');
                $barang->update(['gambar_barang' => $path]);
            }

            if ($request->hasFile('gambar_tambahan')) {
                $existingImages = GambarBarang::where('id_barang', $barang->id_barang)->get();
            
                foreach ($existingImages as $image) {
                    // Hapus file dari storage
                    if (Storage::exists('public/' . $image->path_gambar)) {
                        Storage::delete('public/' . $image->path_gambar);
                    }
                    // Hapus record dari database
                    $image->delete();
                }
                
                foreach ($request->file('gambar_tambahan') as $gambar) {
                    $pathTambahan = $gambar->store('barang/tambahan', 'public');
                    GambarBarang::create([
                        'path_gambar' => $pathTambahan,
                        'id_barang' => $barang->id_barang
                    ]);
                }
            }

            return redirect()->route('gudang.inputBarang')
                ->with('success', 'Data berhasil diperbarui.')
                ->with('updated_id', $id_penitipan);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating data:', ['error' => $e->getMessage()]);
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $penitipan = Penitipan::findOrFail($id);
        $penitipan->delete();

        $barang = Barang::where('id_penitipan', $id_penitipan)->firstOrFail();
        Storage::delete('public/' . $barang->gambar_barang);

        return redirect()->route('gudang.inputBarang')->with('success', 'Data berhasil dihapus.');
    }
}