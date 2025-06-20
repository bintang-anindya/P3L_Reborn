@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8"> {{-- Tailwind container for central alignment and padding --}}
    <div class="mb-6"> {{-- Replaced row mb-4 --}}
        <div class="w-full"> {{-- Replaced col --}}
            <h2 class="text-3xl font-bold text-gray-800">Daftar Transaksi Sedang Disiapkan</h2> {{-- Tailwind heading styling --}}
        </div>
    </div>

    <div class="flex justify-start mb-6"> {{-- Replaced d-flex justify-content-start mb-3 --}}
        <form action="{{ route('dashboard.gudang') }}" method="GET">
            <button class="inline-flex items-center bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50"> {{-- Tailwind button styling --}}
                <i class="fas fa-home mr-2"></i> Kembali ke Dashboard
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert"> {{-- Tailwind alert success --}}
            {{ session('success') }}
        </div>
    @endif

    @if($transactions->isEmpty())
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert"> {{-- Tailwind alert info --}}
            <i class="fas fa-info-circle mr-2"></i> Tidak ada transaksi yang sedang disiapkan.
        </div>
    @else
        <div class="grid grid-cols-1 gap-6"> {{-- Replaced row --}}
            @foreach($transactions as $transaction)
                <div class="w-full"> {{-- Replaced col-md-12 mb-4 --}}
                    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-4 transition-transform duration-200 hover:scale-[1.005]"> {{-- Tailwind card styling with hover effect --}}
                        <!-- Card Header -->
                        <div class="bg-black text-white px-6 py-4 font-semibold flex justify-between items-center rounded-t-lg"> {{-- Tailwind card-header bg-primary text-white --}}
                            <div>
                                <h5 class="text-xl font-bold mb-1">Transaksi #{{ $transaction->id_transaksi }}</h5>
                                <small class="text-sm text-blue-100">{{ date('d F Y', strtotime($transaction->tanggal_transaksi)) }}</small>
                            </div>
                            <span class="bg-yellow-400 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold"> {{-- Tailwind badge bg-warning text-dark --}}
                                <i class="fas fa-hourglass-half mr-1"></i> {{ ucfirst($transaction->metode) }}
                            </span>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6"> {{-- Tailwind card-body --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6"> {{-- Replaced row row-cols-1 row-cols-md-2 g-4 --}}
                                @foreach($transaction->transaksiBarang as $transaksiBarang)
                                    @php
                                        $barang = $transaksiBarang->barang;
                                    @endphp
                                    <div class="w-full"> {{-- Replaced col --}}
                                        <div class="bg-white rounded-lg shadow-sm overflow-hidden h-full"> {{-- Tailwind card h-100 border-0 shadow-sm --}}
                                            <div class="flex flex-wrap"> {{-- Replaced row g-0 --}}
                                                <div class="w-full md:w-1/3"> {{-- Replaced col-md-4 --}}
                                                    <img src="{{ asset('storage/' . ($barang->gambar_barang ?? 'default-product.png')) }}" alt="Gambar Barang" class="w-full h-32 object-cover rounded-l-lg md:rounded-tr-none rounded-t-lg"> {{-- Tailwind img with object-cover --}}
                                                </div>
                                                <div class="w-full md:w-2/3"> {{-- Replaced col-md-8 --}}
                                                    <div class="p-4"> {{-- Tailwind card-body --}}
                                                        <h6 class="text-lg font-semibold text-gray-800 mb-2">{{ $barang->nama_barang ?? 'Produk' }}</h6>
                                                        <div class="flex justify-between items-center"> {{-- Replaced d-flex justify-content-between --}}
                                                            <p class="text-gray-700 mb-0"> {{-- Tailwind card-text mb-1 --}}
                                                                Rp {{ number_format($barang->harga_barang, 0, ',', '.') }}
                                                            </p>
                                                            <p class="text-gray-500 text-sm mb-0"> {{-- Tailwind card-text mb-1 small text-muted --}}
                                                                x{{ $transaksiBarang->jumlah }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Card Footer dengan Tombol Aksi -->
                        <div class="bg-gray-100 p-4 rounded-b-lg"> {{-- Tailwind card-footer bg-light --}}
                            <div class="flex justify-between items-center"> {{-- Replaced d-flex justify-content-between align-items-center --}}
                                <div>
                                    <span class="font-bold text-gray-700">Total:</span> {{-- Tailwind fw-bold --}}
                                    <span class="text-xl font-bold ml-2 text-gray-800">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</span> {{-- Tailwind fs-5 ms-2 --}}
                                </div>
                                <div class="flex items-center space-x-3"> {{-- Replaced d-flex gap-2 align-items-center position-relative --}}
                                    <!-- Tombol Detail -->
                                    <button class="bg-blue-500 hover:bg-blue-600 text-white text-sm py-2 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" data-bs-toggle="modal" data-bs-target="#detailModal-{{ $transaction->id_transaksi }}"> {{-- Tailwind btn btn-sm btn-outline-primary --}}
                                        <i class="fas fa-eye mr-1"></i> Detail
                                    </button>
                                    
                                    <!-- Tombol Ambil -->
                                    <button class="bg-green-500 hover:bg-green-600 text-white text-sm py-2 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50" data-bs-toggle="modal" data-bs-target="#pengambilanModal-{{ $transaction->id_transaksi }}"> {{-- Tailwind btn btn-sm btn-success --}}
                                        <i class="fas fa-box-open mr-1"></i> Ambil
                                    </button>
                                    <!-- Tombol Dikirim -->
                                    <button class="bg-purple-600 hover:bg-purple-700 text-white text-sm py-2 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50" data-bs-toggle="modal" data-bs-target="#pengirimanModal-{{ $transaction->id_transaksi }}"> {{-- Tailwind btn btn-sm btn-primary --}}
                                        <i class="fas fa-truck mr-1"></i> Dikirim
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Detail -->
                {{-- Modals still use Bootstrap JS for functionality, but styling is Tailwind --}}
                <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-800 bg-opacity-75 transition-opacity duration-300 ease-in-out hidden" id="detailModal-{{ $transaction->id_transaksi }}" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                    <div class="relative bg-white rounded-lg shadow-xl max-w-4xl mx-auto w-full transform transition-all duration-300 ease-in-out scale-95 opacity-0"> {{-- Tailwind modal-dialog modal-lg --}}
                        <div class="flex items-center justify-between p-4 border-b border-gray-200 bg-blue-600 text-white rounded-t-lg"> {{-- Tailwind modal-header bg-primary --}}
                            <h5 class="text-xl font-semibold text-white" id="detailModalLabel">
                                Detail Transaksi #{{ $transaction->id_transaksi }}
                            </h5>
                            <button type="button" class="text-white hover:text-gray-200 text-2xl leading-none" data-bs-dismiss="modal" aria-label="Close">&times;</button> {{-- Tailwind btn-close --}}
                        </div>
                        <div class="p-6"> {{-- Tailwind modal-body --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4"> {{-- Tailwind row --}}
                                <div class="w-full"> {{-- Tailwind col-md-6 --}}
                                    <p class="mb-2"><strong class="font-semibold text-gray-700">Tanggal Transaksi:</strong> {{ date('d F Y', strtotime($transaction->tanggal_transaksi)) }}</p>
                                    <p class="mb-2"><strong class="font-semibold text-gray-700">Status:</strong>
                                        <span class="bg-yellow-400 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold ml-2"> {{-- Tailwind badge bg-warning --}}
                                            {{ ucfirst($transaction->status_transaksi) }}
                                        </span>
                                    </p>
                                    <p class="mb-0"><strong class="font-semibold text-gray-700">Total Harga:</strong> <span class="text-lg font-bold">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</span></p>
                                </div>
                                <div class="w-full"> {{-- Tailwind col-md-6 --}}
                                    <p class="mb-2"><strong class="font-semibold text-gray-700">Metode Pengambilan:</strong> {{ $transaction->metode }}</p>
                                    <p class="mb-0"><strong class="font-semibold text-gray-700">Pembeli:</strong> {{ $transaction->pembeli->nama_pembeli ?? 'Tidak diketahui' }}</p>
                                </div>
                            </div>

                            <hr class="my-6 border-gray-200"> {{-- Tailwind hr --}}

                            <h5 class="text-xl font-bold mb-4 text-gray-800">Daftar Barang</h5> {{-- Tailwind h5 mb-3 --}}
                            <div class="overflow-x-auto"> {{-- Tailwind table-responsive --}}
                                <table class="min-w-full bg-white border border-gray-300"> {{-- Tailwind table table-striped --}}
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">Gambar</th>
                                            <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">Nama Barang</th>
                                            <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">Berat (kg)</th>
                                            <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">Harga Satuan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transaction->transaksiBarang as $transaksiBarang)
                                            @php
                                                $barang = $transaksiBarang->barang;
                                                $subtotal = $transaksiBarang->total_harga;
                                            @endphp
                                            <tr class="hover:bg-gray-50">
                                                <td class="py-2 px-4 border-b border-gray-200 text-sm">
                                                    <img src="{{ asset('storage/' . ($barang->gambar_barang ?? 'default-product.png')) }}" class="w-16 h-16 object-cover rounded-md shadow-sm border border-gray-200" alt="Gambar Barang"> {{-- Tailwind img --}}
                                                </td>
                                                <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ $barang->nama_barang }}</td>
                                                <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ $barang->berat }} kg</td> {{-- Added kg --}}
                                                <td class="py-2 px-4 border-b border-gray-200 text-sm">Rp {{ number_format($barang->harga_barang, 0, ',', '.') }}</td> {{-- Formatted price --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="flex justify-end p-4 border-t border-gray-200"> {{-- Tailwind modal-footer --}}
                            <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>

                <!-- Modal Pengambilan -->
                <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-800 bg-opacity-75 transition-opacity duration-300 ease-in-out hidden" id="pengambilanModal-{{ $transaction->id_transaksi }}" tabindex="-1" aria-labelledby="pengambilanModalLabel" aria-hidden="true">
                    <div class="relative bg-white rounded-lg shadow-xl max-w-lg mx-auto w-full transform transition-all duration-300 ease-in-out scale-95 opacity-0"> {{-- Tailwind modal-dialog --}}
                        <div class="flex items-center justify-between p-4 border-b border-gray-200 bg-green-600 text-white rounded-t-lg"> {{-- Tailwind modal-header bg-success --}}
                            <h5 class="text-xl font-semibold text-white" id="pengambilanModalLabel">
                                Konfirmasi Pengambilan #{{ $transaction->id_transaksi }}
                            </h5>
                            <button type="button" class="text-white hover:text-gray-200 text-2xl leading-none" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                        </div>
                        <form action="{{ route('gudang.daftarTransaksi.diambil', $transaction->id_transaksi) }}" method="POST">
                            @csrf
                            <div class="p-6"> {{-- Tailwind modal-body --}}
                                <div class="mb-4"> {{-- Tailwind mb-3 --}}
                                    <label for="tanggal_ambil" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Pengambilan</label>
                                    <input type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-red-500" id="tanggal_ambil" name="tanggal_ambil" min="{{ date('Y-m-d') }}" required>
                                    <p class="text-xs text-gray-500 mt-1">Pilih tanggal pengambilan (tidak boleh sebelum hari ini)</p> {{-- Tailwind form-text --}}
                                </div>
                            </div>
                            <div class="flex justify-end p-4 border-t border-gray-200 space-x-3"> {{-- Tailwind modal-footer --}}
                                <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200">
                                    <i class="fas fa-check-circle mr-1"></i> Konfirmasi Pengambilan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Pengiriman -->
                <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-800 bg-opacity-75 transition-opacity duration-300 ease-in-out hidden" id="pengirimanModal-{{ $transaction->id_transaksi }}" tabindex="-1" aria-labelledby="pengirimanModalLabel" aria-hidden="true">
                    <div class="relative bg-white rounded-lg shadow-xl max-w-lg mx-auto w-full transform transition-all duration-300 ease-in-out scale-95 opacity-0"> {{-- Tailwind modal-dialog --}}
                        <div class="flex items-center justify-between p-4 border-b border-gray-200 bg-blue-600 text-white rounded-t-lg"> {{-- Tailwind modal-header bg-primary --}}
                            <h5 class="text-xl font-semibold text-white" id="pengirimanModalLabel">
                                Atur Pengiriman #{{ $transaction->id_transaksi }}
                            </h5>
                            <button type="button" class="text-white hover:text-gray-200 text-2xl leading-none" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                        </div>
                        <form action="{{ route('gudang.daftarTransaksi.dikirim', $transaction->id_transaksi) }}" method="POST">
                            @csrf
                            <div class="p-6"> {{-- Tailwind modal-body --}}
                                <div class="mb-4"> {{-- Tailwind mb-3 --}}
                                    <label for="tanggal_pengiriman" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Pengiriman</label>
                                    <input type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-red-500" id="tanggal_pengiriman" name="tanggal_pengiriman" min="{{ date('Y-m-d') }}" required>
                                    <p class="text-xs text-gray-500 mt-1">Pilih tanggal pengiriman (tidak boleh sebelum hari ini)</p> {{-- Tailwind form-text --}}
                                </div>
                                <div class="mb-4"> {{-- Tailwind mb-3 --}}
                                    <label for="id_kurir" class="block text-gray-700 text-sm font-bold mb-2">Kurir</label>
                                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-red-500" id="id_kurir" name="id_kurir" required> {{-- Tailwind form-select --}}
                                        <option value="" selected disabled>Pilih Kurir</option>
                                        @foreach($kurirs as $kurir)
                                            <option value="{{ $kurir->id_pegawai }}">
                                                {{ $kurir->nama_pegawai }} ({{ $kurir->nomor_telepon }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="flex justify-end p-4 border-t border-gray-200 space-x-3"> {{-- Tailwind modal-footer --}}
                                <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200">
                                    <i class="fas fa-check-circle mr-1"></i> Konfirmasi Pengiriman
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    /* Custom styles for image and table within modals if not fully covered by Tailwind */
    /* Ensuring img inside modal table cells have a consistent size */
    .modal-body .min-w-full img {
        width: 4rem; /* 64px */
        height: 4rem; /* 64px */
        object-fit: cover;
    }
</style>
@endpush

@push('scripts')
<script>
    // Set minimum date for date inputs
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        document.querySelectorAll('input[type="date"]').forEach(input => {
            input.min = today;
        });
    });

    // You would still need Bootstrap's JS or a custom JS solution for these modals to function
    // For example, if you remove Bootstrap's JS, you'd need to manually control the 'hidden' class
    // and 'opacity/scale' based on click events.
    // Here's a conceptual example for opening a modal using pure JS (you'd need similar for closing):
    /*
    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
        button.addEventListener('click', function() {
            const targetModalId = this.dataset.bsTarget;
            const modalElement = document.querySelector(targetModalId);
            if (modalElement) {
                modalElement.classList.remove('hidden');
                modalElement.querySelector('.relative').classList.remove('opacity-0', 'scale-95');
                modalElement.querySelector('.relative').classList.add('opacity-100', 'scale-100');
            }
        });
    });
    */
</script>
@endpush