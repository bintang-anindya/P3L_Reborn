@extends('layouts.app')

{{-- Bootstrap Icons link ini tidak lagi dibutuhkan jika menggunakan SVG inline --}}
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"> --}}

@section('content')
<style>
    /* Gaya Umum */
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa; /* Latar belakang sangat terang, mendekati putih */
        color: #343a40; /* Warna teks standar (abu-abu gelap) */
    }

    /* Sidebar */
    .sidebar {
        background-color: #ffffff !important; /* Latar belakang sidebar putih bersih */
        border-right: 1px solid #e0e0e0; /* Border kanan abu-abu terang */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05); /* Bayangan lembut */
    }
    .sidebar .position-sticky {
        padding-top: 15px;
        padding-bottom: 15px;
        height: calc(100vh - 30px); /* Menyesuaikan tinggi agar tidak overscroll jika ada padding */
        display: flex;
        flex-direction: column;
    }
    .sidebar h5 {
        color: #000000; /* Judul sidebar hitam pekat */
        font-weight: 600;
        margin-bottom: 20px;
    }
    .sidebar .nav-link {
        color: #495057; /* Teks link sidebar abu-abu gelap */
        padding: 10px 20px;
        transition: all 0.2s ease-in-out;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
    }
    .sidebar .nav-link:hover {
        background-color: #e9ecef; /* Latar belakang abu-abu terang saat hover */
        color: #212529; /* Teks lebih gelap saat hover */
    }
    .sidebar .nav-link.active {
        background-color: #343a40 !important; /* Latar belakang aktif hitam gelap */
        color: #ffffff !important; /* Teks aktif putih */
        font-weight: 600;
        border-radius: 0; /* Pastikan tidak ada border-radius dari Bootstrap */
    }
    .sidebar .nav-link i, .sidebar .nav-link span { /* Untuk emoji atau ikon lainnya */
        margin-right: 8px;
    }
    .sidebar .mt-auto {
        margin-top: auto; /* Untuk menempatkan logout di bawah */
        padding: 0 20px;
    }
    .sidebar .btn-danger {
        background-color: #dc3545; /* Warna merah asli Bootstrap */
        border-color: #dc3545;
        color: #fff;
        transition: background-color 0.2s;
        padding: 10px 15px;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .sidebar .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }
    .sidebar .btn-danger .bi {
        margin-right: 8px;
    }

    /* Konten Utama */
    main.px-md-4 {
        background-color: #ffffff; /* Latar belakang konten utama putih */
        border-left: 1px solid #e0e0e0; /* Border kiri abu-abu terang */
        min-height: 100vh; /* Pastikan konten utama setinggi layar */
        padding: 25px !important; /* Mengoverride padding bawaan Bootstrap */
    }
    main h2 {
        color: #000000; /* Judul konten utama hitam pekat */
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 15px;
        margin-bottom: 25px;
        font-weight: 600;
    }

    /* Alerts (di Konten Utama) */
    .alert {
        border-radius: 3px;
        margin-bottom: 20px;
        font-size: 0.95rem;
    }
    .alert-info {
        background-color: #e9ecef; /* Latar belakang abu-abu terang */
        border-color: #ced4da; /* Border abu-abu */
        color: #0d6efd; /* Teks biru untuk kontras */
    }
    .alert-success {
        background-color: #e9ecef;
        border-color: #ced4da;
        color: #28a745;
    }
    .alert-danger {
        background-color: #e9ecef;
        border-color: #ced4da;
        color: #dc3545;
    }

    /* Tabel Transaksi */
    .table-responsive {
        margin-top: 20px;
    }
    .table-bordered {
        border: 1px solid #e0e0e0;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #ffffff;
    }
    .table-striped tbody tr:nth-of-type(even) {
        background-color: #f8f9fa; /* Latar belakang baris genap sangat terang */
    }
    .table-secondary thead th {
        background-color: #343a40 !important; /* Header tabel hitam gelap */
        color: #ffffff !important; /* Teks header putih */
        border: 1px solid #343a40 !important;
        padding: 12px 15px;
        vertical-align: middle;
    }
    .table tbody td {
        border: 1px solid #e0e0e0;
        padding: 10px 15px;
        vertical-align: middle;
    }

    /* Gambar Bukti Transaksi */
    .table tbody td img {
        border: 1px solid #ced4da;
        border-radius: 3px;
    }

    /* Badge Status */
    .badge.bg-warning {
        background-color: #e0e0e0 !important; /* Latar belakang badge abu-abu */
        color: #343a40 !important; /* Teks badge abu-abu gelap */
        font-weight: normal;
        padding: 6px 10px;
        border-radius: 3px;
    }

    /* Tombol Aksi Transaksi */
    .btn-success {
        background-color: #28a745; /* Warna hijau asli Bootstrap */
        border-color: #28a745;
        color: #fff;
        transition: background-color 0.2s;
        font-size: 0.85rem;
        padding: 6px 12px;
    }
    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }
    .btn-danger {
        background-color: #dc3545; /* Warna merah asli Bootstrap */
        border-color: #dc3545;
        color: #fff;
        transition: background-color 0.2s;
        font-size: 0.85rem;
        padding: 6px 12px;
    }
    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }
</style>

<div class="container-fluid">
    <div class="row">
        {{-- Sidebar --}}
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar shadow-sm vh-100">
            <div class="position-sticky pt-3">
                <h5 class="text-center mt-3">Dashboard CS</h5>
                <ul class="nav flex-column mt-4">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('cs/data-penitip*') ? 'active' : '' }}" href="{{ route('cs.penitip.index') }}">
                            <svg class="bi me-1" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/>
                                <path d="M9.5 1h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm-3 1h3V1.5h-3v.5z"/>
                            </svg>
                            Data Penitip
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('dashboard/cs') ? 'active' : '' }}" href="{{ route('dashboard.cs') }}">
                            <svg class="bi me-1" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10.793 4.207a1 1 0 0 1 0 1.414l-5 5a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L5 8.586l4.293-4.293a1 1 0 0 1 1.414 0z"/>
                                <path fill-rule="evenodd" d="M14.5 1A1.5 1.5 0 0 1 16 2.5v11A1.5 1.5 0 0 1 14.5 15h-13A1.5 1.5 0 0 1 0 13.5v-11A1.5 1.5 0 0 1 1.5 0h13zM14 2H2v11h12V2z"/>
                            </svg>
                            Verifikasi Pembayaran
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('cs/merchandise*') ? 'active' : '' }}" href="{{ route('cs.merchandise.index') }}">
                            <svg class="bi me-1" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M3 2.5a2.5 2.5 0 0 1 5 0 2.5 2.5 0 0 1 5 0v1.161A2.5 2.5 0 0 1 14.5 5h-13A2.5 2.5 0 0 1 3 3.661V2.5zM2 5a.5.5 0 0 0-.5.5v1A.5.5 0 0 0 2 7h12a.5.5 0 0 0 .5-.5v-1A.5.5 0 0 0 14 5H2zM1 8.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-6z"/>
                                <path fill-rule="evenodd" d="M2.5 2.5A1.5 1.5 0 0 1 4 1h8A1.5 1.5 0 0 1 13.5 2.5v1.161a1.5 1.5 0 0 0-1.5 1.5H4A1.5 1.5 0 0 0 2.5 3.661V2.5z"/>
                            </svg>
                            Merchandise
                        </a>
                    </li>
                </ul>
                <div class="mt-auto p-3"> {{-- Added padding here for spacing --}}
                    <form action="{{ route('logout') }}" method="POST" class="d-flex justify-content-start">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100">
                            <svg class="bi me-1" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                                <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                            </svg>
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        {{-- Konten Utama --}}
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-4">
            <h2>Daftar Transaksi Menunggu Validasi</h2>

            @if($transaksis->isEmpty())
                <div class="alert alert-info">
                    Tidak ada transaksi yang menunggu validasi.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-secondary">
                            <tr>
                                <th>No</th>
                                <th>Nomor Transaksi</th>
                                <th>Nama Pembeli</th>
                                <th>Total Harga</th>
                                <th>Bukti Transaksi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksis as $index => $transaksi)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $transaksi->nomor_transaksi }}</td>
                                    <td>{{ $transaksi->pembeli->nama_pembeli }}</td>
                                    <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                                    <td>
                                        @if($transaksi->bukti_transaksi)
                                            <img src="{{ asset($transaksi->bukti_transaksi) }}" alt="Bukti Transaksi" width="120">
                                        @else
                                            <span class="text-muted">Belum ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-warning text-dark">{{ $transaksi->status_transaksi }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('transaksi.validasi', ['id_transaksi' => $transaksi->id_transaksi]) }}" class="btn btn-success btn-sm">
                                            Valid
                                        </a>

                                        <a href="{{ route('transaksi.cancelByCs', ['id_transaksi' => $transaksi->id_transaksi]) }}" class="btn btn-danger btn-sm">
                                            Tidak Valid
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </main>
    </div>
</div>
@endsection