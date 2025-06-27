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

    /* Custom styles for the table and card to match the new design */
    .card-custom {
        border-radius: 0.75rem; /* Equivalent to rounded-xl */
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1); /* Equivalent to shadow-lg */
        border: 1px solid #e5e7eb; /* Equivalent to border border-gray-200 */
    }
    .table-responsive-custom {
        overflow-x: auto;
    }
    .table-custom {
        width: 100%;
        text-align: left;
        border-collapse: collapse;
    }
    .table-custom th,
    .table-custom td {
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb; /* gray-200 */
    }
    .table-custom thead th {
        background-color: #f3f4f6; /* gray-100 */
        color: #4b5563; /* gray-700 */
        font-weight: 600; /* semibold */
        text-transform: uppercase;
        font-size: 0.75rem; /* text-xs */
    }
    .table-custom tbody tr:hover {
        background-color: #f9fafb; /* gray-50 */
    }
    .badge-warning-custom {
        background-color: #fcd34d; /* yellow-300 */
        color: #1f2937; /* gray-900 */
        padding: 0.35rem 0.75rem;
        border-radius: 0.375rem; /* rounded-md */
        font-size: 0.75rem; /* text-xs */
        font-weight: 600; /* font-semibold */
    }
    .badge-primary-custom {
        background-color: #3b82f6; /* blue-500 */
        color: white;
        padding: 0.35rem 0.75rem;
        border-radius: 0.375rem; /* rounded-md */
        font-size: 0.75rem; /* text-xs */
        font-weight: 600; /* font-semibold */
    }
    .badge-success-custom {
        background-color: #22c55e; /* green-500 */
        color: white;
        padding: 0.35rem 0.75rem;
        border-radius: 0.375rem; /* rounded-md */
        font-size: 0.75rem; /* text-xs */
        font-weight: 600; /* font-semibold */
    }
    .btn-custom {
        padding: 0.75rem 1.25rem; /* px-5 py-3 */
        border-radius: 0.5rem; /* rounded-lg */
        font-weight: 600; /* font-semibold */
        transition: all 0.3s ease-in-out;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
</style>

{{-- Alert --}}
@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
@endif

{{-- Tampilkan error validasi --}}
@if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Oops!</strong>
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
        <h2 class="text-3xl font-bold text-gray-800 mb-6 border-l-4 border-red-600 pl-4 leading-tight">Konfirmasi Pengambilan</h2>
        <div class="d-flex justify-content-start mb-3">
            <form action="{{ route('dashboard.gudang') }}" method="GET">
                <button class="btn btn-outline-secondary">
                    <i class="bi bi-house-door me-1"></i> Back to Dashboard
                </button>
            </form>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="card-custom">
            <div class="p-0">
                <div class="table-responsive-custom">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th class="w-24">Nomor Transaksi</th>
                                <th class="w-32">Tanggal</th>
                                <th>Nama Pembeli</th>
                                <th>Nama Barang</th>
                                <th class="w-40">Total Harga</th>
                                <th class="w-32">Status</th>
                                <th class="w-32 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksis as $transaksi)
                                <tr>
                                    <td>{{ $transaksi->nomor_transaksi }}</td>
                                    <td>{{ $transaksi->tanggal_transaksi }}</td>
                                    <td>{{ $transaksi->pembeli->nama_pembeli ?? '-' }}</td>
                                    <td>
                                        <ul class="mb-0 list-disc list-inside">
                                            @foreach($transaksi->barang as $barang)
                                                <li>{{ $barang->nama_barang }} ({{ $barang->pivot->jumlah }})</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                                    <td><span class="badge-warning-custom">{{ $transaksi->status_transaksi }}</span></td>
                                    <td class="text-center">
                                        <button type="button" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-300 flex items-center mx-auto" data-bs-toggle="modal" data-bs-target="#konfirmasiModal{{ $transaksi->id_transaksi }}">
                                            <i class="fas fa-check-double mr-2"></i> Konfirmasi
                                        </button>

                                        <div class="modal fade" id="konfirmasiModal{{ $transaksi->id_transaksi }}" tabindex="-1" aria-labelledby="modalLabel{{ $transaksi->id_transaksi }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('gudang.konfirmasi.konfirmasi', $transaksi->id_transaksi) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-header bg-green-600 text-white">
                                                            <h5 class="modal-title" id="modalLabel{{ $transaksi->id_transaksi }}">Konfirmasi Pengambilan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="text-gray-700">Apakah Anda yakin ingin mengubah status transaksi menjadi **Selesai**?</p>
                                                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4" role="alert">
                                                                <strong class="font-bold">Perhatian!</strong>
                                                                <span class="block sm:inline">Tindakan ini tidak dapat dibatalkan.</span>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer flex justify-end">
                                                            <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition duration-300" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-300">Ya, Konfirmasi</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-gray-500">Tidak ada transaksi yang menunggu pengambilan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection