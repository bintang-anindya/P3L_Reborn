<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Stok Gudang</title>
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
        }
        h5 {
            text-decoration: underline;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <h4>{{ $companyName ?? 'ReUseMart' }}</h4>
    <div>{{ $companyAddress ?? 'Jl. Green Eco Park No. 456 Yogyakarta' }}</div>

    <div style="margin-bottom: 1rem;"></div>

    <h4>Laporan Stok Gudang</h4>
    <div>Tanggal Cetak : {{ $cetakDate ?? \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}</div>

    @if(isset($stokGudangList) && $stokGudangList->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th>ID Penitip</th>
                    <th>Nama Penitip</th>
                    <th>Tanggal Masuk</th>
                    <th>Perpanjangan</th>
                    <th>ID Hunter</th>
                    <th>Nama Hunter</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stokGudangList as $barang)
                    <tr>
                        <td>{{ $barang->id_barang ?? '-' }}</td>
                        <td>{{ $barang->nama_barang ?? '-' }}</td>
                        <td>{{ $barang->penitipan->penitip->id_penitip ?? '-' }}</td>
                        <td>{{ $barang->penitipan->penitip->nama_penitip ?? '-' }}</td>
                        <td>{{ $barang->tanggal_masuk ? \Carbon\Carbon::parse($barang->tanggal_masuk)->format('d M Y') : '-' }}</td>
                        <td>{{ $barang->status_perpanjangan ? 'Ya' : 'Tidak' }}</td>
                        <td>{{ $barang->penitipan->id_hunter ?? '-' }}</td>
                        <td>{{ $barang->penitipan->hunter->nama_pegawai ?? '-' }}</td>
                        <td>Rp {{ number_format($barang->harga_barang ?? 0, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Tidak ada data stok barang di gudang.</p>
    @endif
</body>
</html>
