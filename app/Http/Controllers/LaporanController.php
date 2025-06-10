<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\models\requestDonasi;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Penitip;
use App\Models\Barang;
use App\Models\Penitipan;
use Barryvdh\DomPDF\Facade\Pdf;


class LaporanController extends Controller
{
    public function Donasi()
    {
        // Mengambil semua donasi lengkap dengan relasi
        $donasiList = Donasi::with(['barang', 'penitip', 'request.organisasi'])->get();

        return view('owner.laporan', compact('donasiList'));
    }

    public function index(Request $request)
    {
        $tab = $request->get('tab', 'donasi');

        $donasiList = Donasi::with(['barang.penitipan.penitip', 'request.organisasi'])->get();
        $requestDonasiList = RequestDonasi::with('organisasi')->get();

        return view('owner.laporan', compact('tab', 'donasiList', 'requestDonasiList'));
    }

    public function donasiPdf()
    {
        $donasiList = Donasi::with(['barang', 'penitip', 'request.organisasi'])->get();

        $pdf = Pdf::loadView('pdf.laporan_donasi', compact('donasiList'))
                  ->setPaper('a4', 'portrait');

        return $pdf->download('laporan-donasi-barang-' . date('Ymd') . '.pdf');
    }

    public function requestDonasi()
    {
        // Ambil semua request donasi dengan relasi organisasi
        $requestDonasiList = RequestDonasi::with('organisasi')->get();

        return view('owner.laporan_request', compact('requestDonasiList'));
    }

    public function requestDonasiPdf()
    {
        $requestDonasiList = RequestDonasi::with('organisasi')->get();

        $pdf = Pdf::loadView('pdf.laporan_request', compact('requestDonasiList'))
                    ->setPaper('a4', 'portrait');

        return $pdf->download('laporan-request-donasi-' . date('Ymd') . '.pdf');
    }

    public function penitip()
    {
        $penitipList = Penitip::all();
        return view('owner.penitip', compact('penitipList'));
    }

    public function printPenitip(Request $request, $id)
    {
        // Ambil penitip
        $penitip = Penitip::findOrFail($id);

        // Ambil bulan dan tahun dari request
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        // Validasi
        if (!$bulan || !$tahun) {
            return redirect()->back()->with('error', 'Bulan dan tahun harus dipilih.');
        }

        // Buat batas tanggal akhir (awal bulan berikutnya)
        $batasAkhir = \Carbon\Carbon::create($tahun, $bulan, 1)->addMonth();

        // Ambil penitipan
        $penitipans = Penitipan::where('id_penitip', $id)->get();

        // Ambil id_penitipan dari penitipan
        $penitipanIds = $penitipans->pluck('id_penitipan');

        // Ambil barang yang masuk sebelum batas akhir
        $barangs = Barang::whereIn('id_penitipan', $penitipanIds)
                        ->whereDate('tanggal_masuk', '<', $batasAkhir->toDateString())
                        ->get();

        // Buat PDF
        $pdf = Pdf::loadView('pdf.laporan_penitip', compact('penitip', 'penitipans', 'barangs', 'bulan', 'tahun'))
                    ->setPaper('a4', 'portrait');

        return $pdf->download('laporan-penitip-' . $penitip->nama_penitip . '-' . $bulan . '-' . $tahun . '.pdf');
    }

}