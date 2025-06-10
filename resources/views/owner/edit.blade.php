@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Edit Donasi: {{ $donasi->barang->nama_barang }}</h4>

    <form action="{{ route('donasi.update', $donasi->id_donasi) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Penerima</label>
            <input type="text" name="nama_penerima" class="form-control" value="{{ $donasi->nama_penerima }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Status Barang</label>
            <select name="status_barang" class="form-select" required>
                <option value="diterima" {{ $donasi->barang->status_barang == 'diterima' ? 'selected' : '' }}>Diterima</option>
                <option value="diproses" {{ $donasi->barang->status_barang == 'diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="ditolak" {{ $donasi->barang->status_barang == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Donasi</label>
            <input type="date" name="tanggal_donasi" class="form-control" value="{{ $donasi->tanggal_donasi->format('Y-m-d') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection