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
            @php
                $totalHarga = 0;
                $totalBonus = 0;
                $totalPendapatan = 0;
            @endphp

            @foreach($barangs as $barang)
                @php
                    // Hitung harga jual bersih (setelah potongan 20%)
                    $hargaJualBersih = $barang->harga_barang * 0.8;

                    // Hitung bonus cepat
                    $bonusCepat = 0;
                    if ($barang->tanggal_keluar) {
                        $tanggalMasuk = \Carbon\Carbon::parse($barang->tanggal_masuk);
                        $tanggalKeluar = \Carbon\Carbon::parse($barang->tanggal_keluar);
                        if ($tanggalKeluar->diffInDays($tanggalMasuk) < 7) {
                            $bonusCepat = $barang->harga_barang * 0.02;
                        }
                    }

                    // Hitung pendapatan = harga jual bersih + bonus cepat
                    $pendapatan = $hargaJualBersih + $bonusCepat;

                    // Update total
                    $totalHarga += $hargaJualBersih;
                    $totalBonus += $bonusCepat;
                    $totalPendapatan += $pendapatan;
                @endphp

                <tr>
                    <td>{{ $barang->id_barang }}</td>
                    <td>{{ $barang->nama_barang }}</td>
                    <td>{{ \Carbon\Carbon::parse($barang->tanggal_masuk)->format('d M Y') }}</td>
                    <td>{{ $barang->tanggal_keluar ? \Carbon\Carbon::parse($barang->tanggal_keluar)->format('d M Y') : '-' }}</td>
                    <td>Rp {{ number_format($hargaJualBersih, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($bonusCepat, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($pendapatan, 0, ',', '.') }}</td>
                </tr>
            @endforeach

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
            