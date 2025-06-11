<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Donasi Barang</title>
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

    <h5>Laporan Donasi Barang</h5>
    <div>Tahun : {{ $tahun }}</div>
    <div>Tanggal Cetak : {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}</div>

    <table>
        <thead>
            <tr>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Id Penitip</th>
                <th>Nama Penitip</th>
                <th>Tanggal Donasi</th>
                <th>Organisasi</th>
                <th>Nama Penerima</th>
            </tr>
        </thead>
        <tbody>
            @foreach($donasiList as $donasi)
                <tr>
                    <td>{{ $donasi->barang->id_barang ?? '-' }}</td>
                    <td>{{ $donasi->barang->nama_barang ?? '-' }}</td>
                    <td>{{ $donasi->barang->penitipan->id_penitip ?? '-' }}</td>
                    <td>{{ $donasi->barang->penitipan->penitip->nama_penitip ?? '-' }}</td>
                    <td>{{ $donasi->tanggal_donasi ? $donasi->tanggal_donasi->format('d/m/Y') : '-' }}</td>
                    <td>{{ $donasi->request && $donasi->request->organisasi ? $donasi->request->organisasi->nama_organisasi : '-' }}</td>
                    <td>{{ $donasi->nama_penerima ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
