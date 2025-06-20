@extends('layouts.app')

@section('content')
<head>
    <title>ReUseMart - E-Commerce</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
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
        .seller-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .rating-stars {
            color: #ffc107;
        }
    </style>
</head>


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
                <a href="{{ route('profilPembeli') }}" class="text-dark">
                    <i class="fas fa-user-circle fa-lg"></i>
                </a>
                <a href="#" class="text-dark"><i class="fas fa-heart"></i></a>
                <a href="{{ route('keranjang.index') }}" class="text-dark"><i class="fas fa-shopping-cart"></i></a>
            </div>
        </div>
    </nav>
    
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset('storage/' . $barang->gambar_barang) }}" class="img-fluid rounded" alt="Gambar {{ $barang->nama_barang }}">
            @if($barang->gambarTambahan->count() > 0)
                <div class="mb-3">
                    <div class="row">
                        @foreach($barang->gambarTambahan as $gambar)
                            <div class="col-md-3 mb-2 position-relative">
                                <img src="{{ asset('storage/' . $gambar->path_gambar) }}" class="img-thumbnail" width="150">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        <div class="col-md-6">
            <div class="container my-5">
                <h2 class="fw-bold">{{ $barang->nama_barang }}</h2>
                <!-- Info Penitip Barang -->
                <div class="seller-info">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-store me-2 text-primary"></i>
                        <div>
                            <h6 class="mb-1">{{ optional(optional($barang->penitipan)->penitip)->nama_penitip ?? '-' }}</h6>
                            <div class="d-flex align-items-center">
                                <div class="rating-stars me-2">
                                    @php
                                        $penitip = optional(optional($barang->penitipan)->penitip);
                                        $totalRating = $penitip->total_rating ?? 0;
                                        $jumlahPeRating = $penitip->jumlah_perating ?? 0;
                                        $averageRating = $jumlahPeRating > 0 ? $totalRating / $jumlahPeRating : 0;
                                        $roundedRating = round($averageRating, 1);
                                        
                                        // Hitung jumlah produk terjual untuk penitip ini menggunakan query
                                        $totalProdukTerjual = 0;
                                        if ($penitip && $penitip->id_penitip) {
                                            $totalProdukTerjual = DB::table('transaksi_barang')
                                                ->join('barang', 'transaksi_barang.id_barang', '=', 'barang.id_barang')
                                                ->join('penitipan', 'barang.id_penitipan', '=', 'penitipan.id_penitipan')
                                                ->where('penitipan.id_penitip', $penitip->id_penitip)
                                                ->count();
                                        }
                                    @endphp
                                    
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($averageRating))
                                            <i class="fas fa-star"></i>
                                        @elseif($i - 0.5 <= $averageRating)
                                            <i class="fas fa-star-half-alt"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-muted small">
                                    @if($jumlahPeRating > 0)
                                        ({{ $roundedRating }}/5.0 dari {{ $jumlahPeRating }} rating)
                                    @else
                                        (Belum ada rating)
                                    @endif
                                </span>
                                <span class="text-muted small ms-2">
                                    {{ $totalProdukTerjual }} produk terjual
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <h3 class="text-danger">Rp{{ number_format($barang->harga_barang, 0, ',', '.') }}</h3>
                    <span class="ms-3 text-success">● {{ $barang->status_barang }}</span>
                </div>

                <p class="text-muted">{{ $barang->deskripsi_barang }}</p>

                <hr>

                <div class="mb-3">
                    <strong>Berat:</strong> {{ $barang->berat }} Kilogram <br>
                    <strong>Garansi:</strong> {{ $barang->tanggal_garansi }}
                </div>

                <div class="d-flex align-items-center mb-4">
                    <button class="btn btn-danger me-2">Beli Sekarang</button>
                    <form action="{{ route('keranjang.tambah', $barang->id_barang) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary">
                        <i class="fas fa-shopping-cart"></i>
                    </button>
                </form>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Diskusi Produk</h5>
                        <form action="{{ route('diskusi.storeDiskusi', $barang->id_barang) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="isi_balasan" class="form-label">Pesan Anda</label>
                                <textarea class="form-control" id="isi_balasan" name="isi_balasan" rows="3" placeholder="Tanyakan sesuatu tentang produk ini..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection