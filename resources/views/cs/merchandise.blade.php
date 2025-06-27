@extends('layouts.app')

@section('content')
{{-- Hapus tag <!DOCTYPE html>, <html>, <head>, dan <body> dari sini --}}
{{-- Karena sudah di-handle oleh layouts/app.blade.php --}}

    {{-- Style spesifik halaman ini (jika ada) bisa tetap di sini, atau lebih baik lagi didorong ke stack styles --}}
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
        /* Custom styles for modal overlay - IDEALNYA INI JUGA DI LAYOUTS/APP.BLADE.PHP */
        /* Saya tetap meninggalkannya di sini untuk saat ini, tetapi sebaiknya dipindahkan */
        .modal-overlay {
            @apply fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 transition-opacity duration-300 ease-in-out;
        }
        .modal-container {
            @apply bg-white rounded-xl shadow-xl max-w-sm w-full mx-4 transform transition-all duration-300 ease-in-out;
        }
        .modal-header {
            @apply px-6 py-4 flex justify-between items-center border-b border-gray-200;
        }
        .modal-body {
            @apply px-6 py-4 text-gray-700;
        }
        .modal-footer {
            @apply px-6 py-4 flex justify-end items-center border-t border-gray-200 bg-gray-50 rounded-b-xl;
        }
    </style>

    <div class="flex flex-grow">
        <nav id="sidebarMenu" class="sidebar-fixed w-full md:w-1/4 lg:w-1/5 p-6 bg-white shadow-lg border-r border-gray-200 h-screen sticky top-0 left-0 flex flex-col">
            <div class="pt-3 flex flex-col h-full">
                <h5 class="text-2xl font-bold text-gray-800 mb-6 text-center">Dashboard CS</h5>
                <ul class="flex flex-col space-y-2 flex-grow">
                    <li class="nav-item">
                        <a class="block py-3 px-4 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-red-600 transition duration-300 flex items-center {{ request()->is('cs/data-penitip*') ? 'bg-gray-800 text-white hover:bg-gray-700 hover:text-white' : '' }}" href="{{ route('cs.penitip.index') }}">
                            <i class="fas fa-database mr-3 text-lg"></i>
                            Data Penitip
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="block py-3 px-4 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-red-600 transition duration-300 flex items-center {{ request()->is('dashboard/cs') ? 'bg-gray-800 text-white hover:bg-gray-700 hover:text-white' : '' }}" href="{{ route('dashboard.cs') }}">
                            <i class="fas fa-check-circle mr-3 text-lg"></i>
                            Verifikasi Pembayaran
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="block py-3 px-4 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-red-600 transition duration-300 flex items-center {{ request()->is('cs/merchandise*') ? 'bg-gray-800 text-white hover:bg-gray-700 hover:text-white' : '' }}" href="{{ route('cs.merchandise.index') }}">
                            <i class="fas fa-gift mr-3 text-lg"></i>
                            Merchandise
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

        {{-- Konten Utama --}}
        <main class="flex-grow p-8 bg-white rounded-xl shadow-lg border border-gray-200 mt-8 md:mt-0 md:ml-8 mx-4 md:mx-0">
            {{-- Header & Back to Dashboard --}}
            <div class="flex justify-between items-center mb-6 border-b border-gray-200 pb-4">
                <h1 class="text-3xl font-bold text-gray-800 border-l-4 border-red-600 pl-4 leading-tight">Daftar Klaim Merchandise Pembeli</h1>
            </div>

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

            <div class="overflow-x-auto rounded-lg border border-gray-200 mt-4">
                <table class="w-full text-sm leading-normal">
                    <thead class="bg-gray-800 text-white uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-6 py-3 text-left">Nama Pembeli</th>
                            <th class="px-6 py-3 text-left">Nama Merchandise</th>
                            <th class="px-6 py-3 text-left">Tanggal Ambil</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            <th class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($klaimMerchandise as $klaim)
                            <tr class="border-b border-gray-200 {{ $loop->iteration % 2 == 0 ? 'bg-gray-50' : 'bg-white' }} hover:bg-gray-100">
                                <td class="px-6 py-4">{{ $klaim->pembeli->nama_pembeli ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $klaim->merchandise->nama_merchandise ?? 'N/A' }}</td>
                                <td class="px-6 py-4">
                                    @if ($klaim->tanggal_ambil_merchandise)
                                        {{ \Carbon\Carbon::parse($klaim->tanggal_ambil_merchandise)->format('d M Y') }}
                                    @else
                                        <span class="text-gray-500 italic">Belum Ada</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                        @if($klaim->status_merchandise == 'diambil') bg-green-100 text-green-800
                                        @elseif($klaim->status_merchandise == 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($klaim->status_merchandise) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if (!$klaim->tanggal_ambil_merchandise)
                                        <button type="button" class="px-4 py-2 bg-gray-800 text-white rounded-lg font-semibold text-sm hover:bg-gray-700 transition duration-300 shadow-sm btnFillDate" data-id="{{ $klaim->id_pembeli_merchandise }}">
                                            Isi Tanggal Ambil
                                        </button>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                            Sudah Diambil
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-600 italic">Tidak ada data klaim merchandise.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>

{{-- Tutup @section('content') di sini --}}
@endsection

{{-- PUSH MODALS KE DALAM STACK 'modals' DI LAYOUTS/APP.BLADE.PHP --}}
@push('modals')
    <div id="fillDateConfirmModal" class="modal-overlay hidden opacity-0 pointer-events-none">
        <div class="modal-container">
            <form id="formFillDate" method="POST">
                @csrf
                @method('PUT') {{-- Asumsi ini adalah operasi update, jadi gunakan PUT --}}
                <div class="modal-header">
                    <h5 class="text-xl font-semibold" id="fillDateConfirmModalLabel">Konfirmasi Pengambilan</h5>
                    <button type="button" class="text-gray-500 hover:text-gray-700 text-2xl" onclick="closeModal('fillDateConfirmModal')">&times;</button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin mengisi tanggal pengambilan untuk merchandise ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-300" onclick="closeModal('fillDateConfirmModal')">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">Ya, Isi</button>
                </div>
            </form>
        </div>
    </div>
@endpush

{{-- PUSH SCRIPT TAMBAHAN KE DALAM STACK 'scripts' DI LAYOUTS/APP.BLADE.PHP --}}
@push('scripts')
    <script>
        // Custom Modal Functions
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
            // Handle fill date button confirmation
            document.querySelectorAll('.btnFillDate').forEach(button => {
                button.addEventListener('click', function () {
                    const claimId = this.dataset.id;
                    const fillDateForm = document.getElementById('formFillDate');
                    // Pastikan rute ini benar. Jika Anda mengupdate status, biasanya menggunakan PUT/PATCH.
                    // Contoh: /cs/merchandise/{id}/update-status
                    fillDateForm.action = `/cs/merchandise/${claimId}`;
                    showModal('fillDateConfirmModal');
                });
            });
        });
    </script>
@endpush