
@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center">Profil Anda</h2>

    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="card shadow rounded-4">
                <div class="card-body">
                    <!-- Nama Pengguna -->
                    <h5 class="card-title text-center">Username: {{ $user->username_penitip }}</h5>

                    <!-- Email Pengguna -->
                    <p class="card-text text-center"><i class="fas fa-envelope"></i> Email: {{ $user->email_penitip }}</p>

                    <!-- Nama Lengkap -->
                    <p class="card-text text-center"><i class="fas fa-user"></i> Nama: {{ $user->nama_penitip }}</p>

                    <!-- No Telepon Pengguna -->
                    <p class="card-text text-center"><i class="fas fa-phone-alt"></i> Nomor Telepon: {{ $user->no_telp_penitip }}</p>

                    <!-- Saldo dan Poin -->
                    @if (session('guard') == 'penitip')
                        <p class="card-text text-center"><i class="fas fa-wallet"></i> Saldo: Rp. {{ number_format($penitip->saldo_penitip, 0, ',', '.') }}</p>
                        <p class="card-text text-center"><i class="fas fa-trophy"></i> Poin: {{ $penitip->poin_penitip }}</p>
                    @elseif (session('guard') == 'pegawai')
                        <p class="card-text text-center"><i class="fas fa-wallet"></i> Saldo Pegawai: Rp. {{ number_format($pegawai->saldo_pegawai, 0, ',', '.') }}</p>
                        <p class="card-text text-center"><i class="fas fa-trophy"></i> Poin Pegawai: {{ $pegawai->poin_pegawai }}</p>
                    @endif
                </div>  
            </div>
            @if (session('guard') == 'penitip')
                <div class="card mt-4 shadow rounded-4">
                    <div class="card-body">
                        <h5 class="card-title text-center">Daftar Transaksi Penitipan</h5>
                        @if ($riwayatTransaksi->isEmpty())
                            <p class="text-center text-muted">Belum ada transaksi penitipan.</p>
                        @else
                            <ul class="list-group list-group-flush">
                                @foreach ($riwayatTransaksi as $transaksi)
                                    <li class="list-group-item">
                                        <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($transaksi->tanggal_masuk)->format('Y-m-d') ?? '-' }} <br>
                                        <strong>Pesan:</strong> {{ $transaksi->pesan ?? '-' }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Tombol Kembali -->
            <div class="text-center mt-4">
                <a href="{{ route('dashboard.penitip') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                </a>
            </div>

            <h2 class="text-center">

            </h2>

            <!-- <form method="GET" action="{{ route('barang.index') }}" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control" placeholder="Nama Barang" value="{{ request('search') }}">
                    <button type="submit" class="btn btn-info text-white">Cari</button>
            </form> -->

            <div class="mt-4">
                <h5>Cari Barang</h5>
                <form method="GET" action="{{ route('barang.index') }}" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control" placeholder="Nama Barang" value="{{ request('search') }}">
                    <button type="submit" class="btn btn-info text-white">Cari</button>
                </form>

                @if(request('search'))
                    <div class="mt-3">
                        <h6>Hasil Pencarian: "{{ request('search') }}"</h6>
                        @php
                            $found = $barang->where('nama_barang', request('search'))->first();
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
        </div>
    </div>
</div>
@endsection
