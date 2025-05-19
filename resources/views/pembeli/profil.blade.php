@extends('layouts.app')

@section('content')
<div class="container mt-5">
    @if(Auth::check())
        <div class="card shadow-sm rounded">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Profil Pembeli</h4>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('dashboard.pembeli') }}" class="btn btn-light btn-sm text-primary">← Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Nama</th>
                        <td>{{ $pembeli->nama_pembeli }}</td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td>{{ $pembeli->username_pembeli }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $pembeli->email_pembeli }}</td>
                    </tr>
                    <tr>
                        <th>No Telepon</th>
                        <td>{{ $pembeli->no_telp_pembeli }}</td>
                    </tr>
                    <tr>
                        <th>Poin</th>
                        <td>{{ $pembeli->poin_pembeli }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ optional($pembeli->alamat)->detail ?? 'Belum diatur' }}</td>
                    </tr>
                </table>

                @if($pembeli->transaksis && $pembeli->transaksis->isNotEmpty())
                    <div class="card shadow-sm rounded mt-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Riwayat Pembelian</h5>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped mb-0">
                                <thead class="table-success">
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal Transaksi</th>
                                        <th>Barang</th>
                                        <th>Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pembeli->transaksis as $index => $transaksi)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d M Y') }}</td>
                                            <td>
                                                <ul class="mb-0">
                                                    @foreach($transaksi->barangs as $barang)
                                                        <li>{{ $barang->nama_barang }} ({{ $barang->pivot->jumlah ?? 'x' }})</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info mt-4">
                        Belum ada riwayat pembelian.
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            <p>Anda belum login. <a href="{{ route('loginPage') }}">Login di sini</a></p>
        </div>
    @endif
</div>
@endsection
