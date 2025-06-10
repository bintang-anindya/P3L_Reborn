@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col">
            <h2 class="fw-bold">Daftar Transaksi Sedang Disiapkan</h2>
        </div>
    </div>

    <div class="d-flex justify-content-start mb-3">
        <form action="{{ route('dashboard.gudang') }}" method="GET">
            <button class="btn btn-outline-secondary">
                <i class="bi bi-house-door me-1"></i> Back to Dashboard
            </button>
        </form>
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
                        <!-- Card Header -->
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

                        <!-- Card Body -->
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
                                                    <img src="{{ asset('storage/' . ($barang->gambar_barang ?? 'default-product.png')) }}" 
                                                         class="img-fluid rounded-start" 
                                                         alt="{{ $barang->nama_barang }}"
                                                         style="height: 120px; object-fit: cover;">
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="card-body">
                                                        <h6 class="card-title">{{ $barang->nama_barang ?? 'Produk' }}</h6>
                                                        <div class="d-flex justify-content-between">
                                                            <p class="card-text mb-1">
                                                                Rp {{ number_format($barang->harga_barang, 0, ',', '.') }}
                                                            </p>
                                                            <p class="card-text mb-1">
                                                                <small class="text-muted">x{{ $transaksiBarang->jumlah }}</small>
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

                        <!-- Card Footer dengan Tombol Aksi -->
                        <div class="card-footer bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="fw-bold">Total:</span>
                                    <span class="fs-5 ms-2">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex gap-2 align-items-center position-relative">
                                    <!-- Tombol Detail -->
                                    <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" 
                                        data-bs-target="#detailModal-{{ $transaction->id_transaksi }}">
                                        <i class="bi bi-eye"></i> Detail
                                    </button>
                                    
                                    <!-- Tombol Ambil -->
                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" 
                                        data-bs-target="#pengambilanModal-{{ $transaction->id_transaksi }}">
                                        <i class="bi bi-truck"></i> Ambil
                                    </button>
                                    <!-- Tombol Dikirim -->
                                    <button class="btn btn-sm btn-primary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#pengirimanModal-{{ $transaction->id_transaksi }}">
                                        <i class="bi bi-truck"></i> Dikirim
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Detail -->
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
                                    <div class="col-md-6">
                                        <p><strong>Metode Pengambilan:</strong> {{ $transaction->metode }}</p>
                                        <p><strong>Pembeli:</strong> {{ $transaction->pembeli->nama_pembeli ?? 'Tidak diketahui' }}</p>
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
                                                <th>Harga Satuan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($transaction->transaksiBarang as $transaksiBarang)
                                                @php
                                                    $barang = $transaksiBarang->barang;
                                                    $subtotal = $transaksiBarang->total_harga;
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <img src="{{ asset('storage/' . ($barang->gambar_barang ?? 'default-product.png')) }}" 
                                                             class="img-thumbnail" 
                                                             style="width: 60px; height: 60px; object-fit: cover;">
                                                    </td>
                                                    <td>{{ $barang->nama_barang }}</td>
                                                    <td>{{ $barang->berat }}</td>
                                                    <td>{{ $barang->harga_barang }}</td>
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

                <!-- Modal Pengambilan -->
                <div class="modal fade" id="pengambilanModal-{{ $transaction->id_transaksi }}" tabindex="-1" 
                    aria-labelledby="pengambilanModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="pengambilanModalLabel">
                                    Konfirmasi Pengambilan #{{ $transaction->id_transaksi }}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('gudang.daftarTransaksi.diambil', $transaction->id_transaksi) }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="tanggal_ambil" class="form-label">Tanggal Pengambilan</label>
                                        <input type="date" class="form-control" id="tanggal_ambil" 
                                            name="tanggal_ambil" 
                                            min="{{ date('Y-m-d') }}" 
                                            required>
                                        <div class="form-text">Pilih tanggal pengambilan (tidak boleh sebelum hari ini)</div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-check-circle"></i> Konfirmasi Pengambilan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Pengiriman -->
                <div class="modal fade" id="pengirimanModal-{{ $transaction->id_transaksi }}" tabindex="-1" 
                    aria-labelledby="pengirimanModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="pengirimanModalLabel">
                                    Atur Pengiriman #{{ $transaction->id_transaksi }}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('gudang.daftarTransaksi.dikirim', $transaction->id_transaksi) }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="tanggal_pengiriman" class="form-label">Tanggal Pengiriman</label>
                                        <input type="date" class="form-control" id="tanggal_pengiriman" 
                                            name="tanggal_pengiriman" 
                                            min="{{ date('Y-m-d') }}" 
                                            required>
                                        <div class="form-text">Pilih tanggal pengiriman (tidak boleh sebelum hari ini)</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="id_kurir" class="form-label">Kurir</label>
                                        <select class="form-select" id="id_kurir" name="id_kurir" required>
                                            <option value="" selected disabled>Pilih Kurir</option>
                                            @foreach($kurirs as $kurir)
                                                <option value="{{ $kurir->id_pegawai }}">
                                                    {{ $kurir->nama_pegawai }} ({{ $kurir->nomor_telepon }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle"></i> Konfirmasi Pengiriman
                                    </button>
                                </div>
                            </form>
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
    /* Style dasar card */
    .card {
        border-radius: 10px;
        overflow: hidden;
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-2px);
    }
    .card-header {
        border-radius: 10px 10px 0 0 !important;
    }
    
    /* Style untuk gambar */
    .img-thumbnail {
        padding: 0.25rem;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        transition: transform 0.2s;
    }
    .img-thumbnail:hover {
        transform: scale(1.05);
    }
</style>
@endpush

@push('scripts')
<script>
    // Set tanggal minimum untuk input date
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        document.querySelectorAll('input[type="date"]').forEach(input => {
            input.min = today;
        });
    });
</script>
@endpush
