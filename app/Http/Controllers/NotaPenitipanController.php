<?php

namespace App\Http\Controllers;

use App\Models\Penitipan;
use App\Models\Barang;
use App\Models\Pegawai;
use Barryvdh\DomPDF\Facade\Pdf;

class NotaPenitipanController extends Controller
{
    public function download($id_penitipan)
    {
        $penitipan = Penitipan::with(['penitip', 'pegawai', 'barang.kategori'])->findOrFail($id_penitipan);
        
        $hunterList = Pegawai::where('id_role', 5)->get();

        $pdf = Pdf::loadView('pdf.nota_penitipan', compact('penitipan', 'hunterList'));
        
        return $pdf->download('nota_penitipan_'.$penitipan->id_penitipan.'.pdf');
    }
}