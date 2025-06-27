@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6"> {{-- container menjadi container mx-auto px-4 py-6 --}}
    <div class="mb-6"> {{-- mb-3 menjadi mb-6 untuk spacing yang lebih besar --}}
        <a href="{{ route('dashboard.owner') }}" class="inline-block px-6 py-2 border border-gray-800 text-gray-800 rounded-lg text-sm hover:bg-gray-800 hover:text-white transition-colors duration-200"> {{-- btn btn-dark --}}
            &larr; Kembali ke Dashboard
        </a>
    </div>

    <h4 class="text-2xl font-bold mb-6 text-gray-900">Riwayat Donasi Berdasarkan Organisasi</h4> {{-- h4 mb-4 --}}

    <form action="{{ route('owner.historyFiltered') }}" method="POST" class="flex flex-wrap -mx-2 mb-6 items-end"> {{-- row g-3 mb-4 menjadi flex flex-wrap -mx-2 mb-6 items-end --}}
        @csrf
        <div class="w-full md:w-1/2 px-2 mb-4 md:mb-0"> {{-- col-md-6 menjadi w-full md:w-1/2 px-2 --}}
            <label for="id_organisasi" class="block text-gray-700 text-sm font-bold mb-2">Pilih Organisasi:</label> {{-- form-label --}}
            <select name="id_organisasi" id="id_organisasi" class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-red-500" required> {{-- form-select --}}
                <option value="">-- Pilih Organisasi --</option>
                @foreach($organisasiList as $org)
                    <option value="{{ $org->id_organisasi }}"
                        {{ (isset($organisasi) && $organisasi->id_organisasi == $org->id_organisasi) ? 'selected' : '' }}>
                        {{ $org->nama_organisasi }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="w-full md:w-1/6 px-2"> {{-- col-md-2 align-self-end menjadi w-full md:w-1/6 px-2 --}}
            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded w-full transition-colors duration-200">Tampilkan</button> {{-- btn btn-dark w-100 --}}
        </div>
    </form>

    @isset($donasiList)
        <div class="mb-4 text-xl font-semibold text-gray-800"> {{-- mb-3 h5 --}}
            Riwayat Donasi ke:
            <strong class="text-red-600">{{ $organisasi->nama_organisasi }}</strong> {{-- Menambahkan warna merah untuk nama organisasi --}}
        </div>

        @if($donasiList->isEmpty())
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert"> {{-- alert alert-warning --}}
                Belum ada donasi untuk organisasi ini.
            </div>
        @else
            <div class="overflow-x-auto shadow-md rounded-lg"> {{-- table-responsive dan shadow --}}
                <table class="min-w-full divide-y divide-gray-200 border border-gray-300"> {{-- table table-bordered table-striped align-middle --}}
                    <thead class="bg-gray-50"> {{-- table-light --}}
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Barang</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Penerima</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Donasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Barang</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($donasiList as $donasi)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $donasi->barang->nama_barang }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $donasi->nama_penerima }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($donasi->tanggal_donasi)->format('d M Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $donasi->barang->status_barang }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <a href="{{ route('owner.edit', $donasi->id_donasi) }}"
                                       class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded text-sm transition-colors duration-200"> {{-- btn btn-sm btn-warning --}}
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endisset
</div>
@endsection