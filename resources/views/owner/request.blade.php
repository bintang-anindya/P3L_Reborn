@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6"> {{-- container menjadi container mx-auto px-4 py-6 --}}
    <div class="flex justify-between items-center mb-6"> {{-- d-flex justify-content-between align-items-center mb-4 --}}
        <h2 class="text-2xl font-bold text-gray-900">Permintaan Donasi</h2> {{-- h2 mb-0 --}}
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert"> {{-- alert alert-success --}}
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('dashboard.owner') }}" class="inline-block px-6 py-2 border border-gray-800 text-gray-800 rounded-lg text-sm hover:bg-gray-800 hover:text-white transition-colors duration-200 mb-6"> {{-- btn btn-outline-dark mb-3 --}}
        Kembali Ke Dashboard
    </a>

    @forelse($requests as $request)
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6"> {{-- card shadow-sm mb-4 border-0 --}}
            <div class="bg-gray-900 text-white px-4 py-3 font-semibold"> {{-- card-header bg-black text-white --}}
                <h5 class="text-xl font-semibold">{{ $request->organisasi->nama_organisasi }}</h5> {{-- h5 mb-0 --}}
            </div>
            <div class="p-4"> {{-- card-body --}}
                <p class="mb-4 text-gray-700"><strong>Keterangan:</strong> {{ $request->keterangan_request }}</p> {{-- p mb-3 --}}

                <form action="{{ route('donasi.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_request" value="{{ $request->id_request }}">

                    <div class="flex flex-wrap -mx-2 mb-4"> {{-- row mb-3 menjadi flex flex-wrap -mx-2 mb-4 --}}
                        <div class="w-full md:w-1/2 px-2 mb-4 md:mb-0"> {{-- col-md-6 menjadi w-full md:w-1/2 px-2 --}}
                            <label for="id_barang" class="block text-gray-700 text-sm font-bold mb-2">Pilih Barang Donasi:</label> {{-- form-label --}}
                            <select name="id_barang" class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-red-500" required> {{-- form-select --}}
                                <option value="">-- Pilih Barang --</option>
                                @foreach($barangLayak as $barang)
                                    <option value="{{ $barang->id_barang }}">
                                        {{ $barang->nama_barang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="w-full md:w-1/2 px-2"> {{-- col-md-6 menjadi w-full md:w-1/2 px-2 --}}
                            <label for="nama_penerima" class="block text-gray-700 text-sm font-bold mb-2">Nama Penerima:</label> {{-- form-label --}}
                            <input type="text" name="nama_penerima" class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Masukkan nama penerima" required> {{-- form-control --}}
                        </div>
                    </div>

                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition-colors duration-200 mt-4">Acc Donasi</button> {{-- btn btn-success --}}
                </form>
            </div>
        </div>
    @empty
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">Belum ada permintaan donasi.</div> {{-- alert alert-info --}}
    @endforelse
</div>
@endsection