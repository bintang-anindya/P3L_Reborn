<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan Per Kategori Barang {{ $selectedYear }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h4, h5 { margin: 0; }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
        }
        td:nth-child(2),
        td:nth-child(3) {
            text-align: center;
        }
        h5 {
            text-decoration: underline;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <h4>ReUseMart</h4>
    <div>Jl. Green Eco Park No. 456 Yogyakarta</div>

    <div style="margin-bottom: 1rem;"></div>

    <h4>Laporan Penjualan Per Kategori Barang</h4>
    <div>Tahun           : {{ $selectedYear }}</div>
    <div>Tanggal Cetak   : {{ $cetakDate ?? \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}</div>

    @if(isset($categorySales) && $categorySales->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th>Jumlah Terjual</th>
                    <th>Jumlah Gagal Terjual</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalTerjual = 0;
                    $totalGagalTerjual = 0;
                @endphp
                @foreach($allCategories as $category)
                    @php
                        $data = $categorySales->firstWhere('id_kategori', $category->id_kategori);
                        $terjual = $data ? $data->total_terjual : 0;
                        $gagalTerjual = $data ? $data->total_gagal_terjual : 0;
                        $totalTerjual += $terjual;
                        $totalGagalTerjual += $gagalTerjual;
                    @endphp
                    <tr>
                        <td>{{ $category->nama_kategori ?? '-' }}</td>
                        <td>{{ $terjual }}</td>
                        <td>{{ $gagalTerjual }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th>{{ $totalTerjual }}</th>
                    <th>{{ $totalGagalTerjual }}</th>
                </tr>
            </tfoot>
        </table>
    @else
        <p>Tidak ada data penjualan per kategori untuk tahun {{ $selectedYear }}.</p>
    @endif
</body>
</html>
