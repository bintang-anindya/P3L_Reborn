@extends('layouts.app')

@section('content')
<div class="container py-4">
    {{-- Flash Message --}}
    @if(session('success') || session('error'))
        <div class="alert alert-{{ session('success') ? 'success' : 'danger' }} alert-dismissible fade show" role="alert">
            {{ session('success') ?? session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Manajemen Request Donasi</h2>
        {{-- Search Form --}}
        <form class="d-flex" action="{{ route('organisasi.requestDonasi.index') }}" method="GET">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari request..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">Cari</button>
        </form>
    </div>

    {{-- Form Tambah / Edit Request --}}
    <div class="card mb-4">
        <div class="card-header">{{ isset($editRequest) ? 'Edit Request Donasi' : 'Tambah Request Donasi' }}</div>
        <div class="card-body">
            <form id="requestForm" action="{{ isset($editRequest) ? route('organisasi.requestDonasi.update', $editRequest->id_request) : route('organisasi.requestDonasi.store') }}" method="POST">
                @csrf
                @if(isset($editRequest)) @method('PUT') @endif

                <div class="mb-3">
                    <label for="keterangan_request" class="form-label">Keterangan Request</label>
                    <input type="text" class="form-control" id="keterangan_request" name="keterangan_request" value="{{ old('keterangan_request', $editRequest->keterangan_request ?? '') }}" required>
                </div>

                <button type="submit" class="btn btn-primary">
                    {{ isset($editRequest) ? 'Update Request' : 'Tambah Request' }}
                </button>
                @if(isset($editRequest))
                    <a href="{{ route('organisasi.requestDonasi.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                @endif
            </form>
        </div>
    </div>

    {{-- Tombol Back dengan ikon pintu keluar --}}
    <a href="{{ route('dashboard.organisasi') }}" class="position-absolute top-0 start-0 p-3" style="font-size: 1.5rem; color: #000;">
        <i class="bi bi-box-arrow-left"></i>
    </a>

    {{-- Tampilkan daftar request donasi hanya di halaman index --}}
    @isset($requests)
        <div class="card">
            <div class="card-header">Daftar Request Donasi</div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Keterangan</th>
                            <th>Status Donasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($requests as $request)
                            <tr>
                                <td>{{ $request->keterangan_request }}</td>
                                <td>{{ ucfirst($request->status_donasi) }}</td>
                                <td>
                                    <a href="{{ route('organisasi.requestDonasi.edit', $request->id_request) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('organisasi.requestDonasi.destroy', $request->id_request) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus request ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Tidak ada data ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="mt-3">
                    {{ $requests->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    @endisset
</div>
@endsection

{{-- Script konfirmasi --}}
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('requestForm');
        const isEdit = {{ isset($editRequest) ? 'true' : 'false' }};

        if (isEdit) {
            form.addEventListener('submit', function (e) {
                const confirmUpdate = confirm('Apakah Anda yakin ingin mengupdate request ini?');
                if (!confirmUpdate) {
                    e.preventDefault();
                }
            });
        }
    });
</script>
@endsection
