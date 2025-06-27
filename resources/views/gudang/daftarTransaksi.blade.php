@extends('layouts.app')

@section('content')
<style>
    /* Menggunakan flex-shrink-0 untuk memastikan sidebar tidak menyusut */
    .sidebar-fixed {
        flex-shrink: 0;
    }
    /* Custom scrollbar for table-responsive */
    .overflow-x-auto::-webkit-scrollbar {
        height: 10px;
    }
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #cbd5e1; /* gray-300 */
        border-radius: 5px;
    }
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f5f9; /* gray-100 */
        border-radius: 5px;
    }
    /* Styles for modal overlay (sebaiknya juga di layouts/app.blade.php jika sama di semua modal) */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 50;
        transition: opacity 300ms ease-in-out;
    }
    .modal-container {
        background-color: white;
        border-radius: 0.75rem;
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        max-width: 2xl; /* Sesuaikan ukuran modal jika perlu, misal max-w-lg untuk lebih lebar */
        width: 100%;
        margin: 0 1rem;
        transform: scale(1);
        transition: all 300ms ease-in-out;
    }
    .modal-header {
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #e5e7eb;
    }
    .modal-body {
        padding: 1rem 1.5rem;
        color: #4b5563;
        max-height: 70vh; /* Sesuaikan nilai ini (misal 70% dari viewport height) */
        overflow-y: auto; /* Aktifkan scroll vertikal jika konten melebihi max-height */
    }
    .modal-footer {
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        border-top: 1px solid #e5e7eb;
        background-color: #f9fafb;
        border-bottom-left-radius: 0.75rem;
        border-bottom-right-radius: 0.75rem;
    }
    /* Utility classes for modal visibility */
    .modal-overlay.hidden {
        display: none;
    }
    .modal-overlay.opacity-0 {
        opacity: 0;
    }
    .modal-overlay.pointer-events-none {
        pointer-events: none;
    }

    /* Additional styles for the transaction list to make it look cohesive */
    .card-custom {
        border-radius: 0.75rem; /* Equivalent to rounded-xl */
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1); /* Equivalent to shadow-lg */
        border: 1px solid #e5e7eb; /* Equivalent to border border-gray-200 */
    }
    .card-header-custom {
        padding: 1rem 1.5rem;
        background-color: #ef4444; /* red-600 */
        color: white;
        border-top-left-radius: 0.75rem;
        border-top-right-radius: 0.75rem;
    }
    .card-body-custom {
        padding: 1.5rem;
    }
    .card-footer-custom {
        padding: 1rem 1.5rem;
        background-color: #f9fafb; /* gray-50 */
        border-bottom-left-radius: 0.75rem;
        border-bottom-right-radius: 0.75rem;
        border-top: 1px solid #e5e7eb;
    }
    .badge-custom {
        background-color: #fcd34d; /* yellow-300 */
        color: #1f2937; /* gray-900 */
        padding: 0.5rem 0.75rem;
        border-radius: 0.25rem;
        font-weight: 600;
    }
    .img-transaction-item {
        width: 100%;
        height: 100px; /* Fixed height for consistency */
        object-fit: cover; /* Ensures image covers the area without distortion */
        border-radius: 0.375rem; /* rounded-md */
    }
</style>

{{-- Alert --}}
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

{{-- Tampilkan error validasi --}}
@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="flex flex-grow">
    <nav id="sidebarMenu" class="sidebar-fixed w-full md:w-1/4 lg:w-1/5 p-6 bg-white shadow-lg border-r border-gray-200 h-screen sticky top-0 left-0 flex flex-col">
        <div class="pt-3 flex flex-col h-full">
            <h5 class="text-2xl font-bold text-gray-800 mb-6 text-center">Dashboard Gudang</h5>
            <ul class="flex flex-col space-y-2 flex-grow">
                <li class="nav-item">
                    <a class="block py-3 px-4 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-red-600 transition duration-300 flex items-center {{ request()->is('gudang/inputBarang*') ? 'bg-gray-800 text-white hover:bg-gray-700 hover:text-white' : '' }}" href="/gudang/inputBarang">
                        <i class="fas fa-box mr-3 text-lg"></i>
                        Input Barang
                    </a>
                </li>
                <li class="nav-item">
                    <a class="block py-3 px-4 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-red-600 transition duration-300 flex items-center {{ request()->is('gudang/ambilBarang*') ? 'bg-gray-800 text-white hover:bg-gray-700 hover:text-white' : '' }}" href="/gudang/ambilBarang">
                        <i class="fas fa-receipt mr-3 text-lg"></i>
                        Daftar Pengambilan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="block py-3 px-4 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-red-600 transition duration-300 flex items-center {{ request()->is('gudang/daftarTransaksi*') ? 'bg-gray-800 text-white hover:bg-gray-700 hover:text-white' : '' }}" href="/gudang/daftarTransaksi">
                        <i class="fas fa-file-invoice-dollar mr-3 text-lg"></i>
                        Daftar Transaksi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="block py-3 px-4 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-red-600 transition duration-300 flex items-center {{ request()->is('gudang/cetak*') ? 'bg-gray-800 text-white hover:bg-gray-700 hover:text-white' : '' }}" href="/gudang/cetak">
                        <i class="fas fa-print mr-3 text-lg"></i>
                        Cetak PDF
                    </a>
                </li>
                <li class="nav-item">
                    <a class="block py-3 px-4 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-red-600 transition duration-300 flex items-center {{ request()->is('gudang/konfirmasi*') ? 'bg-gray-800 text-white hover:bg-gray-700 hover:text-white' : '' }}" href="/gudang/konfirmasi">
                        <i class="fas fa-check-double mr-3 text-lg"></i>
                        Konfirmasi Pengambilan
                    </a>
                </li>
            </ul>

            <div class="mt-auto p-4">
                <form action="{{ route('logout') }}" method="POST" class="flex justify-center">
                    @csrf
                    <button type="submit" class="bg-red-600 text-white px-5 py-3 rounded-lg font-semibold hover:bg-red-700 transition duration-300 w-full flex items-center justify-center shadow-md">
                        <i class="fas fa-sign-out-alt mr-3 text-lg"></i>
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="flex-grow p-8 bg-white rounded-xl shadow-lg border border-gray-200 mt-8 md:mt-0 md:ml-8 mx-4 md:mx-0">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 border-l-4 border-red-600 pl-4 leading-tight">Daftar Transaksi Sedang Disiapkan</h2>

        <div class="d-flex justify-content-start mb-3">
            <form action="{{ route('dashboard.gudang') }}" method="GET">
                <button class="btn btn-outline-secondary">
                    <i class="bi bi-house-door me-1"></i> Back to Dashboard
                </button>
            </form>
        </div>

        @if($transactions->isEmpty())
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Info!</strong>
                <span class="block sm:inline">Tidak ada transaksi yang sedang disiapkan.</span>
            </div>
        @else
            <div class="grid grid-cols-1 gap-6">
                @foreach($transactions as $transaction)
                    <div class="card-custom">
                        <div class="card-header-custom">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h5 class="text-xl font-semibold mb-0">Transaksi #{{ $transaction->id_transaksi }}</h5>
                                    <small class="text-gray-100">{{ date('d F Y', strtotime($transaction->tanggal_transaksi)) }}</small>
                                </div>
                                <span class="badge-custom">
                                    <i class="fas fa-hourglass-half mr-1"></i> {{ ucfirst($transaction->metode) }}
                                </span>
                            </div>
                        </div>

                        <div class="card-body-custom">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($transaction->transaksiBarang as $transaksiBarang)
                                    @php
                                        $barang = $transaksiBarang->barang;
                                    @endphp
                                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                                        <div class="flex">
                                            <div class="w-1/3">
                                                <img src="{{ asset('storage/' . ($barang->gambar_barang ?? 'default-product.png')) }}" alt="Gambar Barang" class="img-transaction-item">
                                            </div>
                                            <div class="w-2/3 p-4">
                                                <h6 class="font-semibold text-gray-800 mb-1">{{ $barang->nama_barang ?? 'Produk' }}</h6>
                                                <div class="flex justify-between items-center">
                                                    <p class="text-red-600 font-bold text-lg mb-0">
                                                        Rp {{ number_format($barang->harga_barang, 0, ',', '.') }}
                                                    </p>
                                                    <p class="text-gray-500 text-sm mb-0">
                                                        x{{ $transaksiBarang->jumlah }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="card-footer-custom flex justify-between items-center">
                            <div>
                                <span class="font-bold text-gray-700">Total:</span>
                                <span class="text-xl font-semibold text-red-600 ml-2">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex gap-2 items-center">
                                <button type="button" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300 flex items-center" data-bs-toggle="modal"
                                    data-bs-target="#detailModal-{{ $transaction->id_transaksi }}">
                                    <i class="fas fa-info-circle mr-2"></i> Detail
                                </button>

                                @if($transaction->metode === 'ambil_sendiri')
                                <button type="button" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-300 flex items-center" data-bs-toggle="modal"
                                    data-bs-target="#pengambilanModal-{{ $transaction->id_transaksi }}">
                                    <i class="fas fa-hand-holding-box mr-2"></i> Ambil
                                </button>
                                @endif

                                @if($transaction->metode === 'kurir')
                                <button type="button" class="px-4 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition duration-300 flex items-center"
                                    data-bs-toggle="modal"
                                    data-bs-target="#pengirimanModal-{{ $transaction->id_transaksi }}">
                                    <i class="fas fa-truck mr-2"></i> Dikirim
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="detailModal-{{ $transaction->id_transaksi }}" tabindex="-1"
                        aria-labelledby="detailModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-red-600 text-white">
                                    <h5 class="modal-title" id="detailModalLabel">
                                        Detail Transaksi #{{ $transaction->id_transaksi }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <p class="mb-2"><strong class="text-gray-700">Tanggal Transaksi:</strong> {{ date('d F Y', strtotime($transaction->tanggal_transaksi)) }}</p>
                                            <p class="mb-2"><strong class="text-gray-700">Status:</strong>
                                                <span class="badge-custom">
                                                    {{ ucfirst($transaction->status_transaksi) }}
                                                </span>
                                            </p>
                                            <p class="mb-2"><strong class="text-gray-700">Total Harga:</strong> <span class="font-bold text-red-600">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</span></p>
                                        </div>
                                        <div>
                                            <p class="mb-2"><strong class="text-gray-700">Metode Pengambilan:</strong> {{ $transaction->metode }}</p>
                                            <p class="mb-2"><strong class="text-gray-700">Pembeli:</strong> {{ $transaction->pembeli->nama_pembeli ?? 'Tidak diketahui' }}</p>
                                        </div>
                                    </div>

                                    <hr class="my-4">

                                    <h5 class="text-xl font-bold text-gray-800 mb-3">Daftar Barang</h5>
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-left table-auto">
                                            <thead class="bg-gray-100">
                                                <tr>
                                                    <th class="px-4 py-2 text-gray-600 font-semibold">Gambar</th>
                                                    <th class="px-4 py-2 text-gray-600 font-semibold">Nama Barang</th>
                                                    <th class="px-4 py-2 text-gray-600 font-semibold">Berat</th>
                                                    <th class="px-4 py-2 text-gray-600 font-semibold">Harga Satuan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($transaction->transaksiBarang as $transaksiBarang)
                                                    @php
                                                        $barang = $transaksiBarang->barang;
                                                    @endphp
                                                    <tr class="border-b border-gray-200">
                                                        <td class="px-4 py-2">
                                                            <img src="{{ asset('storage/' . ($barang->gambar_barang ?? 'default-product.png')) }}" alt="Gambar Barang" class="w-16 h-16 object-cover rounded-md">
                                                        </td>
                                                        <td class="px-4 py-2">{{ $barang->nama_barang }}</td>
                                                        <td class="px-4 py-2">{{ $barang->berat }} kg</td>
                                                        <td class="px-4 py-2">Rp {{ number_format($barang->harga_barang, 0, ',', '.') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer flex justify-end">
                                    <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition duration-300" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="pengambilanModal-{{ $transaction->id_transaksi }}" tabindex="-1"
                        aria-labelledby="pengambilanModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-green-600 text-white">
                                    <h5 class="modal-title" id="pengambilanModalLabel">
                                        Konfirmasi Pengambilan #{{ $transaction->id_transaksi }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('gudang.daftarTransaksi.diambil', $transaction->id_transaksi) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-4">
                                            <label for="tanggal_ambil" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Pengambilan</label>
                                            <input type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="tanggal_ambil"
                                                name="tanggal_ambil"
                                                min="{{ date('Y-m-d') }}"
                                                required>
                                            <p class="text-gray-600 text-xs italic mt-1">Pilih tanggal pengambilan (tidak boleh sebelum hari ini)</p>
                                        </div>
                                    </div>
                                    <div class="modal-footer flex justify-end">
                                        <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition duration-300" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-300 flex items-center">
                                            <i class="fas fa-check-circle mr-2"></i> Konfirmasi Pengambilan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="pengirimanModal-{{ $transaction->id_transaksi }}" tabindex="-1"
                        aria-labelledby="pengirimanModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-indigo-600 text-white">
                                    <h5 class="modal-title" id="pengirimanModalLabel">
                                        Atur Pengiriman #{{ $transaction->id_transaksi }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('gudang.daftarTransaksi.dikirim', $transaction->id_transaksi) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-4">
                                            <label for="tanggal_pengiriman" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Pengiriman</label>
                                            <input type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="tanggal_pengiriman"
                                                name="tanggal_pengiriman"
                                                min="{{ date('Y-m-d') }}"
                                                required>
                                            <p class="text-gray-600 text-xs italic mt-1">Pilih tanggal pengiriman (tidak boleh sebelum hari ini)</p>
                                        </div>
                                        <div class="mb-4">
                                            <label for="id_kurir" class="block text-gray-700 text-sm font-bold mb-2">Kurir</label>
                                            <select class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="id_kurir" name="id_kurir" required>
                                                <option value="" selected disabled>Pilih Kurir</option>
                                                @foreach($kurirs as $kurir)
                                                    <option value="{{ $kurir->id_pegawai }}">
                                                        {{ $kurir->nama_pegawai }} ({{ $kurir->nomor_telepon }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer flex justify-end">
                                        <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition duration-300" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="px-4 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition duration-300 flex items-center">
                                            <i class="fas fa-check-circle mr-2"></i> Konfirmasi Pengiriman
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>
</div>

{{-- Script for date input min attribute --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        document.querySelectorAll('input[type="date"]').forEach(input => {
            input.min = today;
        });
    });
</script>
@endsection