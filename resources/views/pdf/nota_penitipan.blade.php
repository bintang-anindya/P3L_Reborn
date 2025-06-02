<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Nota Penitipan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            font-size: 18px;
        }
        .info {
            margin-bottom: 20px;
        }
        .info p {
            margin: 5px 0;
        }
        .barang {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .barang th, .barang td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .barang th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        .signature {
            margin-top: 50px;
            border-top: 1px solid #000;
            width: 200px;
            text-align: center;
            float: right;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>ReUse Mart</h2>
        <p>Jl. Green Eco Park No. 456 Yogyakarta</p>
    </div>

    <div class="info">
        <p><strong>No Nota :</strong> {{ $penitipan->id_penitipan }}</p>
        <p><strong>Tanggal penitipan :</strong> {{ $penitipan->tanggal_masuk->format('d/m/Y H:i:s') }}</p>
        <p><strong>Masa penitipan sampai:</strong> {{ $penitipan->tenggat_waktu->format('d/m/Y') }}</p>
    </div>

    <div class="info">
        <p><strong>Penitip :</strong>T{{$penitipan->id_penitipan}} / {{$penitipan->penitip->nama_penitip }}</p>
        <p><strong>Delivery:</strong> Kurir ReUseMart ({{ $penitipan->pegawai->nama_pegawai }})</p>
    </div>

    <table class="barang">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Garansi</th>
                <th>Berat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penitipan->barang as $barang)
            <tr>
                <td>{{ $barang->nama_barang }}</td>
                <td>Rp{{ number_format($barang->harga_barang, 0, ',', '.') }}</td>
                <td>{{ $barang->tanggal_garansi ? $barang->tanggal_garansi->format('M Y') : '-' }}</td>
                <td>{{ $barang->berat }} kg</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Diterima dan QC oleh:</p>
        <div class="signature">
            <p>P{{$penitipan->pegawai->id_pegawai}} - {{$penitipan->pegawai->nama_pegawai }}</p>
        </div>
    </div>
</body>
</html>