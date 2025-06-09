<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Request Donasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        h3, h4 {
            margin: 0;
        }
    </style>
</head>
<body>
    <h3>ReUseMart</h3>
    <div>Jl. Green Eco Park No. 456 Yogyakarta</div>    
    <br>
    <h4 style="text-decoration: underline;">Laporan Request Donasi</h4>
    <div>Tahun: {{ date('Y') }}</div>
    <div>Tanggal Cetak: {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}</div>

    <table>
        <thead>
            <tr>
                <th>ID Organisasi</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Request</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requestDonasiList as $request)
                <tr>
                    <td>{{ $request->organisasi->id_organisasi ?? '-' }}</td>
                    <td>{{ $request->organisasi->nama_organisasi ?? '-' }}</td>
                    <td>{{ $request->organisasi->alamat_organisasi ?? '-' }}</td>
                    <td>{{ $request->keterangan_request ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
