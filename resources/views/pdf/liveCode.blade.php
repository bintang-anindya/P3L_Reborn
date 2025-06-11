<!DOCTYPE html>
<html>
<head>
    <title>Laporan Donasi Barang Kategori 1</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <h2>Laporan Donasi Barang Elektronik - Tahun {{ $tahun }}</h2>
    <table>
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
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
