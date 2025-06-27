@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6"> {{-- container menjadi container mx-auto px-4 py-6 --}}
    <h4 class="text-2xl font-bold mb-6 text-gray-900">Edit Donasi: {{ $donasi->barang->nama_barang }}</h4> {{-- h4 mb-4 --}}

    <form action="{{ route('donasi.update', $donasi->id_donasi) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4"> {{-- mb-3 menjadi mb-4 --}}
            <label for="nama_penerima" class="block text-gray-700 text-sm font-bold mb-2">Nama Penerima</label> {{-- form-label --}}
            <input type="text" name="nama_penerima" id="nama_penerima" class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-red-500" value="{{ $donasi->nama_penerima }}" required> {{-- form-control --}}
        </div>

        <div class="mb-4"> {{-- mb-3 menjadi mb-4 --}}
            <label for="status_barang" class="block text-gray-700 text-sm font-bold mb-2">Status Barang</label> {{-- form-label --}}
            <select name="status_barang" id="status_barang" class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-red-500" required> {{-- form-select --}}
                <option value="diterima" {{ $donasi->barang->status_barang == 'diterima' ? 'selected' : '' }}>Diterima</option>
                <option value="diproses" {{ $donasi->barang->status_barang == 'diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="ditolak" {{ $donasi->barang->status_barang == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>

        <div class="mb-6"> {{-- mb-3 menjadi mb-6 --}}
            <label for="tanggal_donasi" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Donasi</label> {{-- form-label --}}
            <input type="date" name="tanggal_donasi" id="tanggal_donasi" class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-red-500" value="{{ $donasi->tanggal_donasi->format('Y-m-d') }}" required> {{-- form-control --}}
        </div>

        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition-colors duration-200">Simpan Perubahan</button> {{-- btn btn-primary --}}
        <a href="{{ url()->previous() }}" class="ml-4 px-4 py-2 border border-gray-800 text-gray-800 rounded-lg text-sm hover:bg-gray-800 hover:text-white transition-colors duration-200">Batal</a> {{-- btn btn-secondary --}}
    </form>
</div>
@endsection