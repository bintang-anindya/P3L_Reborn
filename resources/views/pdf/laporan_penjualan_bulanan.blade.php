<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan Bulanan {{ $selectedYear }}</title>
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
        td:nth-child(1),
        td:nth-child(2) {
            text-align: center;
        }
        td:nth-child(3) {
            text-align: right;
        }
        h5 {
            text-decoration: underline;
            margin-top: 15px;
        }
        .no-data {
            text-align: center;
            margin-top: 20px;
        }
        .chart-container {
            text-align: center;
            margin-top: 30px;
        }
        .chart-container img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <h4>ReUseMart</h4>
    <div>Jl. Green Eco Park No. 456 Yogyakarta</div>

    <div style="margin-bottom: 1rem;"></div>

    <h4>Laporan Penjualan Bulanan</h4>
    <div>Tahun         : {{ $selectedYear }}</div>
    <div>Tanggal Cetak : {{ $cetakDate ?? \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}</div>

    @if(isset($monthlySales) && $monthlySales->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th>Jumlah Barang Terjual</th>
                    <th>Jumlah Penjualan Kotor</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalItemsSold = 0;
                    $totalGrossSales = 0;
                    $monthNames = [
                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                    ];
                @endphp
                @foreach($monthlySales as $data)
                    <tr>
                        <td>{{ $monthNames[$data->month] }}</td>
                        <td>{{ $data->total_items_sold }}</td>
                        <td>Rp{{ number_format($data->total_gross_sales, 0, ',', '.') }}</td>
                    </tr>
                    @php
                        $totalItemsSold += $data->total_items_sold;
                        $totalGrossSales += $data->total_gross_sales;
                    @endphp
                @endforeach
                @for ($i = 1; $i <= 12; $i++)
                    @if (!in_array($i, $monthlySales->pluck('month')->toArray()))
                        <tr>
                            <td>{{ $monthNames[$i] }}</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                    @endif
                @endfor
            </tbody>
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th>{{ $totalItemsSold }}</th>
                    <th>Rp{{ number_format($totalGrossSales, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>

        @if($chartImage)
            <div class="chart-container">
                <img src="{{ $chartImage }}" alt="Grafik Penjualan Bulanan">
            </div>
        @else
            <p class="no-data">Grafik penjualan tidak tersedia.</p>
        @endif
    @else
        <p class="no-data">Tidak ada data penjualan bulanan untuk tahun {{ $selectedYear }}.</p>
    @endif
</body>
</html>
