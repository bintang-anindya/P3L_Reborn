@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Barang Expired</h2>

    <div class="d-flex justify-content-start mb-3">
        <form action="{{ route('dashboard.gudang') }}" method="GET">
            <button class="btn btn-outline-secondary">
                <i class="bi bi-house-door me-1"></i> Back to Dashboard
            </button>
        </form>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Tanggal Masuk</th>
                <th>Tenggat Waktu</th>
                <th>Nama Penitip</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barang_expired as $barang)
            <tr>
                <td>{{ $barang->nama_barang }}</td>
                <td>{{ $barang->tanggal_masuk }}</td>
                <td class="{{ $barang->tenggat_waktu < now() ? 'text-danger' : '' }}">
                    {{ $barang->tenggat_waktu }}
                </td>
                <td>{{ $barang->penitipan->penitip->nama_penitip ?? '-' }}</td>
                <td>
                    <form action="{{ route('gudang.ambilBarang.ambil', $barang->id_barang) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm">
                            Ambil
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection