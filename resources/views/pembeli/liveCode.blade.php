<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReUseMart - Live Code Pembeli</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #fff;
            color: #000;
        }
        .navbar {
            background-color: #fff;
            border-bottom: 1px solid #ddd;
        }
        .navbar .nav-link {
            color: #000;
            font-weight: 500;
        }
        .navbar .nav-link:hover {
            color: #f44336;
        }
        .footer {
            background-color: #111;
            color: #fff;
            text-align: center;
            padding: 1rem;
            position: fixed;
            bottom: 0;
            width: 100%;
            z-index: 100;
        }
        .container.mt-4 {
            padding-bottom: 80px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">ReUseMart</a>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('dashboard.pembeli') }}" class="btn btn-outline-dark btn-sm">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card shadow-sm rounded">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Transaksi di Atas Rp100.000</h4>
            </div>
            <div class="card-body p-0">
                @if($Transaksis->count() > 0)
                    <table class="table table-striped mb-0">
                        <thead class="table-success">
                            <tr>
                                <th>NO</th>
                                <th>Tanggal Transaksi</th>
                                <th>Status</th>
                                <th>Barang (Nama & Harga)</th>
                                <th>Total Harga</th>
                                <th>Pegawai Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($Transaksis as $index => $transaksi)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d M Y') }}</td>
                                    <td>{{ ucfirst($transaksi->status_transaksi) }}</td>
                                    <td>
                                        <ul class="mb-0">
                                            @foreach($transaksi->transaksiBarang as $transaksiBarang)
                                                <li>
                                                    {{ $transaksiBarang->barang->nama_barang }} - 
                                                    Rp{{ number_format($transaksiBarang->barang->harga_barang, 0, ',', '.') }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                                    <td>
                                        {{ ($transaksi->pegawai && $transaksi->pegawai->nama_pegawai !== 'DUMMY') ? $transaksi->pegawai->nama_pegawai : '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info m-3">
                        Belum ada transaksi di atas Rp100.000.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="footer">
        &copy; 2025 ReUseMart. All rights reserved.
    </div>
</body>
</html>
