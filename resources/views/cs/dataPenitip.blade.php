@extends('layouts.app')

{{-- Bootstrap Icons link ini tidak lagi dibutuhkan jika menggunakan SVG inline --}}
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"> --}}

@section('content')
<style>
    /* Gaya Hitam Putih Minimalis (menyesuaikan dengan layout app) */
    body {
        /* background-color: #f8f9fa; */ /* Ini mungkin sudah diatur di layouts.app */
        color: #343a40; /* Warna teks standar (abu-abu gelap) */
        font-family: Arial, sans-serif;
    }
    .container.py-4 {
        /* Jika container di sini adalah kontainer utama yang ingin diberi latar belakang putih */
        background-color: #ffffff; /* Latar belakang kontainer putih bersih */
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05); /* Sedikit bayangan lembut */
    }
    h2 {
        color: #000000; /* Judul hitam pekat */
        border-bottom: 1px solid #dee2e6; /* Garis bawah abu-abu terang */
        padding-bottom: 15px;
        margin-bottom: 25px;
        font-weight: 600;
    }

    /* Tombol "Back to Dashboard" */
    .btn-back-dashboard {
        background-color: #ffffff;
        color: #343a40;
        border: 1px solid #adb5bd; /* Border abu-abu sedang */
        transition: all 0.2s ease-in-out;
        font-size: 0.9rem;
        padding: 8px 15px;
    }
    .btn-back-dashboard:hover {
        background-color: #e9ecef; /* Abu-abu terang saat hover */
        color: #212529; /* Teks lebih gelap saat hover */
        border-color: #6c757d; /* Border lebih gelap saat hover */
    }
    .btn-back-dashboard .bi {
        color: #6c757d; /* Warna ikon standar */
        vertical-align: middle;
        margin-right: 5px;
    }
    .btn-back-dashboard:hover .bi {
        color: #495057; /* Warna ikon lebih gelap saat hover */
    }

    /* Alerts (Pesan Sukses/Error) */
    .alert {
        border-radius: 3px;
        margin-bottom: 20px;
        font-size: 0.95rem;
    }
    .alert-success {
        background-color: #e9ecef; /* Latar belakang abu-abu terang */
        border-color: #ced4da; /* Border abu-abu */
        color: #28a745; /* Teks hijau untuk kontras */
    }
    .alert-danger {
        background-color: #e9ecef; /* Latar belakang abu-abu terang */
        border-color: #ced4da; /* Border abu-abu */
        color: #dc3545; /* Teks merah untuk kontras */
    }

    /* Search Input & Button */
    .input-group .form-control {
        border-color: #ced4da;
    }
    .input-group .btn-primary {
        background-color: #343a40;
        border-color: #343a40;
        color: #fff;
    }
    .input-group .btn-primary:hover {
        background-color: #23272b;
        border-color: #1d2124;
    }
    .input-group .bi {
        color: #fff;
    }

    /* Card (Form Tambah/Edit dan Tabel) */
    .card {
        border: 1px solid #e0e0e0; /* Border card abu-abu terang */
        border-radius: 5px;
        box-shadow: none; /* Hilangkan bayangan default Bootstrap */
    }
    .card-header {
        background-color: #f2f2f2; /* Header card abu-abu sangat terang */
        color: #343a40; /* Teks header abu-abu gelap */
        border-bottom: 1px solid #e0e0e0;
        padding: 15px 20px;
        font-size: 1.1rem;
    }
    .card-body {
        padding: 20px;
    }

    /* Form Elements */
    .form-control {
        border: 1px solid #ced4da;
        border-radius: 3px;
        padding: 8px 12px;
        font-size: 0.95rem;
    }
    label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 5px;
        display: block;
    }
    .btn-success { /* Untuk "Simpan Perubahan" */
        background-color: #28a745;
        border-color: #28a745;
        color: #fff;
        transition: background-color 0.2s;
    }
    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }
    .btn-secondary { /* Untuk "Batal" */
        background-color: #6c757d;
        border-color: #6c757d;
        color: #fff;
        transition: background-color 0.2s;
    }
    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }
    .btn-primary { /* Untuk "Tambah Penitip" */
        background-color: #000000;
        border-color: #000000;
        color: #ffffff;
        transition: background-color 0.2s;
    }
    .btn-primary:hover {
        background-color: #343a40;
        border-color: #343a40;
    }


    /* Tabel Penitip */
    .table-responsive {
        overflow-x: auto; /* Untuk tabel yang responsif */
    }
    .table-bordered {
        border: 1px solid #e0e0e0; /* Border luar tabel */
    }
    .table-hover tbody tr:hover {
        background-color: #e9ecef; /* Abu-abu terang saat hover pada baris */
    }
    .table-light thead th {
        background-color: #343a40; /* Header tabel hitam gelap */
        color: #ffffff; /* Teks header putih */
        border: 1px solid #343a40; /* Border header sesuai warna background */
        padding: 12px 15px;
        vertical-align: middle;
    }
    .table tbody td {
        border: 1px solid #e0e0e0; /* Border sel abu-abu sangat terang */
        padding: 10px 15px;
        vertical-align: middle;
    }
    .table tbody tr:nth-of-type(even) {
        background-color: #f8f9fa; /* Latar belakang baris genap abu-abu sangat terang */
    }
    .table tbody tr:nth-of-type(odd) {
        background-color: #ffffff; /* Latar belakang baris ganjil putih */
    }

    /* Tombol Aksi Tabel */
    .btn-warning { /* Untuk Edit */
        background-color: #ffc107; /* Warna kuning asli Bootstrap */
        border-color: #ffc107;
        color: #212529; /* Teks hitam */
        transition: all 0.2s;
    }
    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
    }
    .btn-danger { /* Untuk Hapus */
        background-color: #dc3545; /* Warna merah asli Bootstrap */
        border-color: #dc3545;
        color: #fff;
        transition: all 0.2s;
    }
    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
    }
    .btn-sm .bi {
        font-size: 0.9rem; /* Ukuran ikon di tombol kecil */
        vertical-align: -0.125em; /* Penyelarasan ikon */
    }

    /* Pagination */
    .pagination .page-item .page-link {
        font-size: 0.875rem;
        padding: 0.5rem 0.75rem; /* Ukuran padding normal untuk pagination */
        color: #343a40; /* Warna teks link default */
        border: 1px solid #dee2e6; /* Border link abu-abu terang */
        background-color: #ffffff; /* Latar belakang link putih */
        transition: all 0.2s;
    }
    .pagination .page-item .page-link:hover {
        background-color: #e9ecef; /* Latar belakang hover abu-abu terang */
        border-color: #adb5bd;
    }
    .pagination .page-item.active .page-link {
        background-color: #000000; /* Latar belakang aktif hitam */
        border-color: #000000;
        color: #ffffff; /* Teks aktif putih */
    }
    .pagination .page-item.disabled .page-link {
        color: #adb5bd; /* Teks disabled abu-abu */
        pointer-events: none;
        background-color: #ffffff;
        border-color: #dee2e6;
    }
    .pagination .page-item .page-link i {
        font-size: 1rem; /* Ukuran ikon panah */
    }
    img.img-thumbnail {
        border: 1px solid #ced4da;
        border-radius: 3px;
    }
</style>

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
            <button class="btn btn-back-dashboard">
                <svg class="bi bi-house-door me-1" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5V10.3a1.5 1.5 0 0 1 3 0v4.2a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L8.354 1.146zM11.5 7.5v7h-3V10.3a.5.5 0 0 0-.5-.5H6a.5.5 0 0 0-.5.5v4.2h-3v-7l5.657-5.657L11.5 7.5z"/>
                </svg>
                Back to Dashboard
            </button>
        </form>
    </div>

    {{-- Search --}}
    <form action="{{ route('cs.penitip.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="keyword" class="form-control" placeholder="Cari nama, username, atau NIK..." value="{{ request('keyword') }}">
            <button class="btn btn-primary" type="submit">
                <svg class="bi bi-search" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.415 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                    <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                </svg>
                Cari
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
                            <svg class="bi bi-save me-1" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M2.5 1A1.5 1.5 0 0 0 1 2.5v11A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5V6.707a1 1 0 0 0-.293-.707L12.354.854A1 1 0 0 0 11.646.5H2.5zm-.5 1a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .354.146L13.146 3.5h-9.793A.5.5 0 0 0 3 3v-1zm1 11.5v-4.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 .5.5v4.5H4z"/>
                            </svg>
                            {{ isset($penitip) ? 'Simpan Perubahan' : 'Tambah Penitip' }}
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
                                <svg class="bi bi-pencil" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10.5a.5.5 0 0 0 .5.5h.793l6.354-6.354z"/>
                                </svg>
                            </a>
                            <form action="{{ route('cs.penitip.destroy', $penitip->id_penitip) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data penitip ini?')">
                                    <svg class="bi bi-trash" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13V9.5a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V4H2.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13.5a1.5 1.5 0 0 0 1.5 1.5h6a1.5 1.5 0 0 0 1.5-1.5V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>
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