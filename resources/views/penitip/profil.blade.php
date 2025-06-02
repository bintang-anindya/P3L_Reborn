@extends('layouts.app')

@section('content')
<div class="container py-4">

    <!-- Tombol Kembali di Pojok Kiri -->
    <div class="mb-3">
        <a href="{{ route('dashboard.penitip') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <h2 class="text-center mb-4">Profil Anda</h2>

    <div class="row justify-content-center">
        <div class="col-md-8">

            <!-- Kartu Profil -->
            <div class="card shadow rounded-4 mb-4">
                <div class="card-body text-center">
                    <h4 class="mb-3">👤 {{ $user->nama_penitip }}</h4>
                    <p><i class="fas fa-user-tag me-2"></i><strong>Username:</strong> {{ $user->username_penitip }}</p>
                    <p><i class="fas fa-envelope me-2"></i><strong>Email:</strong> {{ $user->email_penitip }}</p>
                    <p><i class="fas fa-phone-alt me-2"></i><strong>Telepon:</strong> {{ $user->no_telp_penitip }}</p>

                    @if (session('guard') == 'penitip')
                        <p><i class="fas fa-wallet me-2"></i><strong>Saldo:</strong> Rp. {{ number_format($penitip->saldo_penitip, 0, ',', '.') }}</p>
                        <p><i class="fas fa-trophy me-2"></i><strong>Poin:</strong> {{ $penitip->poin_penitip }}</p>
                    @elseif (session('guard') == 'pegawai')
                        <p><i class="fas fa-wallet me-2"></i><strong>Saldo Pegawai:</strong> Rp. {{ number_format($pegawai->saldo_pegawai, 0, ',', '.') }}</p>
                        <p><i class="fas fa-trophy me-2"></i><strong>Poin Pegawai:</strong> {{ $pegawai->poin_pegawai }}</p>
                    @endif
                </div>
            </div>

            <!-- Riwayat Transaksi -->
            @if (session('guard') == 'penitip')
                <div class="card shadow rounded-4 mb-4">
                    <div class="card-body">
                        <h5 class="card-title text-center">📜 Riwayat Transaksi Penitipan</h5>
                        @if ($riwayatTransaksi->isEmpty())
                            <p class="text-center text-muted">Belum ada transaksi penitipan.</p>
                        @else
                            <ul class="list-group list-group-flush">
                                @foreach ($riwayatTransaksi as $transaksi)
                                    <li class="list-group-item">
                                        <strong>Tanggal:</strong> {{ optional($transaksi->created_at)->format('d M Y') ?? '-' }} <br>
                                        <strong>Pesan:</strong> {{ $transaksi->pesan ?? '-' }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Pencarian Barang
            <div class="card shadow rounded-4 mb-4">
                <div class="card-body">
                    <h5 class="mb-3">🔍 Cari Barang</h5>
                    <form method="GET" action="{{ route('barang.index') }}" class="d-flex gap-2">
                        <input type="text" name="search" class="form-control" placeholder="Nama Barang" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-info text-white">Cari</button>
                    </form>

                    @if(request('search'))
                        <div class="mt-3">
                            <h6>Hasil Pencarian: "{{ request('search') }}"</h6>
                            @php
                                $found = $barangTitipan->where('nama_barang', request('search'))->first();
                            @endphp
                            @if($found)
                                <div class="alert alert-success">
                                    <p><strong>Nama Barang:</strong> {{ $found->nama_barang }}</p>
                                </div>
                            @else
                                <div class="alert alert-danger">Barang tidak ditemukan.</div>
                            @endif
                        </div>
                    @endif
                </div>
            </div> -->

            <!-- Daftar Barang Titipan -->
            @if (isset($barangTitipan) && !$barangTitipan->isEmpty())
                <div class="card shadow rounded-4 mb-4">
                    <div class="card-body">
                        <h5 class="card-title text-center">📦 Barang Titipan Anda</h5>
                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th>Status</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Tenggat Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barangTitipan as $barang)
                                        <tr>
                                            <td>{{ $barang->nama_barang }}</td>
                                            <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                                            <td>Rp {{ number_format($barang->harga_barang, 0, ',', '.') }}</td>
                                            <td>{{ ucfirst($barang->status_barang) }}</td>
                                            <td>{{ $barang->tanggal_masuk ? \Carbon\Carbon::parse($barang->tanggal_masuk)->format('d M Y') : '-' }}</td>
                                            <td>{{ $barang->tenggat_waktu ? \Carbon\Carbon::parse($barang->tenggat_waktu)->format('d M Y') : '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
