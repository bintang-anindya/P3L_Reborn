@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- Sidebar --}}
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar shadow-sm vh-100">
            <div class="position-sticky pt-3">
                <h5 class="text-center mt-3">Dashboard CS</h5>
                <ul class="nav flex-column mt-4">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('cs/data-penitip') ? 'active' : '' }}" href="{{ route('cs.penitip.index') }}">
                            📋 Data Penitip
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('dashboard/cs') ? 'active' : '' }}" href="{{ route('dashboard.cs') }}">
                            ✅ Verifikasi Pembayaran
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('cs/penukaranReward') ? 'active' : '' }}" href="/cs/penukaranReward">
                            🎁 Penukaran Reward
                        </a>
                    </li>
                </ul>
                <div class="mt-auto">
                    <form action="{{ route('logout') }}" method="POST" class="d-flex justify-content-start">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100 mt-4">
                            🚪 Log Out
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
