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
                    <a href="{{ route('laporan.index', ['tab' => 'donasi']) }}" class="list-group-item list-group-item-action {{ $tab == 'donasi' ? 'active' : '' }}">
                        Donasi Barang
                    </a>
                    <a href="{{ route('laporan.index', ['tab' => 'request']) }}" class="list-group-item list-group-item-action {{ $tab == 'request' ? 'active' : '' }}">
                        Request Donasi
                    </a>
                    <a href="{{ route('laporan.penitip') }}" class="list-group-item list-group-item-action ">
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

        <div class="col-md-9">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    @if($tab == 'donasi')
                        Laporan Donasi Barang
                    @else
                        Laporan Request Donasi
                    @endif
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h4 class="float-left">ReUseMart</h4>
                        <div style="clear: both;"></div>
                        <div>Jl. Green Eco Park No. 456 Yogyakarta</div>
                    </div>

                    <div class="mb-2"></div>

                    <div>
                        Tahun : {{ date('Y') }}<br>
                        Tanggal Cetak : {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}
                    </div>

                    <br>

                    @if($tab == 'donasi')
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
                                            <td>{{ $donasi->barang->id_barang ?? '-' }}</td>
                                            <td>{{ $donasi->barang->nama_barang ?? '-' }}</td>
                                            <td>{{ $donasi->barang->penitipan->id_penitip ?? '-' }}</td>
                                            <td>{{ $donasi->barang->penitipan->penitip->nama_penitip ?? '-' }}</td>
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
                    @elseif($tab == 'request')
                        @if(isset($requestDonasiList) && $requestDonasiList->count() > 0)
                            <table class="table table-bordered table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID Organisasi</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Request</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($requestDonasiList as $request)
                                        <tr>
                                            <td>{{ $request->organisasi->id_organisasi ?? '-' }}</td>
                                            <td>{{ $request->organisasi->nama_organisasi ?? '-' }}</td>
                                            <td>{{ $request->organisasi->alamat_organisasi ?? '-' }}</td>
                                            <td>{{ $request->keterangan_request ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="mt-3">
                                <a href="{{ route('laporan.request.pdf') }}" target="_blank" class="btn btn-primary">
                                    Cetak PDF
                                </a>
                            </div>
                        @else
                            <div class="alert alert-info">
                                Tidak ada data request donasi.
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
