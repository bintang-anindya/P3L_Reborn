@extends('layouts.app')

@section('content')
{{-- Hapus tag <!DOCTYPE html>, <html>, <head>, dan <body> dari sini --}}
{{-- Karena sudah di-handle oleh layouts/app.blade.php --}}

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
        max-width: 24rem; /* Sesuaikan ukuran modal jika perlu, misal max-w-lg untuk lebih lebar */
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

    <main class="flex-grow p-8 bg-white rounded-xl shadow-lg border border-gray-200 mt-8 md:mt-0 md:ml-8 mx-4 md:mx-0">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 border-l-4 border-red-600 pl-4 leading-tight">Daftar Transaksi Menunggu Validasi</h2>

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

        @if($transaksis->isEmpty())
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg shadow-sm">
                Tidak ada transaksi yang menunggu validasi.
            </div>
        @else
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="w-full text-sm leading-normal">
                    <thead class="bg-gray-800 text-white uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-6 py-3 text-left">No</th>
                            <th class="px-6 py-3 text-left">Nomor Transaksi</th>
                            <th class="px-6 py-3 text-left">Nama Pembeli</th>
                            <th class="px-6 py-3 text-left">Total Harga</th>
                            <th class="px-6 py-3 text-left">Bukti Transaksi</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            <th class="px-6 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksis as $index => $transaksi)
                            <tr class="border-b border-gray-200 {{ $loop->iteration % 2 == 0 ? 'bg-gray-50' : 'bg-white' }} hover:bg-gray-100">
                                <td class="px-6 py-4">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">{{ $transaksi->nomor_transaksi }}</td>
                                <td class="px-6 py-4">{{ $transaksi->pembeli->nama_pembeli }}</td>
                                <td class="px-6 py-4">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    @if($transaksi->bukti_transaksi)
                                        <a href="{{ asset($transaksi->bukti_transaksi) }}" target="_blank" class="block w-24 h-24 overflow-hidden rounded-md border border-gray-300 hover:border-blue-500 transition duration-300">
                                            <img src="{{ asset($transaksi->bukti_transaksi) }}" alt="Bukti Transaksi" class="w-full h-full object-cover">
                                        </a>
                                    @else
                                        <span class="text-gray-500 italic">Belum ada</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                        @if($transaksi->status_transaksi == 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($transaksi->status_transaksi == 'valid') bg-green-100 text-green-800
                                        @elseif($transaksi->status_transaksi == 'dibatalkan') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($transaksi->status_transaksi) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 space-x-2">
                                    {{-- Tombol Valid --}}
                                    <button type="button" class="px-4 py-2 bg-green-600 text-white rounded-lg font-semibold text-sm hover:bg-green-700 transition duration-300 shadow-sm btnValidasi" data-id="{{ $transaksi->id_transaksi }}" data-action="valid">
                                        Valid
                                    </button>
                                    {{-- Tombol Tidak Valid --}}
                                    <button type="button" class="px-4 py-2 bg-red-600 text-white rounded-lg font-semibold text-sm hover:bg-red-700 transition duration-300 shadow-sm btnValidasi" data-id="{{ $transaksi->id_transaksi }}" data-action="invalid">
                                        Tidak Valid
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </main>
</div>

{{-- Tutup @section('content') di sini --}}
@endsection

{{-- PUSH MODALS KE DALAM STACK 'modals' DI LAYOUTS/APP.BLADE.PHP --}}
@push('modals')
    <div id="validasiConfirmModal" class="modal-overlay hidden opacity-0 pointer-events-none">
        <div class="modal-container">
            <form id="formValidasi" method="POST">
                @csrf
                {{-- Method akan diset dinamis (PUT atau POST) --}}
                <div class="modal-header">
                    <h5 class="text-xl font-semibold" id="validasiConfirmModalLabel">Konfirmasi Validasi Transaksi</h5>
                    <button type="button" class="text-gray-500 hover:text-gray-700 text-2xl" onclick="closeModal('validasiConfirmModal')">&times;</button>
                </div>
                <div class="modal-body">
                    <p id="validasiConfirmMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-300" onclick="closeModal('validasiConfirmModal')">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300" id="confirmValidasiBtn">Ya, Lanjutkan</button>
                </div>
            </form>
        </div>
    </div>
@endpush

{{-- PUSH SCRIPT TAMBAHAN KE DALAM STACK 'scripts' DI LAYOUTS/APP.BLADE.PHP --}}
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
            const validasiConfirmModal = document.getElementById('validasiConfirmModal');
            const validasiConfirmMessage = document.getElementById('validasiConfirmMessage');
            const formValidasi = document.getElementById('formValidasi');
            const confirmValidasiBtn = document.getElementById('confirmValidasiBtn');

            document.querySelectorAll('.btnValidasi').forEach(button => {
                button.addEventListener('click', function () {
                    const transaksiId = this.dataset.id;
                    const actionType = this.dataset.action; // 'valid' atau 'invalid'

                    let message = '';
                    let confirmButtonText = 'Ya, Validasi';
                    let formActionUrl = '';
                    let methodInput = document.querySelector('#formValidasi input[name="_method"]');

                    // Hapus input _method jika sudah ada, agar bisa diset ulang
                    if (methodInput) {
                        methodInput.remove();
                    }

                    if (actionType === 'valid') {
                        message = 'Apakah Anda yakin ingin memvalidasi transaksi ini? Transaksi akan dianggap selesai.';
                        confirmButtonText = 'Ya, Validasi';
                        formActionUrl = `/transaksi/validasi/${transaksiId}`; // Sesuaikan dengan route validasi Anda
                        formValidasi.method = 'POST'; // Menggunakan POST karena route Laravel biasanya menerima POST untuk update status
                    } else if (actionType === 'invalid') {
                        message = 'Apakah Anda yakin ingin membatalkan transaksi ini? Transaksi akan dianggap tidak valid.';
                        confirmButtonText = 'Ya, Batalkan';
                        formActionUrl = `/transaksi/cancelByCs/${transaksiId}`; // Sesuaikan dengan route pembatalan Anda
                        formValidasi.method = 'POST'; // Menggunakan POST
                        // Untuk pembatalan, seringkali juga menggunakan method POST untuk update status
                    }

                    validasiConfirmMessage.textContent = message;
                    confirmValidasiBtn.textContent = confirmButtonText;
                    formValidasi.action = formActionUrl;

                    showModal('validasiConfirmModal');
                });
            });
        });
    </script>
@endpush