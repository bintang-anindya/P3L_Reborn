@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col">
            <h2 class="fw-bold">Daftar Transaksi Sedang Disiapkan</h2>
        </div>
    </div>

    @if($transactions->isEmpty())
        <div class="alert alert-info">
            <i class="bi bi-info-circle-fill"></i> Tidak ada transaksi yang sedang disiapkan.
        </div>
    @else
        <div class="row">
            @foreach($transactions as $transaction)
                <div class="col-md-12 mb-4">
                    <div class="card shadow-sm border-0 mb-2">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-0">Transaksi #{{ $transaction->id_transaksi }}</h5>
                                    <small>{{ date('d F Y', strtotime($transaction->tanggal_transaksi)) }}</small>
                                </div>
                                <span class="badge bg-warning text-dark py-2 px-3">
                                    <i class="bi bi-hourglass-split"></i> {{ ucfirst($transaction->metode) }}
                                </span>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row row-cols-1 row-cols-md-2 g-4">
                                @foreach($transaction->transaksiBarang as $transaksiBarang)
                                    @php
                                        $barang = $transaksiBarang->barang;
                                    @endphp
                                    <div class="col">
                                        <div class="card h-100 border-0 shadow-sm">
                                            <div class="row g-0">
                                                <div class="col-md-4">
                                                    <img src="{{ asset('storage/' . ($barang->gambar_barang ?? 'default-product.png')) }}" alt="Gambar Barang">
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="card-body">
                                                        <h6 class="card-title">{{ $barang->nama_barang ?? 'Produk' }}</h6>
                                                        <div class="d-flex justify-content-between">
                                                            <p class="card-text mb-1">
                                                                Rp {{ number_format($barang->harga_barang, 0, ',', '.') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="card-footer bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-bold">Total:</span>
                                <span class="fs-5 ms-2">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex gap-2">
                                <!-- Tombol Detail dengan data attribute untuk modal -->
                                <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" 
                                    data-bs-target="#detailModal-{{ $transaction->id_transaksi }}">
                                    <i class="bi bi-eye"></i> Detail
                                </button>
                                <form action="{{ route('gudang.daftarTransaksi.diambil', $transaction->id_transaksi) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="bi bi-truck"></i>Ambil
                                    </button>
                                </form>
                                <button class="btn btn-sm btn-success">
                                    <i class="bi bi-truck"></i> Dikirim
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal untuk Detail Transaksi -->
                <div class="modal fade" id="detailModal-{{ $transaction->id_transaksi }}" tabindex="-1" 
                    aria-labelledby="detailModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="detailModalLabel">
                                    Detail Transaksi #{{ $transaction->id_transaksi }}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Tanggal Transaksi:</strong> {{ date('d F Y', strtotime($transaction->tanggal_transaksi)) }}</p>
                                        <p><strong>Status:</strong> 
                                            <span class="badge bg-warning text-dark">
                                                {{ ucfirst($transaction->status_transaksi) }}
                                            </span>
                                        </p>
                                        <p><strong>Total Harga:</strong> Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                <hr>

                                <h5 class="mb-3">Daftar Barang</h5>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Gambar</th>
                                                <th>Nama Barang</th>
                                                <th>Berat</th>
                                                <th>Harga</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($transaction->transaksiBarang as $transaksiBarang)
                                                @php
                                                    $barang = $transaksiBarang->barang;
                                                    $subtotal = $transaksiBarang->harga * $transaksiBarang->jumlah;
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <img src="{{ asset('storage/' . ($barang->gambar_barang ?? 'default-product.png')) }}" alt="Gambar Barang">
                                                    </td>
                                                    <td>{{ $barang->nama_barang }}</td>
                                                    <td>{{ $barang->berat ?? '0' }} gram</td>
                                                    <td>Rp {{ number_format($transaksiBarang->harga, 0, ',', '.') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .card {
        border-radius: 10px;
        overflow: hidden;
    }
    .card-header {
        border-radius: 10px 10px 0 0 !important;
    }
    .img-thumbnail {
        padding: 0.25rem;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
    }
</style>
@endpush