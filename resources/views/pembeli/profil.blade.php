@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReUseMart - Profil Pembeli</title>
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
        /* Penyesuaian untuk tabel agar lebih rapi */
        th, td {
            padding: 0.75rem 1rem; /* Padding lebih besar */
            text-align: left;
        }
        th {
            background-color: #f3f4f6; /* Latar belakang untuk header kolom */
            font-weight: 600; /* Sedikit lebih tebal */
            color: #374151; /* Warna teks gelap */
        }
        td {
            color: #4b5563; /* Warna teks untuk data */
        }
        tr:nth-child(even) {
            background-color: #f9fafb; /* Warna latar belakang bergantian untuk baris tabel */
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Topbar Promosi -->
    <div class="topbar bg-gray-900 text-white py-2 px-4 text-center text-sm font-medium rounded-b-lg shadow-md">
        Perbanyak Belanja dan Dapatkan Poin Serta Merchandise Menarik!
        <a href="{{ route('dashboard.pembeli') }}" class="text-white hover:text-red-400 underline ml-1 transition duration-300">Belanja Sekarang!</a>
    </div>

    <!-- Navbar -->
    <nav class="bg-white shadow-sm py-4">
        <div class="container mx-auto px-4 flex items-center justify-between">
            <!-- Brand Logo -->
            <a class="text-2xl font-extrabold text-gray-800 hover:text-red-600 transition duration-300" href="{{ route('dashboard.pembeli') }}">ReUseMart</a>

            <!-- Search Bar -->
            <form class="flex-grow max-w-md mx-4">
                <div class="relative">
                    <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition duration-300" type="search" placeholder="Cari produk impianmu...">
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

    <main class="container mx-auto mt-8 pb-20 px-4">
        @if(Auth::check())
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
            <!-- Card Header -->
            <div class="bg-gray-800 text-white flex flex-col sm:flex-row justify-between items-center px-6 py-4">
                <h4 class="text-2xl font-bold mb-2 sm:mb-0">Profil Pembeli</h4>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('dashboard.pembeli') }}" class="bg-white text-gray-800 rounded-full px-4 py-2 text-sm font-semibold hover:bg-gray-200 transition duration-300">← Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-600 text-white rounded-full px-4 py-2 text-sm font-semibold hover:bg-red-700 transition duration-300">Logout</button>
                    </form>
                </div>
            </div>

            <!-- Card Body -->
            <div class="p-6">
                <table class="w-full text-base border-collapse border border-gray-300 rounded-lg overflow-hidden">
                    <tbody>
                        <tr class="border-b border-gray-200">
                            <th>Nama</th>
                            <td>{{ $pembeli->nama_pembeli }}</td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <th>Username</th>
                            <td>{{ $pembeli->username_pembeli }}</td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <th>Email</th>
                            <td>{{ $pembeli->email_pembeli }}</td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <th>No Telepon</th>
                            <td>{{ $pembeli->no_telp_pembeli }}</td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <th>Poin</th>
                            <td>{{ $pembeli->poin_pembeli }}</td>
                        </tr>
                        <tr>
                            <th>Alamat Utama</th>
                            <td>
                                @if($pembeli->id_alamat_utama && $pembeli->alamats->where('id_alamat', $pembeli->id_alamat_utama)->first())
                                    {{ $pembeli->alamats->where('id_alamat', $pembeli->id_alamat_utama)->first()->detail }}
                                @else
                                    Belum diatur
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>

                @if($pembeli->transaksi && $pembeli->transaksi->isNotEmpty())
                <div class="mt-8">
                    <div class="bg-gray-800 text-white px-6 py-3 rounded-t-lg">
                        <h5 class="font-bold text-lg">Riwayat Pembelian</h5>
                    </div>
                    <div class="overflow-x-auto border border-gray-200 rounded-b-lg">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-100 text-gray-700 uppercase tracking-wider">
                                <tr>
                                    <th class="px-4 py-3 text-left">No</th>
                                    <th class="px-4 py-3 text-left">Tanggal Transaksi</th>
                                    <th class="px-4 py-3 text-left">Status</th>
                                    <th class="px-4 py-3 text-left">Barang</th>
                                    <th class="px-4 py-3 text-left">Total Harga</th>
                                    <th class="px-4 py-3 text-left">Pegawai Verifikasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pembeli->transaksi as $index => $transaksi)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="px-4 py-3">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3">{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d M Y') }}</td>
                                    <td class="px-4 py-3 capitalize">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                                            @if($transaksi->status_transaksi == 'transaksi selesai') bg-green-100 text-green-700
                                            @elseif($transaksi->status_transaksi == 'dikirim') bg-blue-100 text-blue-700
                                            @elseif($transaksi->status_transaksi == 'Batal') bg-red-100 text-red-700
                                            @else bg-gray-100 text-gray-700
                                            @endif">
                                            {{ $transaksi->status_transaksi }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach($transaksi->barangs as $barangItem)
                                                <li>{{ $barangItem->nama_barang }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="px-4 py-3">Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3">
                                        {{ ($transaksi->pegawai && $transaksi->pegawai->nama_pegawai !== 'DUMMY') ? $transaksi->pegawai->nama_pegawai : '-' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @else
                <div class="mt-8 p-4 bg-blue-100 border-l-4 border-blue-500 text-blue-700 rounded-lg shadow-sm">
                    <p class="font-medium">Belum ada riwayat pembelian.</p>
                </div>
                @endif
            </div>
        </div>
        @endif
    </main>

    <!-- Footer -->
    <!-- <footer class="bg-gray-900 text-white text-center py-4 absolute bottom-0 w-full shadow-inner">
        &copy; {{ date('Y') }} ReUseMart. All rights reserved.
    </footer> -->

</body>
</html>
@endsection