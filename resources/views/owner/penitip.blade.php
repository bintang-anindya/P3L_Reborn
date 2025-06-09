@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    Menu Laporan
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('laporan.index', ['tab' => 'donasi']) }}" class="list-group-item list-group-item-action">
                        Donasi Barang
                    </a>
                    <a href="{{ route('laporan.index', ['tab' => 'request']) }}" class="list-group-item list-group-item-action">
                        Request Donasi
                    </a>
                    <a href="{{ route('laporan.penitip') }}" class="list-group-item list-group-item-action active">
                        Data Penitip
                    </a>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('dashboard.owner') }}" class="btn btn-secondary w-100">
                    ← Kembali ke Dashboard
                </a>
            </div>
        </div>

        <!-- Content -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    Data Penitip
                </div>
                <div class="card-body">

                    @if(isset($penitipList) && $penitipList->count() > 0)
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>ID Penitip</th>
                                    <th>Nama Penitip</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($penitipList as $penitip)
                                    <tr>
                                        <td>{{ $penitip->id_penitip }}</td>
                                        <td>{{ $penitip->nama_penitip }}</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-danger" title="Cetak PDF">
                                                <i class="fas fa-print"></i> Cetak PDF
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info">
                            Tidak ada data penitip.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
