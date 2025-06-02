@extends('layouts.app')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

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
        <h2 class="mb-0">Manajemen Data Penitip</h2>
        <form action="{{ route('dashboard.cs') }}" method="GET">
            <button class="btn btn-outline-secondary">
                <i class="bi bi-house-door me-1"></i> Back to Dashboard
            </button>
        </form>
    </div>

    {{-- Search --}}
    <form action="{{ route('cs.penitip.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="keyword" class="form-control" placeholder="Cari nama, username, atau NIK..." value="{{ request('keyword') }}">
            <button class="btn btn-primary" type="submit">
                <i class="bi bi-search"></i> Cari
            </button>
        </div>
    </form>

    {{-- Error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Tambah / Edit --}}
    <div class="card mb-5">
        <div class="card-header fw-semibold">{{ isset($penitip) ? 'Edit Penitip' : 'Tambah Penitip' }}</div>
        <div class="card-body">
            <form id="penitipForm" action="{{ isset($penitip) ? route('cs.penitip.update', $penitip->id_penitip) : route('cs.penitip.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($penitip)) @method('PUT') @endif

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Nama Penitip</label>
                        <input type="text" name="nama_penitip" class="form-control" value="{{ old('nama_penitip', $penitip->nama_penitip ?? '') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Username</label>
                        <input type="text" name="username_penitip" class="form-control" value="{{ old('username_penitip', $penitip->username_penitip ?? '') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Password {{ isset($penitip) ? '(Kosongkan jika tidak ingin mengubah)' : '' }}</label>
                        <input type="password" name="password_penitip" class="form-control" {{ isset($penitip) ? '' : 'required' }}>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>NIK</label>
                        <input type="number" name="nik" class="form-control" value="{{ old('nik', $penitip->nik ?? '') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Email</label>
                        <input type="email" name="email_penitip" class="form-control" value="{{ old('email_penitip', $penitip->email_penitip ?? '') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>No Telepon</label>
                        <input type="text" name="no_telp_penitip" class="form-control" value="{{ old('no_telp_penitip', $penitip->no_telp_penitip ?? '') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Upload Foto KTP</label>
                        <input type="file" name="foto_ktp" class="form-control" accept="image/*" {{ isset($penitip) ? '' : 'required' }}>
                        @if(isset($penitip) && $penitip->foto_ktp)
                            <small class="text-muted">Abaikan jika tidak ingin mengganti.</small>
                        @endif
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-{{ isset($penitip) ? 'success' : 'primary' }}">
                            <i class="bi bi-save me-1"></i> {{ isset($penitip) ? 'Simpan Perubahan' : 'Tambah Penitip' }}
                        </button>
                        @if(isset($penitip))
                            <a href="{{ route('cs.penitip.index') }}" class="btn btn-secondary ms-2">Batal</a>
                        @endif
                    </div>
                </div> 
            </form>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="card">
        <div class="card-header fw-semibold">Daftar Penitip</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>NIK</th>
                        <th>Email</th>
                        <th>No Telp</th>
                        <th>Poin</th>
                        <th>Saldo</th>
                        <th>Foto KTP</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penitips as $penitip)
                    <tr>
                        <td>{{ $penitip->nama_penitip }}</td>
                        <td>{{ $penitip->username_penitip }}</td>
                        <td>{{ $penitip->nik }}</td>
                        <td>{{ $penitip->email_penitip }}</td>
                        <td>{{ $penitip->no_telp_penitip }}</td>
                        <td>{{ $penitip->poin ?? 0 }}</td>
                        <td>Rp{{ number_format($penitip->saldo ?? 0, 0, ',', '.') }}</td>
                        <td>
                            @if($penitip->foto_ktp)
                                <img src="{{ asset('storage/' . $penitip->foto_ktp) }}" alt="KTP" width="80" class="img-thumbnail">
                            @else
                                <span class="text-muted">Belum ada</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('cs.penitip.edit', $penitip->id_penitip) }}" class="btn btn-warning btn-sm me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('cs.penitip.destroy', $penitip->id_penitip) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data penitip ini?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">Belum ada data penitip.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-3 d-flex justify-content-center">
                <nav aria-label="Page navigation">
                    {{ $penitips->links('pagination::bootstrap-5') }}
                </nav>
            </div>
        </div>
    </div>
</div>

{{-- Custom CSS --}}
<style>
    .pagination .page-item .page-link {
        font-size: 0.875rem;
        padding: 0.25rem 0.5rem;
    }

    .pagination .page-item .page-link i {
        font-size: 1.2rem;
    }

    .pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const penitipForm = document.getElementById('penitipForm');
        const isEditMode = @json(isset($penitip));

        penitipForm.addEventListener('submit', function (e) {
            const message = isEditMode 
                ? 'Yakin ingin menyimpan perubahan data penitip ini?' 
                : 'Yakin ingin menambahkan data penitip baru?';

            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });
</script>
@endsection
