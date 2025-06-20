@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8"> {{-- Tailwind container for central alignment and padding --}}
    <div class="flex flex-wrap items-center justify-between mb-6"> {{-- Replaced row mb-4 and added flex utilities --}}
        <div class="w-full md:w-auto mb-4 md:mb-0"> {{-- Replaced col --}}
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Daftar Transaksi Siap Cetak Nota</h2> {{-- Tailwind heading styling and added margin-bottom --}}
            
            <div class="flex justify-start mb-4"> {{-- Replaced d-flex justify-content-start mb-3 --}}
                <form action="{{ route('dashboard.gudang') }}" method="GET">
                    <button class="inline-flex items-center bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50"> {{-- Tailwind button styling --}}
                        <i class="fas fa-home mr-2"></i> Kembali ke Dashboard
                    </button>
                </form>
            </div>
            <div class="flex items-center space-x-3"> {{-- Replaced d-flex align-items-center --}}
                <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-semibold">Dikirim</span> {{-- Tailwind badge bg-primary --}}
                <span class="bg-green-600 text-white px-3 py-1 rounded-full text-xs font-semibold">Selesai</span> {{-- Tailwind badge bg-success --}}
            </div>
        </div>
        <div class="w-full md:w-auto"> {{-- Replaced col-auto --}}
            <a href="{{ route('dashboard.gudang') }}" class="inline-flex items-center bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50"> {{-- Tailwind button styling --}}
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </div>

    @if($transactions->isEmpty())
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert"> {{-- Tailwind alert info --}}
            <i class="fas fa-info-circle mr-2"></i>Tidak ada transaksi yang siap dicetak.
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md overflow-hidden"> {{-- Tailwind card shadow-sm --}}
            <div class="p-0 overflow-x-auto"> {{-- Tailwind card-body p-0 and table-responsive --}}
                <table class="min-w-full bg-white"> {{-- Tailwind table table-hover mb-0 --}}
                    <thead class="bg-gray-100"> {{-- Tailwind table-light --}}
                        <tr>
                            <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700 w-28">ID Transaksi</th> {{-- Added Tailwind width --}}
                            <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700 w-32">Tanggal</th> {{-- Added Tailwind width --}}
                            <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">Pembeli</th>
                            <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700 w-32">Status</th> {{-- Added Tailwind width --}}
                            <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700 w-40">Total</th> {{-- Added Tailwind width --}}
                            <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700 w-32">Metode</th> {{-- Added Tailwind width --}}
                            <th class="py-3 px-4 border-b text-center text-sm font-semibold text-gray-700 w-32">Aksi</th> {{-- Added Tailwind width and text-center --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr class="hover:bg-gray-50"> {{-- Tailwind table-hover --}}
                            <td class="py-2 px-4 border-b border-gray-200 text-sm font-medium">#{{ $transaction->id_transaksi }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ date('d/m/Y', strtotime($transaction->tanggal_transaksi)) }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ $transaction->pembeli->nama_pembeli ?? '-' }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm">
                                @if($transaction->status_transaksi === 'dikirim')
                                    <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-semibold"> {{-- Tailwind badge bg-primary --}}
                                        <i class="fas fa-truck mr-1"></i> Dikirim
                                    </span>
                                @else
                                    <span class="bg-green-600 text-white px-3 py-1 rounded-full text-xs font-semibold"> {{-- Tailwind badge bg-success --}}
                                        <i class="fas fa-check-circle mr-1"></i> Selesai
                                    </span>
                                @endif
                            </td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm font-semibold">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td> {{-- Added font-semibold --}}
                            <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ ucfirst($transaction->metode) }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-center"> {{-- Tailwind text-center --}}
                                <a href="{{ route('gudang.cetak.pdf', $transaction->id_transaksi) }}" 
                                   class="inline-flex items-center justify-center bg-red-600 hover:bg-red-700 text-white w-8 h-8 rounded-lg text-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50" 
                                   title="Cetak Nota"
                                   target="_blank"> {{-- Tailwind btn btn-sm btn-danger --}}
                                    <i class="fas fa-file-pdf"></i> {{-- Replaced bi bi-file-earmark-pdf --}}
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    /* Custom styles that aren't easily replaced by single Tailwind classes */
    /* While Tailwind has hover:bg-*, this ensures the exact shade from the original */
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02); /* Very light grey */
    }

    /* Override Tailwind's default badge padding if needed, or ensure consistency */
    /* Tailwind's px-3 py-1 rounded-full provides a good badge look */
    /* .badge { padding: 0.35em 0.65em; font-size: 0.75em; font-weight: 500; } */

    /* Small button size for actions, ensuring icon is centered */
    /* Tailwind's w-8 h-8 rounded-lg text-sm and flex justify-center items-center replaces btn-sm */
    /* .btn-sm { width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; padding: 0; } */
</style>
@endpush
