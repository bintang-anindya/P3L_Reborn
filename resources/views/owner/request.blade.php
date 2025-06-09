@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Permintaan Donasi</h2>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('dashboard.owner') }}" class="btn btn-outline-dark mb-3">
        Kembali Ke Dashboard
    </a>

    @forelse($requests as $request)
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header bg-black text-white">
                <h5 class="mb-0">{{ $request->organisasi->nama_organisasi }}</h5>
            </div>
            <div class="card-body">
                <p class="mb-3"><strong>Keterangan:</strong> {{ $request->keterangan_request }}</p>

                <form action="{{ route('donasi.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_request" value="{{ $request->id_request }}">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="id_barang" class="form-label">Pilih Barang Donasi:</label>
                            <select name="id_barang" class="form-select" required>
                                <option value="">-- Pilih Barang --</option>
                                @foreach($barangLayak as $barang)
                                    <option value="{{ $barang->id_barang }}">
                                        {{ $barang->nama_barang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="nama_penerima" class="form-label">Nama Penerima:</label>
                            <input type="text" name="nama_penerima" class="form-control" placeholder="Masukkan nama penerima" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">Acc Donasi</button>
                </form>
            </div>
        </div>
    @empty
        <div class="alert alert-info">Belum ada permintaan donasi.</div>
    @endforelse
</div>
@endsection