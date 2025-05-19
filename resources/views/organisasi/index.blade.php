@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Organisasi</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Tombol Tambah --}}
    <a href="{{ route('organisasi.create') }}" class="btn btn-success mb-3">+ Tambah Organisasi</a>

    {{-- Tabel Organisasi --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>No. Telp</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($organisasis as $organisasi)
                    <tr>
                        <td>{{ $organisasi->id_organisasi }}</td>
                        <td>{{ $organisasi->nama_organisasi }}</td>
                        <td>{{ $organisasi->username_organisasi }}</td>
                        <td>{{ $organisasi->email_organisasi }}</td>
                        <td>{{ $organisasi->alamat_organisasi }}</td>
                        <td>{{ $organisasi->no_telp_organisasi }}</td>
                        <td>
                            <a href="{{ route('organisasi.edit', $organisasi->id_organisasi) }}" class="btn btn-sm btn-warning">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center">Belum ada organisasi terdaftar.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pencarian --}}
    <div class="mt-4">
        <h5>Cari Organisasi</h5>
        <form method="GET" action="{{ route('organisasi.index') }}" class="d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Nama organisasi" value="{{ request('search') }}">
            <button type="submit" class="btn btn-info text-white">Cari</button>
        </form>

        @if(request('search'))
            <div class="mt-3">
                <h6>Hasil Pencarian: "{{ request('search') }}"</h6>
                @php
                    $found = $organisasis->where('nama_organisasi', request('search'))->first();
                @endphp
                @if($found)
                    <div class="alert alert-success">
                        <p><strong>Nama:</strong> {{ $found->nama_organisasi }}</p>
                        <p><strong>Email:</strong> {{ $found->email_organisasi }}</p>
                    </div>
                @else
                    <div class="alert alert-danger">Organisasi tidak ditemukan.</div>
                @endif
            </div>
        @endif
    </div>

    {{-- Hapus Berdasarkan Nama --}}
    <div class="mt-5">
        <h5>Hapus Organisasi Berdasarkan Nama</h5>
        <form method="POST" action="{{ route('organisasi.destroy') }}" class="d-flex gap-2">
            @csrf
            <input type="text" name="nama_organisasi" class="form-control" placeholder="Nama organisasi" required>
            <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
    </div>
</div>
@endsection
