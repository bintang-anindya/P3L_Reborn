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
        /* Tambahkan dua properti ini: */
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
</style>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
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
            <h2 class="text-3xl font-bold text-gray-800 mb-6 border-l-4 border-red-600 pl-4 leading-tight">Daftar Barang Expired</h2>
            
            <div class="d-flex justify-content-start mb-3">
                <form action="{{ route('dashboard.gudang') }}" method="GET">
                    <button class="btn btn-outline-secondary">
                        <i class="bi bi-house-door me-1"></i> Back to Dashboard
                    </button>
                </form>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card-body table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Barang</th>
                            <th>Tanggal Masuk</th>
                            <th>Tenggat Waktu</th>
                            <th>Nama Penitip</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barang_expired as $barang)
                        <tr>
                            <td>{{ $barang->nama_barang }}</td>
                            <td>
                                @if($barang->tanggal_masuk)
                                    {{ $barang->tanggal_masuk instanceof \Carbon\Carbon ? $barang->tanggal_masuk->format('d/m/Y') : \Carbon\Carbon::parse($barang->tanggal_masuk)->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="{{ \Carbon\Carbon::parse($barang->tenggat_waktu)->isPast() ? 'text-danger' : '' }}">
                                @if($barang->tenggat_waktu)
                                    {{ $barang->tenggat_waktu instanceof \Carbon\Carbon ? $barang->tenggat_waktu->format('d/m/Y') : \Carbon\Carbon::parse($barang->tenggat_waktu)->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $barang->penitipan->penitip->nama_penitip ?? '-' }}</td>
                            <td>
                                <form action="{{ route('gudang.ambilBarang.ambil', $barang->id_barang) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        Ambil
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada barang expired.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
@endsection