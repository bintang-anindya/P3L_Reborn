@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Konfirmasi Pengambilan</h2>

    <div class="d-flex justify-content-start mb-3">
        <form action="{{ route('dashboard.gudang') }}" method="GET">
            <button class="btn btn-outline-secondary">
                <i class="bi bi-house-door me-1"></i> Back to Dashboard
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Nomor Transaksi</th>
                <th>Tanggal</th>
                <th>Nama Pembeli</th>
                <th>Nama Barang</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksis as $transaksi)
                <tr>
                    <td>{{ $transaksi->nomor_transaksi }}</td>
                    <td>{{ $transaksi->tanggal_transaksi }}</td>
                    <td>{{ $transaksi->pembeli->nama ?? '-' }}</td>
                    <td>
                        <ul class="mb-0">
                            @foreach($transaksi->barang as $barang)
                                <li>{{ $barang->nama_barang }} ({{ $barang->pivot->jumlah }})</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                    <td><span class="badge bg-warning text-dark">{{ $transaksi->status_transaksi }}</span></td>
                    <td>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#konfirmasiModal{{ $transaksi->id_transaksi }}">
                            Konfirmasi
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="konfirmasiModal{{ $transaksi->id_transaksi }}" tabindex="-1" aria-labelledby="modalLabel{{ $transaksi->id_transaksi }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('gudang.konfirmasi.konfirmasi', $transaksi->id_transaksi) }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalLabel{{ $transaksi->id_transaksi }}">Konfirmasi Pengambilan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin mengubah status transaksi?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success">Ya, Konfirmasi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada transaksi yang menunggu pengambilan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
