<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\models\requestDonasi;
use Illuminate\Http\Request;
use App\Models\Transaksi;
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
        $penitipList = \App\Models\Penitip::all();
        return view('owner.penitip', compact('penitipList'));
    }


}