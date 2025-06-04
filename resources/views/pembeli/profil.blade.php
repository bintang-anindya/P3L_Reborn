<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReUseMart - E-Commerce</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #fff;
            color: #000;
        }
        .topbar {
            background-color: #000;
            color: #fff;
            padding: 5px 15px;
            font-size: 0.875rem;
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
        .hero {
            background: #000;
            color: #fff;
            padding: var(--hero-padding-y, 0rem) var(--hero-padding-x, 2rem);
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-radius: 10px;
        }

        .hero-small {
            --hero-padding-y: 0.5rem;
        }

        .hero-large {
            --hero-padding-y: 3rem;
        }
        .hero img {
            max-width: 400px;
        }
        .hero h1 {
            font-size: 2rem;
            font-weight: bold;
        }
        .sidebar {
            border-right: 1px solid #ddd;
            padding: 1rem;
        }
        .sidebar a {
            display: block;
            padding: 8px 0;
            color: #000;
            text-decoration: none;
        }
        .sidebar a:hover {
            color: #f44336;
        }
        .flash-sale {
            background: #fff;
            padding: 2rem;
        }
        .flash-sale .product-card {
            border: 1px solid #eee;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
        }
        .product-card img {
            width: 100%;
            height: 150px;
            object-fit: contain;
            border-radius: 20px; 
        }
        .product-card .discount {
            background: #f44336;
            color: #fff;
            font-size: 0.8rem;
            padding: 2px 6px;
            border-radius: 5px;
            position: absolute;
            top: 10px;
            left: 10px;
        }
        .product-price {
            color: #f44336;
            font-weight: bold;
        }
        .original-price {
            text-decoration: line-through;
            color: #888;
            font-size: 0.9rem;
        }
        .footer {
            background-color: #111;
            color: #fff;
            text-align: center;
            padding: 1rem;
        }
        .horizontal-scroll-container {
            overflow-x: auto;
            white-space: nowrap;
            padding-bottom: 1rem;
        }

        .horizontal-scroll-container::-webkit-scrollbar {
            height: 10px;
        }

        .horizontal-scroll-container::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 5px;
        }

        .horizontal-scroll-container::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Footer menempel di bawah */
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            z-index: 100;
        }

        /* Agar konten tidak tertutup footer, beri padding bawah pada kontainer */
        .container.mt-4 {
            padding-bottom: 80px; /* Sesuaikan dengan tinggi footer */
        }

        /* Border hitam pada ikon keranjang yang aktif */
        .navbar .fa-shopping-cart.active {
            border: 2px solid #000;
            border-radius: 5px;
            padding: 4px;
        }

    </style>
</head>
<body>
    <div class="topbar text-mid">
        Perbanyak Belanja dan Dapatkan Poin Serta Merchandise Menarik! <a href="#" class="text-white text-decoration-underline">Belanja</a>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">ReUseMart</a>
            <form class="d-flex ms-auto me-3">
                <input class="form-control me-2" type="search" placeholder="Apa yang anda butuhkan?">
            </form>
            <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('diskusi.index') }}" class="btn btn-outline-dark btn-sm">Diskusi</a>
                    <a href="{{ route('alamat.manager') }}" class="btn btn-outline-dark btn-sm">Kelola Alamat</a>
                <a href="{{ route('profilPembeli') }}" class="me-3">
                    <i class="fas fa-user-circle fa-lg"></i>
                </a>
                <a href="#" class="text-dark"><i class="fas fa-heart"></i></a>
                <a href="{{ route('dashboard.pembeli') }}" class="text-dark"><i class="fas fa-shopping-cart active"></i></a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        @if(Auth::check())
            <div class="card shadow-sm rounded">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Profil Pembeli</h4>
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('dashboard.pembeli') }}" class="btn btn-light btn-sm text-primary">← Dashboard</a>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Nama</th>
                            <td>{{ $pembeli->nama_pembeli }}</td>
                        </tr>
                        <tr>
                            <th>Username</th>
                            <td>{{ $pembeli->username_pembeli }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $pembeli->email_pembeli }}</td>
                        </tr>
                        <tr>
                            <th>No Telepon</th>
                            <td>{{ $pembeli->no_telp_pembeli }}</td>
                        </tr>
                        <tr>
                            <th>Poin</th>
                            <td>{{ $pembeli->poin_pembeli }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>
                                @if($pembeli->id_alamat_utama && $pembeli->alamats->where('id_alamat', $pembeli->id_alamat_utama)->first())
                                    {{ $pembeli->alamats->where('id_alamat', $pembeli->id_alamat_utama)->first()->detail }}
                                @else
                                    Belum diatur
                                @endif
                            </td>
                        </tr>
                    </table>

                    @if($pembeli->transaksi && $pembeli->transaksi->isNotEmpty())
                        <div class="card shadow-sm rounded mt-4">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">Riwayat Pembelian</h5>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-striped mb-0">
                                    <thead class="table-success">
                                        <tr>
                                            <th>NO</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Status</th>
                                            <th>Barang</th>
                                            <th>Total Harga</th>
                                            <th>Pegawai Verifikasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pembeli->transaksi as $index => $transaksi)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d M Y') }}</td>
                                                <td>{{ ucfirst($transaksi->status_transaksi) }}</td>
                                                <td>
                                                    <ul class="mb-0">
                                                        @foreach($transaksi->barangs as $barang)
                                                            <li>{{ $barang->nama_barang }}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                                                <td>{{ ($transaksi->pegawai && $transaksi->pegawai->nama_pegawai !== 'DUMMY') ? $transaksi->pegawai->nama_pegawai : '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info mt-4">
                            Belum ada riwayat pembelian.
                        </div>
                    @endif
            
        @endif
    </div>

    <!-- <footer class="footer">
        &copy; 2025 ReUseMart. All Rights Reserved.
    </footer> -->
</body>
</html>
