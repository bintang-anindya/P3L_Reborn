@extends('layouts.app')

@section('content')
{{-- Anda dapat menambahkan CSS kustom spesifik halaman di sini atau melalui @push('styles') --}}
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
        <h2 class="text-3xl font-bold text-gray-800 mb-6 border-l-4 border-red-600 pl-4 leading-tight">Data Barang Dititipkan</h2>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-sm mb-6" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-sm mb-6" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex justify-end mb-6">
            <div class="w-full md:w-auto">
                <form id="searchForm" method="GET" action="{{ url()->current() }}" class="flex items-center space-x-2">
                    <div class="relative flex-grow">
                        <input type="text" name="search" class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Cari barang..." value="{{ request('search') }}">
                        @if(request('search'))
                            <a href="{{ url()->current() }}" class="absolute right-0 top-0 mt-3 mr-3 text-gray-500 hover:text-gray-700">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300 hidden">Search</button>
                </form>
            </div>
        </div>

        @if(isset($barangList) && $barangList->count() > 0)
            <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                <table class="w-full text-sm leading-normal">
                    <thead class="bg-gray-800 text-white uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-6 py-3 text-left">Nama Barang</th>
                            <th class="px-6 py-3 text-left">Harga</th>
                            <th class="px-6 py-3 text-left">Pesan</th>
                            <th class="px-6 py-3 text-left">Kategori</th>
                            <th class="px-6 py-3 text-left">Tanggal Masuk</th>
                            <th class="px-6 py-3 text-left">Tenggat Waktu</th>
                            <th class="px-6 py-3 text-left">Gambar</th>
                            <th class="px-6 py-3 text-left">Penitip</th>
                            <th class="px-6 py-3 text-left">QC By</th>
                            <th class="px-6 py-3 text-left">Hunter</th>
                            <th class="px-6 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($barangList as $barang)
                            <tr class="border-b border-gray-200 {{ $loop->iteration % 2 == 0 ? 'bg-gray-50' : 'bg-white' }} hover:bg-gray-100">
                                <td class="px-6 py-4">{{ $barang->nama_barang ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    @if(isset($barang->harga_barang) && $barang->harga_barang > 0)
                                        <span class="font-bold text-green-600">Rp {{ number_format($barang->harga_barang, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ optional($barang->penitipan)->pesan ?? '-' }}</td>
                                <td class="px-6 py-4">{{ optional($barang->kategori)->nama_kategori ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    @if($barang->tanggal_masuk)
                                        {{ $barang->tanggal_masuk instanceof \Carbon\Carbon ? $barang->tanggal_masuk->format('d/m/Y') : $barang->tanggal_masuk }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($barang->tenggat_waktu)
                                        {{ $barang->tenggat_waktu instanceof \Carbon\Carbon ? $barang->tenggat_waktu->format('d/m/Y') : $barang->tenggat_waktu }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($barang->gambar_barang && file_exists(storage_path('app/public/' . $barang->gambar_barang)))
                                        <a href="{{ asset('storage/' . $barang->gambar_barang) }}" target="_blank" class="block w-24 h-24 overflow-hidden rounded-md border border-gray-300 hover:border-blue-500 transition duration-300 mb-2">
                                            <img src="{{ asset('storage/' . $barang->gambar_barang) }}" class="w-full h-full object-cover" alt="Gambar {{ $barang->nama_barang }}">
                                        </a>
                                        {{-- Gambar Tambahan --}}
                                        @if($barang->gambarTambahan->count() > 0)
                                            <div class="grid grid-cols-2 gap-1 mt-2">
                                                @foreach($barang->gambarTambahan as $gambar)
                                                    <a href="{{ asset('storage/' . $gambar->path_gambar) }}" target="_blank" class="block w-full h-16 overflow-hidden rounded-md border border-gray-300 hover:border-blue-500 transition duration-300">
                                                        <img src="{{ asset('storage/' . $gambar->path_gambar) }}" class="w-full h-full object-cover" alt="Gambar Tambahan">
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    @else
                                        <span class="text-gray-500 italic">Tidak ada gambar</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ optional(optional($barang->penitipan)->penitip)->nama_penitip ?? '-' }}</td>
                                <td class="px-6 py-4">{{ optional(optional($barang->penitipan)->pegawai)->nama_pegawai ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    @if($barang->penitipan && $barang->penitipan->id_hunter)
                                        @php
                                            $hunter = $hunterList->where('id_pegawai', $barang->penitipan->id_hunter)->first();
                                        @endphp
                                        {{ $hunter->nama_pegawai ?? '-' }}
                                    @else
                                        <span class="text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 flex flex-col space-y-2 items-start whitespace-nowrap">
                                    @if($barang->penitipan)
                                        <button type="button" class="w-full px-4 py-2 bg-yellow-500 text-white rounded-lg font-semibold text-sm hover:bg-yellow-600 transition duration-300 shadow-sm btn-edit" data-id="{{ $barang->penitipan->id_penitipan }}">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </button>
                                        <button type="button" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg font-semibold text-sm hover:bg-red-700 transition duration-300 shadow-sm btn-delete" data-id="{{ $barang->penitipan->id_penitipan }}">
                                            <i class="fas fa-trash-alt mr-1"></i> Hapus
                                        </button>
                                        <a href="{{ route('penitipan.nota', $barang->penitipan->id_penitipan) }}" class="w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold text-sm hover:bg-blue-700 transition duration-300 shadow-sm" target="_blank">
                                            <i class="fas fa-file-pdf mr-1"></i> PDF
                                        </a>
                                    @else
                                        <span class="text-gray-500 italic">No actions</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        <tr id="no-results-row" class="hidden">
                            <td colspan="11" class="px-6 py-4 text-center text-gray-600">Transaksi Penitipan Barang Tidak Ditemukan!</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $barangList->links('vendor.pagination.tailwind') }} {{-- Ensure you have Tailwind pagination views --}}
            </div>
        @else
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg shadow-sm">
                Belum ada barang dititipkan.
            </div>
        @endif
    </main>
</div>

@endsection

@push('modals')
    {{-- Edit Modal --}}
    @foreach($barangList as $barang)
        @if($barang->penitipan)
            <div id="editPenitipanModal{{ $barang->penitipan->id_penitipan }}" class="modal-overlay hidden opacity-0 pointer-events-none">
                <div class="modal-container max-w-2xl"> {{-- Adjusted max-width for more content --}}
                    <form action="{{ route('gudang.inputBarang.update', $barang->penitipan->id_penitipan) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="text-xl font-semibold">Edit Data Penitipan</h5>
                            <button type="button" class="text-gray-500 hover:text-gray-700 text-2xl" onclick="closeModal('editPenitipanModal{{ $barang->penitipan->id_penitipan }}')">&times;</button>
                        </div>
                        <div class="modal-body grid grid-cols-1 md:grid-cols-2 gap-4"> {{-- Added grid for better layout --}}
                            <div>
                                <label for="edit_nama_barang_{{ $barang->id_barang }}" class="block text-sm font-medium text-gray-700">Nama Barang</label>
                                <input type="text" name="nama_barang" id="edit_nama_barang_{{ $barang->id_barang }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="{{ $barang->nama_barang }}" required>
                            </div>
                            <div>
                                <label for="edit_harga_barang_{{ $barang->id_barang }}" class="block text-sm font-medium text-gray-700">Harga</label>
                                <input type="number" name="harga_barang" id="edit_harga_barang_{{ $barang->id_barang }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="{{ $barang->harga_barang }}">
                            </div>
                            <div class="md:col-span-2"> {{-- Span two columns --}}
                                <label for="edit_pesan_{{ $barang->penitipan->id_penitipan }}" class="block text-sm font-medium text-gray-700">Pesan</label>
                                <textarea name="pesan" id="edit_pesan_{{ $barang->penitipan->id_penitipan }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ optional($barang->penitipan)->pesan }}</textarea>
                            </div>
                            <div>
                                <label for="edit_kategori_{{ $barang->id_barang }}" class="block text-sm font-medium text-gray-700">Kategori</label>
                                <select name="id_kategori" id="edit_kategori_{{ $barang->id_barang }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                                    @foreach($kategoriList as $kategori)
                                        <option value="{{ $kategori->id_kategori }}" {{ $barang->id_kategori == $kategori->id_kategori ? 'selected' : '' }}>
                                            {{ $kategori->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="edit_tanggal_masuk_{{ $barang->id_barang }}" class="block text-sm font-medium text-gray-700">Tanggal Masuk</label>
                                <input type="date" name="tanggal_masuk" id="edit_tanggal_masuk_{{ $barang->id_barang }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="{{ optional($barang->tanggal_masuk)->format('Y-m-d') }}">
                            </div>
                            <div>
                                <label for="edit_tenggat_waktu_{{ $barang->id_barang }}" class="block text-sm font-medium text-gray-700">Tenggat Waktu</label>
                                <input type="date" name="tenggat_waktu" id="edit_tenggat_waktu_{{ $barang->id_barang }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="{{ optional($barang->tenggat_waktu)->format('Y-m-d') }}">
                            </div>
                            <div>
                                <label for="edit_penitip_{{ $barang->penitipan->id_penitipan }}" class="block text-sm font-medium text-gray-700">Penitip</label>
                                <select name="id_penitip" id="edit_penitip_{{ $barang->penitipan->id_penitipan }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                                    @foreach($penitipList as $penitip)
                                        <option value="{{ $penitip->id_penitip }}" {{ optional($barang->penitipan)->id_penitip == $penitip->id_penitip ? 'selected' : '' }}>
                                            {{ $penitip->nama_penitip }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="edit_hunter_{{ $barang->penitipan->id_penitipan }}" class="block text-sm font-medium text-gray-700">Hunter</label>
                                <select name="id_hunter" id="edit_hunter_{{ $barang->penitipan->id_penitipan }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Hunter (Opsional)</option>
                                    @foreach($hunterList as $hunter)
                                        <option value="{{ $hunter->id_pegawai }}" {{ optional($barang->penitipan)->id_hunter == $hunter->id_pegawai ? 'selected' : '' }}>
                                            {{ $hunter->nama_pegawai }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label for="edit_gambar_barang_{{ $barang->id_barang }}" class="block text-sm font-medium text-gray-700">Gambar Barang (Opsional)</label>
                                <input type="file" name="gambar_barang" id="edit_gambar_barang_{{ $barang->id_barang }}" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                                @if($barang->gambar_barang)
                                    <img src="{{ asset('storage/' . $barang->gambar_barang) }}" width="100" class="mt-2 rounded-md shadow-sm" alt="Current Image">
                                @endif
                            </div>
                            <div class="md:col-span-2">
                                <label for="edit_gambar_tambahan_{{ $barang->id_barang }}" class="block text-sm font-medium text-gray-700">Gambar Tambahan (Opsional)</label>
                                <input type="file" name="gambar_tambahan[]" id="edit_gambar_tambahan_{{ $barang->id_barang }}" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" multiple>
                                @if($barang->gambarTambahan->count() > 0)
                                    <div class="grid grid-cols-4 gap-2 mt-2">
                                        @foreach($barang->gambarTambahan as $gambar)
                                            <div class="relative">
                                                <img src="{{ asset('storage/' . $gambar->path_gambar) }}" class="rounded-md shadow-sm w-full h-auto object-cover" alt="Additional Image">
                                                <button type="button" class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 text-xs delete-additional-image" data-id="{{ $gambar->id_gambar_tambahan }}" data-path="{{ $gambar->path_gambar }}">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-300" onclick="closeModal('editPenitipanModal{{ $barang->penitipan->id_penitipan }}')">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Delete Modal --}}
            <div id="hapusPenitipanModal{{ $barang->penitipan->id_penitipan }}" class="modal-overlay hidden opacity-0 pointer-events-none">
                <div class="modal-container">
                    <form action="{{ route('gudang.inputBarang.destroy', $barang->penitipan->id_penitipan) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="text-xl font-semibold">Konfirmasi Hapus</h5>
                            <button type="button" class="text-gray-500 hover:text-gray-700 text-2xl" onclick="closeModal('hapusPenitipanModal{{ $barang->penitipan->id_penitipan }}')">&times;</button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menghapus data penitipan ini?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-300" onclick="closeModal('hapusPenitipanModal{{ $barang->penitipan->id_penitipan }}')">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-300">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    @endforeach
@endpush

@push('scripts')
    <script>
        // Custom Modal Functions (pastikan ini ada di layouts/app.blade.php atau di sini)
        function showModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.remove('pointer-events-none');
                setTimeout(() => {
                    modal.classList.remove('opacity-0');
                }, 10);
            }
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('opacity-0');
                modal.classList.add('pointer-events-none');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Event listeners for edit buttons
            document.querySelectorAll('.btn-edit').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.dataset.id;
                    showModal('editPenitipanModal' + id);
                });
            });

            // Event listeners for delete buttons
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.dataset.id;
                    showModal('hapusPenitipanModal' + id);
                });
            });

            // Handle search form
            const searchInput = document.querySelector('input[name="search"]');
            searchInput.addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault(); // Prevent default form submission
                    document.getElementById('searchForm').submit();
                }
            });

            // Logic for "No results found" row
            const tableBody = document.querySelector('table tbody');
            const noResultsRow = document.getElementById('no-results-row');
            if (tableBody && noResultsRow) {
                if (tableBody.children.length === 0 || (tableBody.children.length === 1 && tableBody.children[0].id === 'no-results-row')) {
                    noResultsRow.classList.remove('hidden');
                } else {
                    noResultsRow.classList.add('hidden');
                }
            }

            // Handle delete additional images
            document.querySelectorAll('.delete-additional-image').forEach(button => {
                button.addEventListener('click', function() {
                    const imageId = this.dataset.id;
                    const imagePath = this.dataset.path;
                    if (confirm('Are you sure you want to delete this additional image?')) {
                        // You'll need an AJAX call or a form submission for this
                        // Example using fetch API:
                        fetch(`/api/delete-additional-image/${imageId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}', // Laravel CSRF token
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ path: imagePath })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.closest('div').remove(); // Remove the image container from the DOM
                                alert(data.message);
                            } else {
                                alert('Error: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error deleting image:', error);
                            alert('An error occurred while deleting the image.');
                        });
                    }
                });
            });
        });
    </script>
@endpush