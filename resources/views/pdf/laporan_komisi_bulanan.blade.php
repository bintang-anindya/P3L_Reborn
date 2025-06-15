<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Komisi Bulanan {{ $monthName }} {{ $selectedYear }}</title>
    <style>
        body { 
            font-family: sans-serif; 
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        h4, h5 { 
            margin: 0; 
        }
        .header-container {
            margin-bottom: 1rem;
        }
        .company-info h4 {
            font-size: 14px;
            font-weight: bold;
        }
        .report-title {
            text-decoration: underline;
            margin-bottom: 10px;
        }
        .report-period {
            margin-bottom: 5px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
            font-size: 11px;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }
        tfoot th {
            text-align: left;
        }
        /* Penyesuaian lebar kolom */
        td:nth-child(1) { width: 10%; text-align: center; } /* Kode Produk */
        td:nth-child(2) { width: 20%; } /* Nama Produk */
        td:nth-child(3) { width: 12%; text-align: right; } /* Harga Jual */
        td:nth-child(4) { width: 12%; text-align: center; } /* Tanggal Masuk */
        td:nth-child(5) { width: 12%; text-align: center; } /* Tanggal Laku */
        td:nth-child(6) { width: 11%; text-align: right; } /* Komisi Hunter */
        td:nth-child(7) { width: 13%; text-align: right; } /* Komisi ReUse Mart */
        td:nth-child(8) { width: 10%; text-align: right; } /* Bonus Penitip */
        
        .no-data {
            text-align: center;
            margin-top: 20px;
            font-style: italic;
        }
        .print-footer {
            margin-top: 20px;
            font-size: 10px;
            text-align: right;
            color: #555;
        }
        .currency {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header-container">
        <div class="company-info">
            <h4>ReUseMart</h4>
            <div>Jl. Green Eco Park No. 456 Yogyakarta</div>
        </div>

        <div style="margin-bottom: 1rem;"></div>

        <h4 class="report-title">LAPORAN KOMISI BULANAN</h4>
        <div class="report-period">Bulan: {{ \Carbon\Carbon::create()->month((int)$selectedMonth)->locale('id')->isoFormat('MMMM') }}</div>
        <div class="report-period">Tahun: {{ $selectedYear }}</div>
        <div>Tanggal Cetak: {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}</div>
    </div>

    @if(isset($monthlyCommissionList) && $monthlyCommissionList->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th>Harga Jual</th>
                    <th>Tanggal Masuk</th>
                    <th>Tanggal Laku</th>
                    <th>Komisi Hunter</th>
                    <th>Komisi ReUse Mart</th>
                    <th>Bonus Penitip</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalHargaJual = 0;
                    $totalKomisiHunter = 0;
                    $totalKomisiReuseMart = 0;
                    $totalBonusPenitip = 0;
                @endphp
                @foreach($monthlyCommissionList as $item)
                    <tr>
                        <td>{{ $item->barang->id_barang ?? '-' }}</td>
                        <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                        <td class="currency">Rp {{ number_format($item->barang->harga_barang ?? 0, 0, ',', '.') }}</td>
                        <td>{{ $item->barang->tanggal_masuk ? \Carbon\Carbon::parse($item->barang->tanggal_masuk)->locale('id')->isoFormat('D MMM Y') : '-' }}</td>
                        <td>{{ $item->transaksi->tanggal_transaksi ? \Carbon\Carbon::parse($item->transaksi->tanggal_transaksi)->locale('id')->isoFormat('D MMM Y') : '-' }}</td>
                        <td class="currency">Rp {{ number_format($item->barang->komisi_hunter ?? 0, 0, ',', '.') }}</td>
                        <td class="currency">Rp {{ number_format($item->barang->komisi_reusemart ?? 0, 0, ',', '.') }}</td>
                        <td class="currency">Rp {{ number_format($item->barang->bonus_penitip ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    @php
                        $totalHargaJual += $item->barang->harga_barang ?? 0;
                        $totalKomisiHunter += $item->barang->komisi_hunter ?? 0;
                        $totalKomisiReuseMart += $item->barang->komisi_reusemart ?? 0;
                        $totalBonusPenitip += $item->barang->bonus_penitip ?? 0;
                    @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">Total</th>
                    <th class="currency">Rp {{ number_format($totalHargaJual, 0, ',', '.') }}</th>
                    <th colspan="2"></th>
                    <th class="currency">Rp {{ number_format($totalKomisiHunter, 0, ',', '.') }}</th>
                    <th class="currency">Rp {{ number_format($totalKomisiReuseMart, 0, ',', '.') }}</th>
                    <th class="currency">Rp {{ number_format($totalBonusPenitip, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>
    @else
        <p class="no-data">Tidak ada data komisi untuk bulan {{ \Carbon\Carbon::create()->month((int)$selectedMonth)->locale('id')->isoFormat('MMMM') }} tahun {{ $selectedYear }}.</p>
    @endif

    <div class="print-footer">
        Dicetak pada {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y HH:mm:ss') }}
    </div>
</body>
</html>