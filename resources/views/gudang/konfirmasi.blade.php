@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8"> {{-- Tailwind container for central alignment and padding --}}
    <h2 class="text-3xl font-bold mb-6 text-gray-800">Konfirmasi Pengambilan</h2> {{-- Tailwind heading styling --}}

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

    <div class="bg-white rounded-lg shadow-md overflow-hidden"> {{-- Tailwind card styling for the table container --}}
        <div class="p-0 overflow-x-auto"> {{-- Tailwind card-body p-0 and table-responsive --}}
            <table class="min-w-full bg-white"> {{-- Tailwind table --}}
                <thead class="bg-gray-100"> {{-- Tailwind table-light --}}
                    <tr>
                        <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">Nomor Transaksi</th>
                        <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">Tanggal</th>
                        <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">Nama Pembeli</th>
                        <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">Nama Barang</th>
                        <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">Total Harga</th>
                        <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $transaksi)
                        <tr class="hover:bg-gray-50"> {{-- Tailwind table hover effect --}}
                            <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ $transaksi->id_transaksi }}</td> {{-- Changed to id_transaksi --}}
                            <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ date('d/m/Y', strtotime($transaksi->tanggal_transaksi)) }}</td> {{-- Formatted date --}}
                            <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ optional($transaksi->pembeli)->nama_pembeli ?? '-' }}</td> {{-- Changed to nama_pembeli --}}
                            <td class="py-2 px-4 border-b border-gray-200 text-sm">
                                <ul class="list-disc list-inside space-y-0.5"> {{-- Tailwind list styling --}}
                                    @foreach($transaksi->transaksiBarang as $transaksiBarang) {{-- Changed to transaksiBarang --}}
                                        <li>{{ optional($transaksiBarang->barang)->nama_barang ?? 'N/A' }} ({{ $transaksiBarang->jumlah }})</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm"><span class="bg-yellow-400 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">{{ $transaksi->status_transaksi }}</span></td> {{-- Tailwind badge --}}
                            <td class="py-2 px-4 border-b border-gray-200 text-sm">
                                <!-- Button trigger modal -->
                                <button type="button" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50" data-bs-toggle="modal" data-bs-target="#konfirmasiModal{{ $transaksi->id_transaksi }}">
                                    Konfirmasi
                                </button>

                                <!-- Modal -->
                                <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-800 bg-opacity-75 transition-opacity duration-300 ease-in-out hidden" id="konfirmasiModal{{ $transaksi->id_transaksi }}" tabindex="-1" aria-labelledby="modalLabel{{ $transaksi->id_transaksi }}" aria-hidden="true">
                                    <div class="relative bg-white rounded-lg shadow-xl max-w-sm mx-auto w-full transform transition-all duration-300 ease-in-out scale-95 opacity-0"> {{-- Tailwind modal-dialog --}}
                                        <form action="{{ route('gudang.konfirmasi.konfirmasi', $transaksi->id_transaksi) }}" method="POST">
                                            @csrf
                                            <div class="flex items-center justify-between p-4 border-b border-gray-200 bg-green-600 text-white rounded-t-lg"> {{-- Tailwind modal-header bg-success --}}
                                                <h5 class="text-xl font-semibold text-white" id="modalLabel{{ $transaksi->id_transaksi }}">Konfirmasi Pengambilan</h5>
                                                <button type="button" class="text-white hover:text-gray-200 text-2xl leading-none" data-bs-dismiss="modal" aria-label="Tutup">&times;</button> {{-- Tailwind btn-close --}}
                                            </div>
                                            <div class="p-6 text-gray-700"> {{-- Tailwind modal-body --}}
                                                Apakah Anda yakin ingin mengubah status transaksi menjadi "Diambil"?
                                            </div>
                                            <div class="flex justify-end p-4 border-t border-gray-200 space-x-3"> {{-- Tailwind modal-footer --}}
                                                <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200">Ya, Konfirmasi</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-4 text-center text-gray-600">Tidak ada transaksi yang menunggu pengambilan.</td> {{-- Adjusted colspan --}}
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
