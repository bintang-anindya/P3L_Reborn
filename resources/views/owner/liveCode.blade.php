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
                    <a href="{{ route('laporan.penitip') }}" class="list-group-item list-group-item-action">
                        Data Penitip
                    </a>
                    <a href="{{ route('laporan.liveCode') }}" class="list-group-item list-group-item-action active">
                        Laporan Live Code
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
                    Laporan Donasi Barang Elektronik
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('laporan.liveCode') }}" class="mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="tahun" class="form-label">Pilih Tahun:</label>
                                <select name="tahun" id="tahun" class="form-select" onchange="this.form.submit()">
                                    @php
                                        $currentYear = date('Y');
                                        $startYear = $currentYear - 5;
                                    @endphp
                                    @for($year = $currentYear; $year >= $startYear; $year--)
                                        <option value="{{ $year }}" {{ $tahun == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </form>

                    @if(isset($donasiList) && $donasiList->count() > 0)
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
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
                                        <td>{{ $donasi->barang->penitipan->penitip->nama_penitip ?? '-' }}</td>
                                        <td>{{ $donasi->tanggal_donasi ? $donasi->tanggal_donasi->format('d/m/Y') : '-' }}</td>
                                        <td>{{ $donasi->request && $donasi->request->organisasi ? $donasi->request->organisasi->nama_organisasi : '-' }}</td>
                                        <td>{{ $donasi->nama_penerima ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-3">
                            <a href="{{ route('laporan.liveCode.pdf', ['tahun' => $tahun]) }}" target="_blank" class="btn btn-primary">
                                Cetak PDF
                            </a>
                        </div>
                    @else
                        <div class="alert alert-info">
                            Tidak ada data donasi barang dengan kategori elektronik.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
