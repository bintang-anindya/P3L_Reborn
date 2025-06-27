@extends('layouts.app')

{{-- Bagian konten utama halaman --}}
@section('content')
{{-- Perhatikan: Tag <head> dan <body> di dalam @section('content') ini akan diabaikan oleh Blade.
     Hanya konten di dalamnya yang akan disuntikkan ke @yield('content') di layouts/app.blade.php.
     Style yang spesifik untuk halaman ini lebih baik diletakkan di @push('styles') atau di file CSS terpisah. --}}

    <div class="flex flex-grow">
        {{-- Sidebar --}}
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
            {{-- Flash Message --}}
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

            {{-- Header & Back to Dashboard --}}
            <div class="flex justify-between items-center mb-6 border-b border-gray-200 pb-4">
                <h2 class="text-3xl font-bold text-gray-800 border-l-4 border-red-600 pl-4 leading-tight">Manajemen Data Penitip</h2>
            </div>

            {{-- Search --}}
            <form action="{{ route('cs.penitip.index') }}" method="GET" class="mb-6 flex">
                <div class="relative flex-grow">
                    <input type="text" name="keyword" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition duration-300" placeholder="Cari nama, username, atau NIK..." value="{{ request('keyword') }}">
                    <button type="submit" class="absolute right-0 top-0 mt-2 mr-3 text-gray-500 hover:text-red-500 transition duration-300">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

            {{-- Error from validation --}}
            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-sm mb-6">
                    <ul class="mb-0 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Tambah / Edit --}}
            <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-200 mb-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">{{ isset($penitip) ? 'Edit Penitip' : 'Tambah Penitip' }}</h3>
                <div class="card-body">
                    <form id="penitipForm" action="{{ isset($penitip) ? route('cs.penitip.update', $penitip->id_penitip) : route('cs.penitip.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(isset($penitip)) @method('PUT') @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="nama_penitip" class="block text-gray-700 text-sm font-medium mb-1">Nama Penitip</label>
                                <input type="text" name="nama_penitip" id="nama_penitip" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" value="{{ old('nama_penitip', $penitip->nama_penitip ?? '') }}" required>
                            </div>
                            <div>
                                <label for="username_penitip" class="block text-gray-700 text-sm font-medium mb-1">Username</label>
                                <input type="text" name="username_penitip" id="username_penitip" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" value="{{ old('username_penitip', $penitip->username_penitip ?? '') }}" required>
                            </div>
                            <div>
                                <label for="password_penitip" class="block text-gray-700 text-sm font-medium mb-1">Password {{ isset($penitip) ? '(Kosongkan jika tidak ingin mengubah)' : '' }}</label>
                                <input type="password" name="password_penitip" id="password_penitip" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" {{ isset($penitip) ? '' : 'required' }}>
                            </div>
                            <div>
                                <label for="nik" class="block text-gray-700 text-sm font-medium mb-1">NIK</label>
                                <input type="number" name="nik" id="nik" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" value="{{ old('nik', $penitip->nik ?? '') }}" required>
                            </div>
                            <div>
                                <label for="email_penitip" class="block text-gray-700 text-sm font-medium mb-1">Email</label>
                                <input type="email" name="email_penitip" id="email_penitip" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" value="{{ old('email_penitip', $penitip->email_penitip ?? '') }}">
                            </div>
                            <div>
                                <label for="no_telp_penitip" class="block text-gray-700 text-sm font-medium mb-1">No Telepon</label>
                                <input type="text" name="no_telp_penitip" id="no_telp_penitip" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" value="{{ old('no_telp_penitip', $penitip->no_telp_penitip ?? '') }}">
                            </div>
                            <div class="col-span-1 md:col-span-2">
                                <label for="foto_ktp" class="block text-gray-700 text-sm font-medium mb-1">Upload Foto KTP</label>
                                <input type="file" name="foto_ktp" id="foto_ktp" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200" accept="image/*" {{ isset($penitip) ? '' : 'required' }}>
                                @if(isset($penitip) && $penitip->foto_ktp)
                                    <small class="text-gray-500 mt-1 block">Abaikan jika tidak ingin mengganti. Gambar saat ini:</small>
                                    <img src="{{ asset('storage/' . $penitip->foto_ktp) }}" alt="KTP Saat Ini" class="mt-2 w-32 h-auto rounded-lg shadow-md border border-gray-300">
                                @endif
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 mt-6">
                            <button type="submit" class="px-6 py-3 rounded-lg font-semibold text-white shadow-md transition duration-300
                                {{ isset($penitip) ? 'bg-green-600 hover:bg-green-700' : 'bg-gray-800 hover:bg-gray-700' }}">
                                <i class="fas fa-save mr-2"></i>
                                {{ isset($penitip) ? 'Simpan Perubahan' : 'Tambah Penitip' }}
                            </button>
                            @if(isset($penitip))
                                <a href="{{ route('cs.penitip.index') }}" class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg font-semibold hover:bg-gray-300 transition duration-300 shadow-md">Batal</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tabel --}}
            <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-200">
                <h3 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">Daftar Penitip</h3>
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="w-full text-sm leading-normal">
                        <thead class="bg-gray-800 text-white uppercase text-xs tracking-wider">
                            <tr>
                                <th class="px-6 py-3 text-left">Nama</th>
                                <th class="px-6 py-3 text-left">Username</th>
                                <th class="px-6 py-3 text-left">NIK</th>
                                <th class="px-6 py-3 text-left">Email</th>
                                <th class="px-6 py-3 text-left">No Telp</th>
                                <th class="px-6 py-3 text-left">Poin</th>
                                <th class="px-6 py-3 text-left">Saldo</th>
                                <th class="px-6 py-3 text-left">Foto KTP</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penitips as $penitip)
                            <tr class="border-b border-gray-200 {{ $loop->iteration % 2 == 0 ? 'bg-gray-50' : 'bg-white' }} hover:bg-gray-100">
                                <td class="px-6 py-4">{{ $penitip->nama_penitip }}</td>
                                <td class="px-6 py-4">{{ $penitip->username_penitip }}</td>
                                <td class="px-6 py-4">{{ $penitip->nik }}</td>
                                <td class="px-6 py-4">{{ $penitip->email_penitip }}</td>
                                <td class="px-6 py-4">{{ $penitip->no_telp_penitip }}</td>
                                <td class="px-6 py-4">{{ $penitip->poin_penitip ?? 0 }}</td>
                                <td class="px-6 py-4">Rp{{ number_format($penitip->saldo_penitip ?? 0, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    @if($penitip->foto_ktp)
                                        <a href="{{ asset('storage/' . $penitip->foto_ktp) }}" target="_blank" class="block w-20 h-20 overflow-hidden rounded-md border border-gray-300 hover:border-blue-500 transition duration-300">
                                            <img src="{{ asset('storage/' . $penitip->foto_ktp) }}" alt="KTP" class="w-full h-full object-cover">
                                        </a>
                                    @else
                                        <span class="text-gray-500 italic">Belum ada</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center space-x-2">
                                    <a href="{{ route('cs.penitip.edit', $penitip->id_penitip) }}" class="inline-block px-4 py-2 bg-yellow-500 text-white rounded-lg font-semibold text-sm hover:bg-yellow-600 transition duration-300 shadow-sm">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <button type="button" class="inline-block px-4 py-2 bg-red-600 text-white rounded-lg font-semibold text-sm hover:bg-red-700 transition duration-300 shadow-sm btnDelete" data-id="{{ $penitip->id_penitip }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="px-6 py-4 text-center text-gray-600 italic">Belum ada data penitip.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-6 flex justify-center">
                    {{ $penitips->links('pagination::tailwind') }}
                </div>
            </div>
        </main>
    </div>

{{-- Tutup @section('content') di sini --}}
@endsection

{{-- PUSH MODALS KE DALAM STACK 'modals' DI LAYOUTS/APP.BLADE.PHP --}}
@push('modals')
    <div id="submitConfirmModal" class="modal-overlay hidden opacity-0 pointer-events-none">
        <div class="modal-container">
            <div class="modal-header">
                <h5 class="text-xl font-semibold" id="submitConfirmModalLabel">Konfirmasi Aksi</h5>
                <button type="button" class="text-gray-500 hover:text-gray-700 text-2xl" onclick="closeModal('submitConfirmModal')">&times;</button>
            </div>
            <div class="modal-body" id="submitConfirmModalBody"></div>
            <div class="modal-footer">
                <button type="button" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-300" onclick="closeModal('submitConfirmModal')">Batal</button>
                <button type="button" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300" id="confirmSubmitBtn">Ya, Lanjutkan</button>
            </div>
        </div>
    </div>

    <div id="deleteConfirmModal" class="modal-overlay hidden opacity-0 pointer-events-none">
        <div class="modal-container">
            <form id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="text-xl font-semibold" id="deleteConfirmModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="text-gray-500 hover:text-gray-700 text-2xl" onclick="closeModal('deleteConfirmModal')">&times;</button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data penitip ini? Tindakan ini tidak dapat dibatalkan.
                </div>
                <div class="modal-footer">
                    <button type="button" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-300" onclick="closeModal('deleteConfirmModal')">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-300">Ya, Hapus</button>
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
            const penitipForm = document.getElementById('penitipForm');
            const submitConfirmModal = document.getElementById('submitConfirmModal');
            const submitConfirmModalBody = document.getElementById('submitConfirmModalBody');
            const confirmSubmitBtn = document.getElementById('confirmSubmitBtn');
            const isEditMode = @json(isset($penitip));

            // Handle form submission confirmation
            penitipForm.addEventListener('submit', function (e) {
                e.preventDefault(); // Prevent default submission
                const message = isEditMode
                    ? 'Yakin ingin menyimpan perubahan data penitip ini?'
                    : 'Yakin ingin menambahkan data penitip baru?';
                submitConfirmModalBody.textContent = message;
                showModal('submitConfirmModal');

                // Attach event listener for the confirmation button inside the modal
                confirmSubmitBtn.onclick = function() {
                    closeModal('submitConfirmModal');
                    penitipForm.submit(); // Programmatically submit the form
                };
            });

            // Handle delete button confirmation
            document.querySelectorAll('.btnDelete').forEach(button => {
                button.addEventListener('click', function () {
                    const penitipId = this.dataset.id;
                    const deleteForm = document.getElementById('formDelete');
                    deleteForm.action = `/cs/data-penitip/${penitipId}`; // Sesuaikan dengan rute Laravel Anda
                    showModal('deleteConfirmModal');
                });
            });
        });
    </script>
@endpush