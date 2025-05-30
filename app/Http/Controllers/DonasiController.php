<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as HttpRequest;
use App\Models\RequestDonasi as RequestModel;
use App\Models\Barang;
use App\Models\Donasi;
use App\Models\Organisasi;
use App\Models\Penitipan;
use Carbon\Carbon;
use Illuminate\Http\Request; 

class DonasiController extends Controller
{

    public function index()
    {
        $requests = RequestModel::with('organisasi')->where('status_donasi', 'menunggu')->get();
        $barangLayak = Barang::layakDidonasikan()->get();

        return view('dashboard.owner', compact('requests', 'barangLayak'));
    }

    public function store(HttpRequest $request)
    {
        $request->validate([
            'id_request' => 'required|exists:request_donasi,id_request',
            'id_barang' => 'required|exists:barang,id_barang',
            'nama_penerima' => 'required|string|max:255',
        ]);

        Donasi::create([
            'id_request' => $request->id_request,
            'id_barang' => $request->id_barang,
            'tanggal_donasi' => Carbon::now(),
            'nama_penerima' => $request->nama_penerima,
            'id_pegawai' => 16,
        ]);

        $requestModel = RequestModel::find($request->id_request);
        $requestModel->status_donasi = 'diterima';
        $requestModel->save();

        $barang = Barang::find($request->id_barang);
        $barang->status_barang = 'didonasikan';
        $barang->save();

        $penitipan = Penitipan::find($barang->id_penitipan);
        if ($penitipan) {
            $penitip = $penitipan->penitip;

            $hargaBarang = $barang->harga_barang;

            $poin = floor($hargaBarang / 10000);
            $penitip->poin_penitip += $poin;
            $penitip->save();
        }

        return redirect()->back()->with('success', 'Donasi berhasil disimpan!');
    }

    public function historyPage()
    {
        $organisasiList = Organisasi::all();
        return view('donasi.historyFilter', compact('organisasiList'));
    }

    public function historyFiltered(Request $request)
    {
        $request->validate([
            'id_organisasi' => 'required|exists:organisasi,id_organisasi',
        ]);

        $organisasi = Organisasi::findOrFail($request->id_organisasi);
        $donasiList = Donasi::with(['barang', 'request'])
            ->whereHas('request', function ($query) use ($request) {
                $query->where('id_organisasi', $request->id_organisasi);
            })
            ->get();

        $organisasiList = Organisasi::all();

        return view('donasi.historyFilter', compact('organisasi', 'donasiList', 'organisasiList'));
    }

    public function edit($id)
    {
        $donasi = Donasi::with('barang')->findOrFail($id);
        return view('donasi.edit', compact('donasi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_penerima' => 'required|string|max:255',
            'status_barang' => 'required|string|max:50',
            'tanggal_donasi' => 'required|date',
        ]);

        $donasi = Donasi::with('barang')->findOrFail($id);
        
        $donasi->nama_penerima = $request->nama_penerima;
        $donasi->tanggal_donasi = $request->tanggal_donasi;
        $donasi->save();

        $donasi->barang->status_barang = $request->status_barang;
        $donasi->barang->save();

        return redirect()->route('donasi.historyFiltered')->with('success', 'Donasi berhasil diperbarui.');
    }
}