@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col">
            <h2 class="fw-bold">Daftar Transaksi Siap Cetak Nota</h2>
                <div class="d-flex justify-content-start mb-3">
                <form action="{{ route('dashboard.gudang') }}" method="GET">
                    <button class="btn btn-outline-secondary">
                        <i class="bi bi-house-door me-1"></i> Back to Dashboard
                    </button>
                </form>
            </div>
            <div class="d-flex align-items-center">
                <span class="badge bg-primary me-2">Dikirim</span>
                <span class="badge bg-success">Selesai</span>
            </div>
        </div>
        <div class="col-auto">
            <a href="{{ route('dashboard.gudang') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    @if($transactions->isEmpty())
        <div class="alert alert-info">
            <i class="bi bi-info-circle-fill me-2"></i>Tidak ada transaksi yang siap dicetak.
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="100">ID Transaksi</th>
                                <th width="120">Tanggal</th>
                                <th>Pembeli</th>
                                <th width="120">Status</th>
                                <th width="150">Total</th>
                                <th width="120">Metode</th>
                                <th width="120" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                            <tr>
                                <td>#{{ $transaction->id_transaksi }}</td>
                                <td>{{ date('d/m/Y', strtotime($transaction->tanggal_transaksi)) }}</td>
                                <td>{{ $transaction->pembeli->nama_pembeli ?? '-' }}</td>
                                <td>
                                    @if($transaction->status_transaksi === 'dikirim')
                                        <span class="badge bg-primary">
                                            <i class="bi bi-truck me-1"></i> Dikirim
                                        </span>
                                    @else
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i> Selesai
                                        </span>
                                    @endif
                                </td>
                                <td>Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                                <td>{{ ucfirst($transaction->metode) }}</td>
                                <td class="text-center">
                                    <a href="{{ route('gudang.cetak.pdf', $transaction->id_transaksi) }}" 
                                       class="btn btn-sm btn-danger" 
                                       title="Cetak Nota"
                                       target="_blank">
                                        <i class="bi bi-file-earmark-pdf"></i> Cetak
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
    .badge {
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 500;
    }
    .btn-sm {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }
</style>
@endpush