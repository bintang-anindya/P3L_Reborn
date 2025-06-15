<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\Models\RequestDonasi;
use Illuminate\Http\Request;
use App\Models\Transaksi; // Model: Transaksi (singular)
use App\Models\Penitip;
use App\Models\Barang;
use App\Models\Penitipan;
use App\Models\Pegawai; // Pastikan model Pegawai ada dan di-import
use App\Models\Kategori; // Pastikan model Kategori ada dan di-import
use App\Models\TransaksiBarang; // Pastikan model TransaksiBarang ada dan di-import

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log; // Penting untuk debugging

class LaporanController extends Controller
{
    /**
     * Fungsi untuk menampilkan halaman laporan utama dengan tab yang berbeda.
     */
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'penjualan-bulanan'); // Default tab ke 'penjualan-bulanan'
        $selectedYear = $request->get('year', date('Y'));
        $selectedMonth = $request->get('month', date('n')); // 'n' for month without leading zero

        // Inisialisasi semua variabel yang mungkin dibutuhkan oleh view untuk semua tab
        $donasiList = collect();
        $requestDonasiList = collect();
        $monthlySales = collect();
        $chartData = [];
        $stokGudangList = collect();
        $categorySales = collect();
        $allCategories = collect();
        $expiredConsignmentList = collect();
        $monthlyCommissionList = collect();

        Log::info("LaporanController@index: Tab yang diakses: {$tab}");
        Log::info("LaporanController@index: Tahun yang dipilih: {$selectedYear}, Bulan: {$selectedMonth}");

        if ($tab == 'donasi') {
            $donasiList = Donasi::with(['barang.penitipan.penitip', 'request.organisasi'])->get();
            Log::info("LaporanController@index: Memuat data donasi.");
        } elseif ($tab == 'request') {
            $requestDonasiList = RequestDonasi::with('organisasi')->get();
            Log::info("LaporanController@index: Memuat data request donasi.");
        } elseif ($tab == 'penjualan-bulanan') {
            $dataPenjualan = $this->getMonthlySalesData($request);
            $monthlySales = $dataPenjualan['monthlySales'];
            $chartData = $dataPenjualan['chartData'];
            $selectedYear = $dataPenjualan['selectedYear']; // Pastikan selectedYear diperbarui jika ada dari request
            Log::info("LaporanController@index: Memuat data penjualan bulanan.");
        } elseif ($tab == 'stok-gudang') {
            $stokGudangList = $this->getStokGudangData();
            Log::info("LaporanController@index: Memuat data stok gudang.");
        } elseif ($tab == 'penjualan-kategori') {
            $dataKategori = $this->getCategorySalesData($request);
            $categorySales = $dataKategori['categorySales'];
            $allCategories = $dataKategori['allCategories'];
            $selectedYear = $dataKategori['selectedYear']; // Pastikan selectedYear diperbarui jika ada dari request
            Log::info("LaporanController@index: Memuat data penjualan per kategori.");
        } elseif ($tab == 'masa-penitipan-habis') {
            $expiredConsignmentList = $this->getExpiredConsignmentData();
            Log::info("LaporanController@index: Memuat data masa penitipan habis.");
        } elseif ($tab == 'komisi-bulanan') {
            $dataKomisi = $this->getMonthlyCommissionData($request);
            $monthlyCommissionList = $dataKomisi['monthlyCommissionList'];
            $selectedYear = $dataKomisi['selectedYear']; // Pastikan selectedYear diperbarui jika ada dari request
            $selectedMonth = $dataKomisi['selectedMonth']; // Pastikan selectedMonth diperbarui jika ada dari request
            Log::info("LaporanController@index: Memuat data komisi bulanan.");
        } elseif('perpanjangan-per-kategori'){
            $perpanjanganPerKategoriList = Kategori::select('kategori_barang.nama_kategori')
            ->selectRaw('COUNT(barang.id_barang) as total_diperpanjang')
            ->join('barang', 'kategori_barang.id_kategori', '=', 'barang.id_kategori')
            ->where('barang.status_perpanjangan', 1) // Pastikan kolom ini benar
            ->groupBy('kategori_barang.nama_kategori')
            ->get();
        }


        // Anda dapat menambahkan 'else if' untuk tab laporan lainnya di sini

        return view('owner.laporan', compact(
            'tab',
            'donasiList',
            'requestDonasiList',
            'monthlySales',
            'selectedYear',
            'chartData',
            'stokGudangList',
            'categorySales',
            'allCategories',
            'expiredConsignmentList',
            'monthlyCommissionList',
            'selectedMonth'
        ));
    }

    /**
     * Mengambil data untuk laporan penjualan bulanan.
     */
    private function getMonthlySalesData(Request $request)
    {
        $selectedYear = $request->get('year', date('Y'));
        Log::info("getMonthlySalesData: Mengambil data untuk tahun {$selectedYear}");

        $monthlySales = Transaksi::selectRaw('
                MONTH(tanggal_transaksi) as month,
                COUNT(transaksi_barang.id_barang) as total_items_sold,
                SUM(transaksi.total_harga) as total_gross_sales
            ')
            ->join('transaksi_barang', 'transaksi.id_transaksi', '=', 'transaksi_barang.id_transaksi')
            ->whereYear('tanggal_transaksi', $selectedYear)
            ->where('status_transaksi', 'transaksi selesai')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        Log::debug("getMonthlySalesData: Hasil query mentah: " . json_encode($monthlySales));

        $allMonthsData = [];
        for ($i = 1; $i <= 12; $i++) {
            $foundMonth = $monthlySales->firstWhere('month', $i);
            $allMonthsData[] = [
                'month' => $i,
                'total_items_sold' => $foundMonth ? $foundMonth->total_items_sold : 0,
                'total_gross_sales' => $foundMonth ? $foundMonth->total_gross_sales : 0,
            ];
        }
        Log::debug("getMonthlySalesData: Data Chart.js disiapkan: " . json_encode($allMonthsData));

        return [
            'monthlySales' => $monthlySales,
            'chartData' => $allMonthsData,
            'selectedYear' => $selectedYear
        ];
    }

    public function perpanjanganPerKategoriPdf(Request $request)
    {
        $perpanjanganPerKategoriList = Kategori::select('kategori_barang.nama_kategori')
            ->selectRaw('COUNT(barang.id_barang) as total_diperpanjang')
            ->join('barang', 'kategori_barang.id_kategori', '=', 'barang.id_kategori')
            ->where('barang.status_perpanjangan', 1) 
            ->groupBy('kategori_barang.nama_kategori')
            ->get();

        $cetakDate = Carbon::now()->locale('id')->isoFormat('D MMMM Y');

        // Load view PDF dan pass data
        $pdf = Pdf::loadView('laporan_perpanjangan_per_kategori_pdf', compact('perpanjanganPerKategoriList', 'cetakDate'));

        // Opsional: Atur ukuran kertas dan orientasi
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('laporan_perpanjangan_per_kategori_' . Carbon::now()->format('YmdHis') . '.pdf');
    }

    /**
     * Mengambil data untuk laporan stok gudang.
     */
    private function getStokGudangData()
    {
        Log::info("getStokGudangData: Mengambil data stok gudang.");
        $stokGudangList = Barang::with([
            'penitipan.penitip',
            'penitipan.pegawai',
        ])
        ->where('status_barang', '=', 'tersedia')
        ->get();
        Log::debug("getStokGudangData: Jumlah barang tersedia: " . $stokGudangList->count());
        return $stokGudangList;
    }

    /**
     * Mengambil data untuk laporan penjualan per kategori.
     */
    private function getCategorySalesData(Request $request)
    {
        $selectedYear = $request->get('year', date('Y'));
        Log::info("getCategorySalesData: Mengambil data untuk tahun {$selectedYear}");

        $allCategories = Kategori::orderBy('nama_kategori')->get();
        Log::debug("getCategorySalesData: Jumlah kategori ditemukan: " . $allCategories->count());

        // Query untuk item terjual
        $terjualData = Barang::selectRaw('
                id_kategori,
                COUNT(id_barang) as total_terjual
            ')
            ->whereIn('status_barang', ['diperpanjang'])
            ->whereYear('tanggal_keluar', $selectedYear)
            ->groupBy('id_kategori')
            ->get();
        Log::debug("getCategorySalesData: Hasil terjualData: " . json_encode($terjualData));

        // Query untuk item gagal terjual (status_barang "diambil kembali")
        $gagalTerjualData = Barang::selectRaw('
                id_kategori,
                COUNT(id_barang) as total_gagal_terjual
            ')
            ->where('status_barang', 'diambil kembali')
            ->whereYear('tanggal_keluar', $selectedYear)
            ->groupBy('id_kategori')
            ->get();
        Log::debug("getCategorySalesData: Hasil gagalTerjualData: " . json_encode($gagalTerjualData));

        // Gabungkan data
        $categorySales = collect();
        foreach ($allCategories as $category) {
            $terjual = $terjualData->firstWhere('id_kategori', $category->id_kategori);
            $gagalTerjual = $gagalTerjualData->firstWhere('id_kategori', $category->id_kategori);

            $categorySales->push((object)[
                'id_kategori' => $category->id_kategori,
                'nama_kategori' => $category->nama_kategori,
                'total_terjual' => $terjual ? $terjual->total_terjual : 0,
                'total_gagal_terjual' => $gagalTerjual ? $gagalTerjual->total_gagal_terjual : 0,
            ]);
        }
        Log::debug("getCategorySalesData: Category Sales data disiapkan: " . json_encode($categorySales));

        return [
            'categorySales' => $categorySales,
            'allCategories' => $allCategories,
            'selectedYear' => $selectedYear
        ];
    }

    /**
     * Mengambil data untuk laporan barang yang masa penitipannya sudah habis.
     */
    private function getExpiredConsignmentData()
    {
        Log::info("getExpiredConsignmentData: Mengambil data barang masa penitipan habis.");
        $expiredConsignmentList = Barang::with([
            'penitipan.penitip',
        ])
        ->whereHas('penitipan', function($query) {
            $query->whereDate('tenggat_waktu', '<', Carbon::today());
        })
        ->whereNotIn('status_barang', ['terjual', 'donasi', 'diambil kembali'])
        ->get();
        Log::debug("getExpiredConsignmentData: Jumlah barang masa penitipan habis: " . $expiredConsignmentList->count());
        return $expiredConsignmentList;
    }

    /**
     * Mengambil data untuk laporan komisi bulanan per produk.
     */
    private function getMonthlyCommissionData(Request $request)
    {
        $selectedYear = $request->get('year', date('Y'));
        $selectedMonth = $request->get('month', date('n'));
        Log::info("getMonthlyCommissionData: Mengambil data komisi untuk bulan {$selectedMonth} tahun {$selectedYear}");

        $monthlyCommissionList = TransaksiBarang::with([
                'barang.penitipan.penitip',
                'transaksi',
            ])
            ->whereHas('transaksi', function($query) use ($selectedYear, $selectedMonth) {
                $query->whereYear('tanggal_transaksi', $selectedYear)
                      ->whereMonth('tanggal_transaksi', $selectedMonth)
                      ->where('status_transaksi', 'transaksi selesai', 'selesai');
            })
            ->get();
        Log::debug("getMonthlyCommissionData: Jumlah item transaksi komisi: " . $monthlyCommissionList->count());

        return [
            'monthlyCommissionList' => $monthlyCommissionList,
            'selectedYear' => $selectedYear,
            'selectedMonth' => $selectedMonth
        ];
    }

    /**
     * Menampilkan laporan donasi barang (PDF).
     */
    public function donasiPdf()
    {
        Log::info("donasiPdf: Mencetak laporan donasi barang.");
        $donasiList = Donasi::with(['barang.penitipan.penitip', 'request.organisasi'])->get();
        $pdf = Pdf::loadView('pdf.laporan_donasi', compact('donasiList'))
                  ->setPaper('a4', 'portrait');
        return $pdf->download('laporan-donasi-barang-' . date('Ymd') . '.pdf');
    }

    /**
     * Menampilkan halaman request donasi.
     */
    public function requestDonasi()
    {
        Log::info("requestDonasi: Menampilkan halaman request donasi.");
        $requestDonasiList = RequestDonasi::with('organisasi')->get();
        return view('owner.laporan_request', compact('requestDonasiList'));
    }

    /**
     * Menampilkan laporan request donasi (PDF).
     */
    public function requestDonasiPdf()
    {
        Log::info("requestDonasiPdf: Mencetak laporan request donasi.");
        $requestDonasiList = RequestDonasi::with('organisasi')->get();
        $pdf = Pdf::loadView('pdf.laporan_request', compact('requestDonasiList'))
                    ->setPaper('a4', 'portrait');
        return $pdf->download('laporan-request-donasi-' . date('Ymd') . '.pdf');
    }

    /**
     * Menampilkan data penitip.
     */
    public function penitip()
    {
        Log::info("penitip: Menampilkan data penitip.");
        $penitipList = Penitip::all();
        return view('owner.penitip', compact('penitipList'));
    }

    /**
     * Mencetak laporan penitip sampai bulan tertentu (PDF).
     */
    public function printPenitipSampaiBulanTersebut(Request $request, $id)
    {
        Log::info("printPenitipSampaiBulanTersebut: Mencetak laporan penitip ID {$id} sampai bulan tertentu.");
        $penitip = Penitip::findOrFail($id);
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        if (!$bulan || !$tahun) {
            Log::warning("printPenitipSampaiBulanTersebut: Bulan atau tahun tidak dipilih.");
            return redirect()->back()->with('error', 'Bulan dan tahun harus dipilih.');
        }

        $batasAkhir = Carbon::create($tahun, $bulan, 1)->addMonth();

        $penitipans = Penitipan::where('id_penitip', $id)->get();
        $penitipanIds = $penitipans->pluck('id_penitipan');

        $barangs = Barang::whereIn('id_penitipan', $penitipanIds)
                         ->whereDate('tanggal_masuk', '<', $batasAkhir->toDateString())
                         ->get();

        $pdf = Pdf::loadView('pdf.laporan_penitip', compact('penitip', 'penitipans', 'barangs', 'bulan', 'tahun'))
                    ->setPaper('a4', 'portrait');

        return $pdf->download('laporan-penitip-' . $penitip->nama_penitip . '-' . $bulan . '-' . $tahun . '.pdf');
    }

    /**
     * Mencetak laporan penitip untuk bulan tertentu (PDF).
     */
    public function printPenitip(Request $request, $id)
    {
        Log::info("printPenitip: Mencetak laporan penitip ID {$id} untuk bulan tertentu.");
        $penitip = Penitip::findOrFail($id);
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        if (!$bulan || !$tahun) {
            Log::warning("printPenitip: Bulan atau tahun tidak dipilih.");
            return redirect()->back()->with('error', 'Bulan dan tahun harus dipilih.');
        }

        $tanggalAwal = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $tanggalAkhir = Carbon::create($tahun, $bulan, 1)->endOfMonth();

        $penitipans = Penitipan::where('id_penitip', $id)->get();
        $penitipanIds = $penitipans->pluck('id_penitipan');

        $barangs = Barang::whereIn('id_penitipan', $penitipanIds)
                         ->whereBetween('tanggal_masuk', [$tanggalAwal->toDateString(), $tanggalAkhir->toDateString()])
                         ->get();

        $pdf = Pdf::loadView('pdf.laporan_penitip', compact('penitip', 'penitipans', 'barangs', 'bulan', 'tahun'))
                    ->setPaper('a4', 'portrait');

        return $pdf->download('laporan-penitip-' . $penitip->nama_penitip . '-' . $bulan . '-' . $tahun . '.pdf');
    }

    /**
     * Mencetak PDF Laporan Penjualan Bulanan Keseluruhan (dengan grafik).
     * Menerima data gambar grafik via POST.
     */
    public function penjualanBulananPdf(Request $request)
    {
        // Gunakan $request->input() untuk mengambil data dari GET atau POST
        $selectedYear = $request->input('year', date('Y'));
        $chartImage = $request->input('chart_image'); // Menerima data gambar grafik

        Log::info('penjualanBulananPdf: Fungsi dipanggil.');
        Log::info("penjualanBulananPdf: Tahun terpilih: {$selectedYear}");
        Log::info('penjualanBulananPdf: Panjang chart_image yang diterima: ' . ($chartImage ? strlen($chartImage) : 'NULL/KOSONG'));
        if ($chartImage) {
            Log::info('penjualanBulananPdf: Awal chart_image: ' . substr($chartImage, 0, 100) . '...');
        } else {
            Log::warning('penjualanBulananPdf: chart_image kosong atau tidak diterima.');
        }

        // Query untuk data tabel penjualan bulanan
        $monthlySales = Transaksi::selectRaw('
                MONTH(tanggal_transaksi) as month,
                COUNT(transaksi_barang.id_barang) as total_items_sold,
                SUM(transaksi.total_harga) as total_gross_sales
            ')
            ->join('transaksi_barang', 'transaksi.id_transaksi', '=', 'transaksi_barang.id_transaksi')
            ->whereYear('tanggal_transaksi', $selectedYear)
            ->where('status_transaksi', 'transaksi selesai')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        Log::debug("penjualanBulananPdf: Hasil query penjualan mentah: " . json_encode($monthlySales));

        $data = [
            'monthlySales' => $monthlySales,
            'selectedYear' => $selectedYear,
            'monthNames' => [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ],
            'companyName' => 'ReUseMart',
            'companyAddress' => 'Jl. Green Eco Park No. 456 Yogyakarta',
            'cetakDate' => Carbon::now()->locale('id')->isoFormat('D MMMM Y'),
            'chartImage' => $chartImage // Meneruskan data gambar ke view PDF
        ];

        try {
            $pdf = Pdf::loadView('pdf.laporan_penjualan_bulanan', $data);
            Log::info("penjualanBulananPdf: PDF berhasil dimuat dari view.");
            return $pdf->download("laporan_penjualan_bulanan_{$selectedYear}.pdf");
        } catch (\Exception $e) {
            Log::error("penjualanBulananPdf: Error saat membuat PDF: " . $e->getMessage());
            Log::error("penjualanBulananPdf: Stack Trace: " . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Gagal mencetak PDF. Silakan coba lagi. (Detail error telah dicatat).');
        }
    }

    /**
     * Mencetak PDF Laporan Stok Gudang.
     */
    public function stokGudangPdf()
    {
        Log::info("stokGudangPdf: Mencetak laporan stok gudang.");
        $stokGudangList = $this->getStokGudangData();

        $data = [
            'stokGudangList' => $stokGudangList,
            'companyName' => 'ReUseMart',
            'companyAddress' => 'Jl. Green Eco Park No. 456 Yogyakarta',
            'cetakDate' => Carbon::now()->locale('id')->isoFormat('D MMMM Y')
        ];

        $pdf = Pdf::loadView('pdf.laporan_stok_gudang', $data)
                  ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-stok-gudang-' . date('Ymd') . '.pdf');
    }

    /**
     * Mencetak PDF Laporan Penjualan Per Kategori Barang.
     */
    public function penjualanKategoriPdf(Request $request)
    {
        Log::info("penjualanKategoriPdf: Mencetak laporan penjualan per kategori.");
        $dataKategori = $this->getCategorySalesData($request);
        $categorySales = $dataKategori['categorySales'];
        $allCategories = $dataKategori['allCategories'];
        $selectedYear = $dataKategori['selectedYear'];

        $data = [
            'categorySales' => $categorySales,
            'allCategories' => $allCategories,
            'selectedYear' => $selectedYear,
            'companyName' => 'ReUseMart',
            'companyAddress' => 'Jl. Green Eco Park No. 456 Yogyakarta',
            'cetakDate' => Carbon::now()->locale('id')->isoFormat('D MMMM Y')
        ];

        $pdf = Pdf::loadView('pdf.laporan_penjualan_kategori', $data)
                  ->setPaper('a4', 'portrait');

        return $pdf->download("laporan_penjualan_kategori_{$selectedYear}.pdf");
    }

    /**
     * Mencetak PDF Laporan Barang yang Masa Penitipannya Sudah Habis.
     */
    public function masaPenitipanHabisPdf()
    {
        Log::info("masaPenitipanHabisPdf: Mencetak laporan barang masa penitipan habis.");
        $expiredConsignmentList = $this->getExpiredConsignmentData();

        $data = [
            'expiredConsignmentList' => $expiredConsignmentList,
            'companyName' => 'ReUseMart',
            'companyAddress' => 'Jl. Green Eco Park No. 456 Yogyakarta',
            'cetakDate' => Carbon::now()->locale('id')->isoFormat('D MMMM Y')
        ];

        $pdf = Pdf::loadView('pdf.laporan_masa_penitipan_habis', $data)
                  ->setPaper('a4', 'portrait');

        return $pdf->download('laporan-masa-penitipan-habis-' . date('Ymd') . '.pdf');
    }

    /**
     * Mencetak PDF Laporan Komisi Bulanan per Produk.
     */
    public function komisiBulananPdf(Request $request)
    {
        Log::info("komisiBulananPdf: Mencetak laporan komisi bulanan.");
        $dataKomisi = $this->getMonthlyCommissionData($request);
        $monthlyCommissionList = $dataKomisi['monthlyCommissionList'];
        $selectedYear = $dataKomisi['selectedYear'];
        $selectedMonth = $dataKomisi['selectedMonth'];

        $data = [
            'monthlyCommissionList' => $monthlyCommissionList,
            'selectedYear' => $selectedYear,
            'selectedMonth' => $selectedMonth,
            'companyName' => 'ReUseMart',
            'companyAddress' => 'Jl. Green Eco Park No. 456 Yogyakarta',
            'cetakDate' => Carbon::now()->locale('id')->isoFormat('D MMMM Y'),
            'monthName' => Carbon::create(null, $selectedMonth, 1)->locale('id')->isoFormat('MMMM')
        ];

        $pdf = Pdf::loadView('pdf.laporan_komisi_bulanan', $data)
                  ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-komisi-bulanan-' . $selectedYear . '-' . $selectedMonth . '.pdf');
    }
}