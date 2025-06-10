@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Navigasi Kembali -->
    <div class="mb-3">
        <a href="{{ route('dashboard.owner') }}" class="btn btn-dark">
            ← Kembali ke Dashboard
        </a>
    </div>

    <!-- Judul -->
    <h4 class="mb-4">Riwayat Donasi Berdasarkan Organisasi</h4>

    <!-- Form Filter Organisasi -->
    <form action="{{ route('owner.historyFiltered') }}" method="POST" class="row g-3 mb-4">
        @csrf
        <div class="col-md-6">
            <label for="id_organisasi" class="form-label">Pilih Organisasi:</label>
            <select name="id_organisasi" id="id_organisasi" class="form-select" required>
                <option value="">-- Pilih Organisasi --</option>
                @foreach($organisasiList as $org)
                    <option value="{{ $org->id_organisasi }}"
                        {{ (isset($organisasi) && $organisasi->id_organisasi == $org->id_organisasi) ? 'selected' : '' }}>
                        {{ $org->nama_organisasi }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 align-self-end">
            <button type="submit" class="btn btn-dark w-100">Tampilkan</button>
        </div>
    </form>

    <!-- Tabel Riwayat Donasi -->
    @isset($donasiList)
        <div class="mb-3">
            <h5>
                Riwayat Donasi ke: 
                <strong>{{ $organisasi->nama_organisasi }}</strong>
            </h5>
        </div>

        @if($donasiList->isEmpty())
            <div class="alert alert-warning">
                Belum ada donasi untuk organisasi ini.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Barang</th>
                            <th>Nama Penerima</th>
                            <th>Tanggal Donasi</th>
                            <th>Status Barang</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($donasiList as $donasi)
                            <tr>
                                <td>{{ $donasi->barang->nama_barang }}</td>
                                <td>{{ $donasi->nama_penerima }}</td>
                                <td>{{ \Carbon\Carbon::parse($donasi->tanggal_donasi)->format('d M Y') }}</td>
                                <td>{{ $donasi->barang->status_barang }}</td>
                                <td class="text-center">
                                    <a href="{{ route('owner.edit', $donasi->id_donasi) }}" 
                                       class="btn btn-sm btn-warning">
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
