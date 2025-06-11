<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Barang yang Masa Penitipannya Sudah Habis</title>
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
        /* Penyesuaian lebar kolom */
        td:nth-child(1) { width: 10%; text-align: center; } /* Kode Produk */
        td:nth-child(2) { width: 20%; } /* Nama Produk */
        td:nth-child(3) { width: 10%; text-align: center; } /* Id Penitip */
        td:nth-child(4) { width: 20%; } /* Nama Penitip */
        td:nth-child(5) { width: 13%; text-align: center; } /* Tanggal Masuk */
        td:nth-child(6) { width: 13%; text-align: center; } /* Tanggal Akhir */
        td:nth-child(7) { width: 14%; text-align: center; } /* Batas Ambil */
        
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
    </style>
</head>
<body>
    <div class="header-container">
        <div class="company-info">
            <h4>ReUseMart</h4>
            <div>Jl. Green Eco Park No. 456 Yogyakarta</div>
        </div>

        <div style="margin-bottom: 1rem;"></div>

        <h4 class="report-title">LAPORAN BARANG YANG MASA PENITIPANNYA SUDAH HABIS</h4>
        <div>Tanggal Cetak: {{ \Carbon\Carbon::parse($cetakDate)->locale('id')->isoFormat('D MMMM Y') }}</div>
    </div>

    @if(isset($expiredConsignmentList) && $expiredConsignmentList->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th>Id Penitip</th>
                    <th>Nama Penitip</th>
                    <th>Tanggal Masuk</th>
                    <th>Tanggal Akhir</th>
                    <th>Batas Ambil</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expiredConsignmentList as $barang)
                    <tr>
                        <td>{{ $barang->id_barang ?? '-' }}</td>
                        <td>{{ $barang->nama_barang ?? '-' }}</td>
                        <td>{{ $barang->penitipan->penitip->id_penitip ?? '-' }}</td>
                        <td>{{ $barang->penitipan->penitip->nama_penitip ?? '-' }}</td>
                        <td>{{ $barang->tanggal_masuk ? \Carbon\Carbon::parse($barang->tanggal_masuk)->locale('id')->isoFormat('D MMM Y') : '-' }}</td>
                        <td>{{ $barang->penitipan->tenggat_waktu ? \Carbon\Carbon::parse($barang->penitipan->tenggat_waktu)->locale('id')->isoFormat('D MMM Y') : '-' }}</td>
                        <td>{{ $barang->tanggal_ambil ? \Carbon\Carbon::parse($barang->tanggal_ambil)->locale('id')->isoFormat('D MMM Y') : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="no-data">Tidak ada barang yang masa penitipannya sudah habis.</p>
    @endif

    <div class="print-footer">
        Dicetak pada {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y HH:mm:ss') }}
    </div>
</body>
</html>