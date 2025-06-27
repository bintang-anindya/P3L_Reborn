@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReUseMart - Detail Produk</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa; /* Warna latar belakang umum */
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Topbar Promosi -->
    <div class="topbar bg-gray-900 text-white py-2 px-4 text-center text-sm font-medium rounded-b-lg shadow-md">
        Perbanyak Belanja dan Dapatkan Poin Serta Merchandise Menarik!
        <a href="#" class="text-white hover:text-red-400 underline ml-1 transition duration-300">Belanja Sekarang!</a>
    </div>

    <!-- Navbar -->
    <nav class="bg-white shadow-sm py-4">
        <div class="container mx-auto px-4 flex items-center justify-between">
            <!-- Brand Logo -->
            <a class="text-2xl font-extrabold text-gray-800 hover:text-red-600 transition duration-300" href="{{ route('home') }}">ReUseMart</a>

            <!-- Search Bar -->
            <form class="flex-grow max-w-md mx-4">
                <div class="relative">
                    <input class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition duration-300" type="search" placeholder="Cari produk impianmu...">
                    <button type="submit" class="absolute right-0 top-0 mt-2 mr-3 text-gray-500 hover:text-red-500 transition duration-300">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

            <!-- Navigation Icons/Buttons -->
            <div class="flex items-center space-x-6 text-gray-700">
                <a href="#" class="hover:text-red-500 transition duration-300" title="Daftar Keinginan">
                    <i class="fas fa-heart text-xl"></i>
                </a>
                <a href="#" class="relative hover:text-red-500 transition duration-300" title="Keranjang Belanja">
                    <i class="fas fa-shopping-cart text-xl"></i>
                    <!-- Notifikasi keranjang (opsional) -->
                    <span class="absolute -top-1 -right-2 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full">3</span>
                </a>
                <a href="{{ route('loginPage') }}" class="btn bg-red-600 text-white px-5 py-2 rounded-lg font-medium hover:bg-red-700 transition duration-300 shadow-md">Login/Daftar</a>
            </div>
        </div>
    </nav>

    <!-- Main Content - Product Detail -->
    <div class="container mx-auto mt-8 p-4 md:p-8 bg-white rounded-lg shadow-lg">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Product Images Section -->
            <div class="md:w-1/2">
                <div class="main-image-container mb-4 overflow-hidden rounded-xl shadow-lg">
                    <img src="{{ asset('storage/' . $barang->gambar_barang) }}" class="w-full h-auto object-cover transform hover:scale-105 transition-transform duration-500" alt="Gambar {{ $barang->nama_barang }}">
                </div>
                @if($barang->gambarTambahan->count() > 0)
                    <div class="flex flex-wrap gap-3 justify-center md:justify-start">
                        @foreach($barang->gambarTambahan as $gambar)
                            <div class="w-24 h-24 overflow-hidden rounded-lg border-2 border-gray-200 hover:border-red-500 cursor-pointer transition duration-300 shadow-sm">
                                <img src="{{ asset('storage/' . $gambar->path_gambar) }}" class="w-full h-full object-cover" alt="Gambar Tambahan">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Details Section -->
            <div class="md:w-1/2">
                <h1 class="text-4xl font-bold text-gray-800 mb-3 leading-tight">{{ $barang->nama_barang }}</h1>

                <!-- Seller Info -->
                <div class="seller-info bg-gray-50 p-4 rounded-xl mb-6 shadow-sm border border-gray-200">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-store text-red-500 text-xl mr-3"></i>
                        <div>
                            <h6 class="text-lg font-semibold text-gray-700 mb-0">{{ optional(optional($barang->penitipan)->penitip)->nama_penitip ?? 'Penitip Tidak Diketahui' }}</h6>
                            <div class="flex items-center mt-1">
                                <div class="rating-stars text-yellow-400 text-sm flex items-center">
                                    @php
                                        $penitip = optional(optional($barang->penitipan)->penitip);
                                        $totalRating = $penitip->total_rating ?? 0;
                                        $jumlahPeRating = $penitip->jumlah_perating ?? 0;
                                        $averageRating = $jumlahPeRating > 0 ? $totalRating / $jumlahPeRating : 0;
                                        $roundedRating = round($averageRating, 1);

                                        // Hitung jumlah produk terjual untuk penitip ini menggunakan query
                                        // Pastikan DB facade di-import jika digunakan di luar context Laravel
                                        // use Illuminate\Support\Facades\DB;
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
                                            <i class="far fa-star text-gray-300"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-gray-600 text-xs ml-2">
                                    @if($jumlahPeRating > 0)
                                        ({{ $roundedRating }}/5.0 dari {{ $jumlahPeRating }} rating)
                                    @else
                                        (Belum ada rating)
                                    @endif
                                </span>
                                <span class="text-gray-600 text-xs ml-4 border-l pl-4 border-gray-300">
                                    {{ $totalProdukTerjual }} produk terjual
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Price and Status -->
                <div class="flex items-center mb-4">
                    <h3 class="text-5xl font-extrabold text-red-600 mr-4">Rp{{ number_format($barang->harga_barang, 0, ',', '.') }}</h3>
                    <span class="px-3 py-1 bg-green-100 text-green-700 font-semibold text-sm rounded-full">
                        {{ $barang->status_barang }}
                    </span>
                </div>

                <!-- Product Description -->
                <p class="text-gray-700 leading-relaxed mb-6">{{ $barang->deskripsi_barang }}</p>

                <hr class="border-t border-gray-200 mb-6">

                <!-- Product Attributes -->
                <div class="mb-6 text-gray-700">
                    <p class="mb-2"><strong class="font-semibold">Berat:</strong> {{ $barang->berat }} Kilogram</p>
                    <p><strong class="font-semibold">Garansi:</strong> {{ $barang->tanggal_garansi }}</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center space-x-4 mb-8">
                    <button class="flex-1 px-8 py-3 bg-red-600 text-white font-bold text-lg rounded-xl hover:bg-red-700 transition duration-300 shadow-lg transform hover:scale-105 active:scale-95 focus:outline-none focus:ring-4 focus:ring-red-300">Beli Sekarang</button>
                    <button class="px-6 py-3 border-2 border-red-600 text-red-600 font-semibold text-lg rounded-xl hover:bg-red-50 transition duration-300 shadow-md transform hover:scale-105 active:scale-95 focus:outline-none focus:ring-4 focus:ring-red-300">
                        <i class="far fa-heart"></i>
                    </button>
                </div>

                <!-- Product Discussion Card -->
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 shadow-sm">
                    <h5 class="text-2xl font-semibold text-gray-800 mb-4">Diskusi Produk</h5>
                    <form action="" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="pesan" class="block text-gray-700 text-sm font-medium mb-2">Pesan Anda</label>
                            <textarea class="form-textarea w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" id="pesan" name="pesan" rows="4" placeholder="Tanyakan sesuatu tentang produk ini..."></textarea>
                        </div>
                        <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-300 shadow-md transform hover:scale-105 active:scale-95 focus:outline-none focus:ring-4 focus:ring-blue-300">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
@endsection
