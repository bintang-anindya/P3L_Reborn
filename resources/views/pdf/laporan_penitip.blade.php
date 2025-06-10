<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi Penitip</title>
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

    <h4>Laporan Transaksi Penitip</h4>
    <div>ID Penitip     : {{ $penitip->id_penitip }}</div>
    <div>Nama Penitip   : {{ $penitip->nama_penitip }}</div>
    <div>Bulan          : {{ \Carbon\Carbon::create()->month((int)$bulan)->locale('id')->isoFormat('MMMM') }}</div>
    <div>Tahun          : {{ $tahun }}</div>
    <div>Tanggal Cetak  : {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}</div>

    <table>
        <thead>
            <tr>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Laku</th>
                <th>Harga Jual Bersih (Sudah dipotong Komisi)</th>
                <th>Bonus Terjual Cepat</th>
                <th>Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barangs as $barang)
                <tr>
                    <td>{{ $barang->id_barang }}</td>
                    <td>{{ $barang->nama_barang }}</td>
                    <td>{{ \Carbon\Carbon::parse($barang->tanggal_masuk)->format('d M Y') }}</td>
                    <td>{{ $barang->tanggal_keluar ? \Carbon\Carbon::parse($barang->tanggal_keluar)->format('d M Y') : '-' }}</td>
                    <td>Rp {{ number_format($barang->harga_barang, 0, ',', '.') }}</td>
                    <td>-</td>
                    <td>Rp {{ number_format($barang->harga_barang, 0, ',', '.') }}</td>
                </tr>
            @endforeach

            {{-- Tambahkan baris total --}}
            @php
                $totalHarga = $barangs->sum('harga_barang');
                $totalBonus = 0; // kamu bisa hitung jika ada logic bonusnya, untuk sementara diisi 0
                $totalPendapatan = $totalHarga; // asumsi pendapatan = harga_barang total
            @endphp
            <tr>
                <td colspan="4" style="text-align: center; font-weight: bold;">Total</td>
                <td style="font-weight: bold;">Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
                <td style="font-weight: bold;">Rp {{ number_format($totalBonus, 0, ',', '.') }}</td>
                <td style="font-weight: bold;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
            