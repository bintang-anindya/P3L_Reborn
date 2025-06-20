<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    /**
     * Menampilkan daftar transaksi yang siap dicetak
     */
    public function index()
    {
        $transactions = Transaksi::with(['pembeli', 'transaksiBarang.barang', 'kurir'])
            ->whereIn('status_transaksi', ['dikirim', 'transaksi selesai'])
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        return view('gudang.cetak', compact('transactions'));
    }

    /**
     * Generate PDF berdasarkan status transaksi
     */
    public function generatePdf($id_transaksi)
    {
        $transaction = Transaksi::with(['pembeli', 'transaksiBarang.barang', 'kurir'])
            ->findOrFail($id_transaksi);

        // Tentukan view dan nama file berdasarkan status
        if ($transaction->metode === 'kurir') {
            $view = 'pdf.nota_kurir';
            $filename = 'nota_kurir_' . $id_transaksi . '.pdf';
        } else {
            $view = 'pdf.nota_pembeli';
            $filename = 'nota_pembeli_' . $id_transaksi . '.pdf';
        }
        $poin = floor($transaction->jumlah_transaksi / 10000);

        $pdf = PDF::loadView($view,['transaksi' => $transaction ])
                 ->setPaper('a4', 'portrait')
                 ->setOptions([
                     'isHtml5ParserEnabled' => true,
                     'isRemoteEnabled' => true
                 ]);

        return $pdf->download($filename);
    }
}