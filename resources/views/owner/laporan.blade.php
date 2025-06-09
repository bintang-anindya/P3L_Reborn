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
                    <a href="{{ route('laporan.donasi') }}" class="list-group-item list-group-item-action">
                        Donasi Barang
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">Laporan 2</a>
                    <a href="#" class="list-group-item list-group-item-action">Laporan 3</a>
                    <a href="#" class="list-group-item list-group-item-action">Laporan 4</a>
                    <a href="#" class="list-group-item list-group-item-action">Laporan 5</a>
                    <a href="#" class="list-group-item list-group-item-action">Laporan 6</a>
                    <a href="#" class="list-group-item list-group-item-action">Laporan 7</a>
                    <a href="#" class="list-group-item list-group-item-action">Laporan 8</a>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('dashboard.owner') }}" class="btn btn-secondary w-100">
                    ← Kembali ke Dashboard
                </a>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header bg-dark text-white">

                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h4 class="float-left">ReUseMart</h4>
                        <div style="clear: both;"></div>
                        <div>Jl. Green Eco Park No. 456 Yogyakarta</div>
                    </div>

                    <div style="margin-bottom: 1rem;"></div>

                    <h5 style="text-decoration: underline;">Laporan Donasi Barang</h5>
                    <div>Tahun : {{ date('Y') }}</div>
                    <div>Tanggal Cetak : {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}</div>

                    <br>

                    @if(isset($donasiList) && $donasiList->count() > 0)
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode Produk</th>
                                    <th>Nama Produk</th>
                                    <th>Id Penitip</th>
                                    <th>Nama Penitip</th>
                                    <th>Tanggal Donasi</th>
                                    <th>Organisasi</th>
                                    <th>Nama Penerima</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($donasiList as $donasi)
                                    <tr>
                                        <td>{{ $donasi->barang->kode_barang ?? '-' }}</td>
                                        <td>{{ $donasi->barang->nama_barang ?? '-' }}</td>
                                        <td>{{ $donasi->penitip->id_penitip ?? '-' }}</td>
                                        <td>{{ $donasi->penitip->nama_penitip ?? '-' }}</td>
                                        <td>{{ $donasi->tanggal_donasi ? $donasi->tanggal_donasi->format('d/m/Y') : '-' }}</td>
                                        <td>{{ $donasi->request && $donasi->request->organisasi ? $donasi->request->organisasi->nama_organisasi : '-' }}</td>
                                        <td>{{ $donasi->nama_penerima ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-3">
                            <a href="{{ route('laporan.donasi.pdf') }}" target="_blank" class="btn btn-primary">
                                Cetak PDF
                            </a>
                        </div>

                    @else
                        <div class="alert alert-info">
                            Tidak ada data donasi barang.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
