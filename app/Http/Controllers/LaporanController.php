<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade as PDF;


class LaporanController extends Controller
{
    public function Donasi()
    {
        // Mengambil semua donasi lengkap dengan relasi
        $donasiList = Donasi::with(['barang', 'penitip', 'request.organisasi'])->get();

        return view('owner.laporan', compact('donasiList'));
    }

    public function Index()
    {
        return view('owner.laporan');
    }

    public function donasiPdf()
    {
        $donasiList = Donasi::with(['barang', 'penitip', 'request.organisasi'])->get();

        $pdf = PDF::loadView('pdf.laporan_donasi', compact('donasiList'))
                  ->setPaper('a4', 'portrait');

        return $pdf->download('laporan-donasi-barang-' . date('Ymd') . '.pdf');
    }

}