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
    <!-- Google Font: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', 'Roboto', sans-serif;
            background-color: #f8f9fa; /* Warna latar belakang umum */
        }
        /* Custom styles for carousel navigation for better visibility */
        .carousel-btn {
            @apply absolute top-1/2 transform -translate-y-1/2 p-2 bg-black bg-opacity-50 text-white rounded-full z-10;
            transition: background-color 0.3s ease;
        }
        .carousel-btn:hover {
            background-color: rgba(0, 0, 0, 0.7);
        }
        .carousel-dots .dot {
            @apply w-3 h-3 bg-gray-400 rounded-full cursor-pointer;
            transition: background-color 0.3s ease;
        }
        .carousel-dots .dot.active {
            @apply bg-red-500;
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
                <!-- Diskusi Button -->
                <a href="{{ route('diskusi.index') }}" class="px-3 py-2 text-gray-700 rounded-lg font-medium hover:bg-gray-100 hover:text-red-600 transition duration-300">Diskusi</a>
                <!-- Kelola Alamat Button -->
                <a href="{{ route('alamat.manager') }}" class="px-3 py-2 text-gray-700 rounded-lg font-medium hover:bg-gray-100 hover:text-red-600 transition duration-300">Kelola Alamat</a>
                <!-- User Profile Icon -->
                <a href="{{ route('profilPembeli') }}" class="hover:text-red-500 transition duration-300" title="Profil Pengguna">
                    <i class="fas fa-user-circle text-xl"></i>
                </a>
                <!-- Wishlist Icon -->
                <a href="#" class="hover:text-red-500 transition duration-300" title="Daftar Keinginan">
                    <i class="fas fa-heart text-xl"></i>
                </a>
                <!-- Shopping Cart Icon -->
                <a href="{{ route('keranjang.index') }}" class="relative hover:text-red-500 transition duration-300" title="Keranjang Belanja">
                    <i class="fas fa-shopping-cart text-xl"></i>
                    <!-- Notifikasi keranjang (opsional, contoh: jika ada 3 item) -->
                    <span class="absolute -top-1 -right-2 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full">3</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content - Product Detail -->
    <div class="container mx-auto mt-8 p-4 md:p-8 bg-white rounded-lg shadow-lg">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Product Images Section - Now a Carousel -->
            <div class="md:w-1/2 relative">
                <div id="productCarousel" class="relative w-full overflow-hidden rounded-xl shadow-lg">
                    <div class="carousel-inner flex transition-transform duration-500 ease-in-out">
                        <!-- Main product image -->
                        <img src="{{ asset('storage/' . $barang->gambar_barang) }}" class="w-full flex-shrink-0 object-cover" alt="Gambar {{ $barang->nama_barang }}">
                        @if($barang->gambarTambahan->count() > 0)
                            <!-- Additional images from gambarTambahan -->
                            @foreach($barang->gambarTambahan as $gambar)
                                <img src="{{ asset('storage/' . $gambar->path_gambar) }}" class="w-full flex-shrink-0 object-cover" alt="Gambar Tambahan Produk">
                            @endforeach
                        @endif
                    </div>

                    <!-- Carousel Navigation Buttons -->
                    <button id="prevBtn" class="carousel-btn left-2">
                        <i class="fas fa-chevron-left text-2xl"></i>
                    </button>
                    <button id="nextBtn" class="carousel-btn right-2">
                        <i class="fas fa-chevron-right text-2xl"></i>
                    </button>
                </div>
                <!-- Carousel Dots/Indicators -->
                <div id="carouselDots" class="carousel-dots flex justify-center space-x-2 mt-4">
                    <!-- Dots will be generated by JavaScript -->
                </div>
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
                                        // use Illuminate\Support\Facades\DB; // Hanya perlu di controller atau bagian lain di Laravel
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
                    <!-- Tambah ke Keranjang Button -->
                    <form action="{{ route('keranjang.tambah', $barang->id_barang) }}" method="POST" class="flex-shrink-0">
                        @csrf
                        <button type="submit" class="px-6 py-3 border-2 border-blue-600 text-blue-600 font-semibold text-lg rounded-xl hover:bg-blue-50 transition duration-300 shadow-md transform hover:scale-105 active:scale-95 focus:outline-none focus:ring-4 focus:ring-blue-300">
                            <i class="fas fa-shopping-cart mr-2"></i> Tambah Keranjang
                        </button>
                    </form>
                </div>

                <!-- Product Discussion Card -->
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 shadow-sm">
                    <h5 class="text-2xl font-semibold text-gray-800 mb-4">Diskusi Produk</h5>
                    <form action="{{ route('diskusi.storeDiskusi', $barang->id_barang) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="isi_balasan" class="block text-gray-700 text-sm font-medium mb-2">Pesan Anda</label>
                            <textarea class="form-textarea w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" id="isi_balasan" name="isi_balasan" rows="4" placeholder="Tanyakan sesuatu tentang produk ini..."></textarea>
                        </div>
                        <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-300 shadow-md transform hover:scale-105 active:scale-95 focus:outline-none focus:ring-4 focus:ring-blue-300">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const carouselInner = document.querySelector('.carousel-inner');
            const images = carouselInner.querySelectorAll('img');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const carouselDotsContainer = document.getElementById('carouselDots');

            let currentIndex = 0;
            const totalImages = images.length;

            // Function to update carousel display
            function updateCarousel() {
                const offset = -currentIndex * 100;
                carouselInner.style.transform = `translateX(${offset}%)`;
                updateDots();
            }

            // Function to update active dot
            function updateDots() {
                carouselDotsContainer.innerHTML = ''; // Clear existing dots
                for (let i = 0; i < totalImages; i++) {
                    const dot = document.createElement('div');
                    dot.classList.add('dot');
                    if (i === currentIndex) {
                        dot.classList.add('active');
                    }
                    // Use a closure to capture the correct index for each dot
                    ((index) => {
                        dot.addEventListener('click', () => {
                            currentIndex = index;
                            updateCarousel();
                        });
                    })(i);
                    carouselDotsContainer.appendChild(dot);
                }
            }

            // Event listener for previous button
            prevBtn.addEventListener('click', () => {
                currentIndex = (currentIndex === 0) ? totalImages - 1 : currentIndex - 1;
                updateCarousel();
            });

            // Event listener for next button
            nextBtn.addEventListener('click', () => {
                currentIndex = (currentIndex === totalImages - 1) ? 0 : currentIndex + 1;
                updateCarousel();
            });

            // Initialize carousel and dots on load
            updateCarousel();
        });
    </script>
</body>
</html>
@endsection
