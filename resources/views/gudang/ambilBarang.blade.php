@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8"> {{-- Tailwind container for central alignment and padding --}}
    <h2 class="text-3xl font-bold mb-6 text-gray-800">Daftar Barang Expired</h2> {{-- Tailwind heading styling --}}

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

    <div class="bg-white rounded-lg shadow-md overflow-hidden"> {{-- Tailwind card styling --}}
        <div class="p-6 overflow-x-auto"> {{-- Tailwind card-body and table-responsive equivalent --}}
            <table class="min-w-full bg-white border border-gray-300"> {{-- Tailwind table styling --}}
                <thead class="bg-gray-100"> {{-- Tailwind table-light --}}
                    <tr>
                        <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">Nama Barang</th>
                        <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">Tanggal Masuk</th>
                        <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">Tenggat Waktu</th>
                        <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">Nama Penitip</th>
                        <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($barang_expired) && $barang_expired->count() > 0)
                        @foreach($barang_expired as $barang)
                        <tr class="hover:bg-gray-50"> {{-- Hover effect for table rows --}}
                            <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ $barang->nama_barang }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ $barang->tanggal_masuk }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm {{ $barang->tenggat_waktu < now() ? 'text-red-500 font-semibold' : '' }}"> {{-- Tailwind text-danger --}}
                                {{ $barang->tenggat_waktu }}
                            </td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ optional(optional($barang->penitipan)->penitip)->nama_penitip ?? '-' }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm">
                                <form action="{{ route('gudang.ambilBarang.ambil', $barang->id_barang) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white text-sm py-1 px-3 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"> {{-- Tailwind btn btn-primary btn-sm --}}
                                        Ambil
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="py-4 text-center text-gray-600">Tidak ada barang expired.</td> {{-- Adjusted colspan --}}
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
