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
                    Laporan Transaksi Penitip
                </div>
                <div class="card-body">
                    <!-- Form Filter -->
                    <form action="{{ route('laporan.penitip') }}" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="penitip">Pilih Penitip</label>
                                <select name="penitip" id="penitip" class="form-select" required>
                                    <option value="">-- Pilih Penitip --</option>
                                    @foreach($penitipList as $p)
                                        <option value="{{ $p->id_penitip }}" {{ request('penitip') == $p->id_penitip ? 'selected' : '' }}>
                                            {{ $p->nama_penitip }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="bulan">Bulan</label>
                                <select name="bulan" id="bulan" class="form-select" required>
                                    <option value="">-- Pilih Bulan --</option>
                                    @for($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create()->month($m)->locale('id')->isoFormat('MMMM') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="tahun">Tahun</label>
                                <select name="tahun" id="tahun" class="form-select" required>
                                    @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                                        <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
                            </div>
                        </div>
                    </form>

                    <!-- Tabel Laporan -->
                    @if(isset($barangs) && count($barangs) > 0)
                        <div class="mb-3">
                            <a href="{{ route('laporan.printPenitip', ['penitip' => request('penitip'), 'bulan' => request('bulan'), 'tahun' => request('tahun')]) }}" target="_blank" class="btn btn-danger">
                                <i class="fas fa-print"></i> Cetak PDF
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode Produk</th>
                                    <th>Nama Produk</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Tanggal Laku</th>
                                    <th>Harga Jual Bersih</th>
                                    <th>Bonus Terjual Cepat</th>
                                    <th>Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalHarga = 0;
                                    $totalBonus = 0;
                                    $totalPendapatan = 0;
                                @endphp
                                @foreach($barangs as $barang)
                                    @php
                                        $hargaJualBersih = $barang->harga_barang * 0.8;
                                        $bonusCepat = 0;
                                        if ($barang->tanggal_keluar) {
                                            $tanggalMasuk = \Carbon\Carbon::parse($barang->tanggal_masuk);
                                            $tanggalKeluar = \Carbon\Carbon::parse($barang->tanggal_keluar);
                                            if ($tanggalKeluar->greaterThan($tanggalMasuk)) {
                                                $selisihHari = $tanggalMasuk->diffInDays($tanggalKeluar, false);
                                                if ($selisihHari < 7) {
                                                    $bonusCepat = $barang->harga_barang * 0.02;
                                                }
                                            }
                                        }
                                        $pendapatan = $hargaJualBersih + $bonusCepat;
                                        $totalHarga += $hargaJualBersih;
                                        $totalBonus += $bonusCepat;
                                        $totalPendapatan += $pendapatan;
                                    @endphp
                                    <tr>
                                        <td>{{ $barang->id_barang }}</td>
                                        <td>{{ $barang->nama_barang }}</td>
                                        <td>{{ \Carbon\Carbon::parse($barang->tanggal_masuk)->format('d M Y') }}</td>
                                        <td>{{ $barang->tanggal_keluar ? \Carbon\Carbon::parse($barang->tanggal_keluar)->format('d M Y') : '-' }}</td>
                                        <td>Rp {{ number_format($hargaJualBersih, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($bonusCepat, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($pendapatan, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4" class="text-center fw-bold">Total</td>
                                    <td class="fw-bold">Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
                                    <td class="fw-bold">Rp {{ number_format($totalBonus, 0, ',', '.') }}</td>
                                    <td class="fw-bold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    @elseif(request()->filled(['penitip', 'bulan', 'tahun']))
                        <div class="alert alert-info">
                            Tidak ada transaksi untuk penitip ini pada bulan dan tahun yang dipilih.
                        </div>
                    @else
                        <div class="alert alert-info">
                            Silakan pilih penitip, bulan, dan tahun untuk melihat laporan.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
