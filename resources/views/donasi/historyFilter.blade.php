@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('dashboard.owner') }}" class="btn btn-secondary">← Kembali ke Dashboard</a>
    <h4 class="mb-4">Riwayat Donasi Berdasarkan Organisasi</h4>

    <form action="{{ route('donasi.historyFiltered') }}" method="POST" class="row g-3 mb-4">
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
            <button type="submit" class="btn btn-primary">Tampilkan</button>
        </div>
    </form>

    @isset($donasiList)
        <h5 class="mb-3">Riwayat Donasi ke: <strong>{{ $organisasi->nama_organisasi }}</strong></h5>

        @if($donasiList->isEmpty())
            <div class="alert alert-warning">Belum ada donasi untuk organisasi ini.</div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Barang</th>
                            <th>Nama Penerima</th>
                            <th>Tanggal Donasi</th>
                            <th>Status Barang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($donasiList as $donasi)
                            <tr>
                                <td>{{ $donasi->barang->nama_barang }}</td>
                                <td>{{ $donasi->nama_penerima }}</td>
                                <td>{{ \Carbon\Carbon::parse($donasi->tanggal_donasi)->format('d M Y') }}</td>
                                <td>{{ $donasi->barang->status_barang }}</td>
                                <td>
                                    <a href="{{ route('donasi.edit', $donasi->id_donasi) }}" class="btn btn-sm btn-warning">Edit</a>
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