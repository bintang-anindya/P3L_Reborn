@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    Menu Laporan
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('laporan.index', ['tab' => 'penjualan-bulanan']) }}" class="list-group-item list-group-item-action {{ $tab == 'penjualan-bulanan' ? 'active' : '' }}">
                        Penjualan Bulanan
                    </a>
                    <a href="{{ route('laporan.index', ['tab' => 'komisi-bulanan']) }}" class="list-group-item list-group-item-action {{ $tab == 'komisi-bulanan' ? 'active' : '' }}">
                        Komisi Bulanan
                    </a>
                    <a href="{{ route('laporan.index', ['tab' => 'stok-gudang']) }}" class="list-group-item list-group-item-action {{ $tab == 'stok-gudang' ? 'active' : '' }}">
                        Stok Gudang
                    </a>
                    <a href="{{ route('laporan.index', ['tab' => 'penjualan-kategori']) }}" class="list-group-item list-group-item-action {{ $tab == 'penjualan-kategori' ? 'active' : '' }}">
                        Penjualan Kategori
                    </a>
                    <a href="{{ route('laporan.index', ['tab' => 'masa-penitipan-habis']) }}" class="list-group-item list-group-item-action {{ $tab == 'masa-penitipan-habis' ? 'active' : '' }}">
                        Barang yang Masa Penitipannya Habis
                    </a>
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
                    @elseif($tab == 'request')
                        Laporan Request Donasi
                    @elseif($tab == 'penjualan-bulanan')
                        Laporan Penjualan Bulanan Keseluruhan
                    @elseif($tab == 'stok-gudang')
                        Laporan Stok Gudang
                    @elseif($tab == 'penjualan-kategori')
                        Laporan Penjualan Per Kategori Barang
                    @elseif($tab == 'masa-penitipan-habis')
                        Laporan Barang yang Masa Penitipannya Sudah Habis
                    @elseif($tab == 'komisi-bulanan')
                        Laporan Komisi Bulanan per Produk
                    @else
                        Laporan
                    @endif
                </div>
                <div class="card-body">
                    {{-- Bagian Laporan Penjualan Bulanan --}}
                    @if($tab == 'penjualan-bulanan')
                        <div class="mb-3">
                            <h4 class="float-left">ReUseMart</h4>
                            <div style="clear: both;"></div>
                            <div>Jl. Green Eco Park No. 456 Yogyakarta</div>
                        </div>
                        <div class="mb-2"></div>
                        <div>
                            <h4>LAPORAN PENJUALAN BULANAN</h4>
                            Tahun : {{ $selectedYear }}<br>
                            Tanggal Cetak : {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}
                        </div>
                        <br>
                        <form id="penjualanBulananForm" action="{{ route('laporan.index') }}" method="GET" class="mb-4">
                            <input type="hidden" name="tab" value="penjualan-bulanan">
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <label for="yearSelect" class="col-form-label">Pilih Tahun:</label>
                                </div>
                                <div class="col-auto">
                                    <select name="year" id="yearSelect" class="form-select">
                                        @php
                                            $currentYear = date('Y');
                                            $startYear = 2020;
                                        @endphp
                                        @for ($year = $currentYear; $year >= $startYear; $year--)
                                            <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>{{ $year }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">Tampilkan</button>
                                </div>
                            </div>
                        </form>
                        @if(isset($monthlySales) && $monthlySales->count() > 0)
                            <table class="table table-bordered table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>Bulan</th>
                                        <th>Jumlah Barang Terjual</th>
                                        <th>Jumlah Penjualan Kotor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalItemsSold = 0;
                                        $totalGrossSales = 0;
                                        $monthNames = [
                                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                        ];
                                    @endphp
                                    @foreach($monthlySales as $data)
                                        <tr>
                                            <td>{{ $monthNames[$data->month] }}</td>
                                            <td>{{ $data->total_items_sold }}</td>
                                            <td>Rp{{ number_format($data->total_gross_sales, 0, ',', '.') }}</td>
                                        </tr>
                                        @php
                                            $totalItemsSold += $data->total_items_sold;
                                            $totalGrossSales += $data->total_gross_sales;
                                        @endphp
                                    @endforeach
                                    @for ($i = 1; $i <= 12; $i++)
                                        @if (!in_array($i, $monthlySales->pluck('month')->toArray()))
                                            <tr>
                                                <td>{{ $monthNames[$i] }}</td>
                                                <td>...</td>
                                                <td>...</td>
                                            </tr>
                                        @endif
                                    @endfor
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th>{{ $totalItemsSold }}</th>
                                        <th>Rp{{ number_format($totalGrossSales, 0, ',', '.') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="mt-3">
                                {{-- Tombol Cetak PDF yang akan memicu JS --}}
                                <button type="button" id="cetakPenjualanBulananPdf" class="btn btn-primary">
                                    Cetak PDF
                                </button>
                                {{-- HIDDEN FORM DENGAN METHOD POST --}}
                                <form id="formCetakPenjualanBulananPdf" action="{{ route('laporan.penjualan_bulanan.pdf') }}" method="POST" target="_blank" style="display: none;">
                                    @csrf {{-- Penting: Tambahkan CSRF token untuk POST requests --}}
                                    <input type="hidden" name="year" value="{{ $selectedYear }}">
                                    <input type="hidden" name="chart_image" id="chartImageInput">
                                </form>
                            </div>
                            <h5 class="mt-5 mb-3">Grafik Penjualan Bulanan</h5>
                            <div class="chart-container" style="position: relative; height:400px; width:100%">
                                <canvas id="monthlySalesChart"></canvas>
                            </div>
                        @else
                            <div class="alert alert-info">
                                Tidak ada data penjualan bulanan untuk tahun {{ $selectedYear }}.
                            </div>
                        @endif

                    {{-- Bagian Laporan Komisi Bulanan per Produk --}}
                    @elseif($tab == 'komisi-bulanan')
                        <div class="mb-3">
                            <h4 class="float-left">ReUseMart</h4>
                            <div style="clear: both;"></div>
                            <div>Jl. Green Eco Park No. 456 Yogyakarta</div>
                        </div>

                        <div class="mb-2"></div>

                        <div>
                            <h4>LAPORAN KOMISI BULANAN</h4>
                            Bulan : {{ \Carbon\Carbon::create(null, $selectedMonth, 1)->locale('id')->isoFormat('MMMM') }}<br>
                            Tahun : {{ $selectedYear }}<br>
                            Tanggal Cetak : {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}
                        </div>

                        <br>

                        <form action="{{ route('laporan.index') }}" method="GET" class="mb-4">
                            <input type="hidden" name="tab" value="komisi-bulanan">
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <label for="monthSelect" class="col-form-label">Pilih Bulan:</label>
                                </div>
                                <div class="col-auto">
                                    <select name="month" id="monthSelect" class="form-select">
                                        @php
                                            $monthNames = [
                                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                            ];
                                        @endphp
                                        @foreach($monthNames as $num => $name)
                                            <option value="{{ $num }}" {{ $num == $selectedMonth ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <label for="yearSelect" class="col-form-label">Pilih Tahun:</label>
                                </div>
                                <div class="col-auto">
                                    <select name="year" id="yearSelect" class="form-select">
                                        @php
                                            $currentYear = date('Y');
                                            $startYear = 2020;
                                        @endphp
                                        @for ($year = $currentYear; $year >= $startYear; $year--)
                                            <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>{{ $year }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">Tampilkan</button>
                                </div>
                            </div>
                        </form>

                        @if(isset($monthlyCommissionList) && $monthlyCommissionList->count() > 0)
                            <table class="table table-bordered table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kode Produk</th>
                                        <th>Nama Produk</th>
                                        <th>Harga Jual</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Tanggal Laku</th>
                                        <th>Komisi Hunter</th>
                                        <th>Komisi ReUse Mart</th>
                                        <th>Bonus Penitip</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalHargaJual = 0;
                                        $totalKomisiHunter = 0;
                                        $totalKomisiReuseMart = 0;
                                        $totalBonusPenitip = 0;
                                    @endphp
                                    @foreach($monthlyCommissionList as $item)
                                        <tr>
                                            <td>{{ $item->barang->id_barang ?? '-' }}</td>
                                            <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                                            <td>Rp{{ number_format($item->barang->harga_barang ?? 0, 0, ',', '.') }}</td>
                                            <td>{{ $item->barang->tanggal_masuk ? \Carbon\Carbon::parse($item->barang->tanggal_masuk)->format('d/m/Y') : '-' }}</td>
                                            <td>{{ $item->transaksi->tanggal_transaksi ? \Carbon\Carbon::parse($item->transaksi->tanggal_transaksi)->format('d/m/Y') : '-' }}</td>
                                            <td>Rp{{ number_format($item->barang->komisi_hunter ?? 0, 0, ',', '.') }}</td>
                                            <td>Rp{{ number_format($item->barang->komisi_reusemart ?? 0, 0, ',', '.') }}</td>
                                            <td>Rp{{ number_format($item->barang->bonus_penitip ?? 0, 0, ',', '.') }}</td>
                                        </tr>
                                        @php
                                            $totalHargaJual += $item->barang->harga_barang ?? 0;
                                            $totalKomisiHunter += $item->barang->komisi_hunter ?? 0;
                                            $totalKomisiReuseMart += $item->barang->komisi_reusemart ?? 0;
                                            $totalBonusPenitip += $item->barang->bonus_penitip ?? 0;
                                        @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th></th>
                                        <th>Rp{{ number_format($totalHargaJual, 0, ',', '.') }}</th>
                                        <th></th>
                                        <th></th>
                                        <th>Rp{{ number_format($totalKomisiHunter, 0, ',', '.') }}</th>
                                        <th>Rp{{ number_format($totalKomisiReuseMart, 0, ',', '.') }}</th>
                                        <th>Rp{{ number_format($totalBonusPenitip, 0, ',', '.') }}</th>
                                    </tr>
                                </tfoot>
                            </table>

                            <div class="mt-3">
                                <a href="{{ route('laporan.komisi_bulanan.pdf', ['month' => $selectedMonth, 'year' => $selectedYear]) }}" target="_blank" class="btn btn-primary">
                                    Cetak PDF
                                </a>
                            </div>
                        @else
                            <div class="alert alert-info">
                                Tidak ada data komisi untuk bulan {{ \Carbon\Carbon::create(null, $selectedMonth, 1)->locale('id')->isoFormat('MMMM') }} tahun {{ $selectedYear }}.
                            </div>
                        @endif

                    {{-- Bagian Laporan Stok Gudang --}}
                    @elseif($tab == 'stok-gudang')
                        <div class="mb-3">
                            <h4 class="float-left">ReUseMart</h4>
                            <div style="clear: both;"></div>
                            <div>Jl. Green Eco Park No. 456 Yogyakarta</div>
                        </div>
                        <div class="mb-2"></div>
                        <div>
                            <h4>LAPORAN Stok Gudang</h4>
                            Tanggal Cetak : {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}
                        </div>
                        <div class="alert alert-info mt-3" style="float: right; margin-left: 15px; width: 40%;">
                            Stok yang bisa dilihat adalah stok per hari ini (sama dengan tanggal cetak). Tidak bisa dilihat stok yang kemarin-kemarin.
                        </div>
                        <div style="clear: both;"></div>
                        <br>
                        @if(isset($stokGudangList) && $stokGudangList->count() > 0)
                            <table class="table table-bordered table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kode Produk</th>
                                        <th>Nama Produk</th>
                                        <th>Id Penitip</th>
                                        <th>Nama Penitip</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Perpanjangan</th>
                                        <th>ID Hunter</th>
                                        <th>Nama Hunter</th>
                                        <th>Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stokGudangList as $barang)
                                        <tr>
                                            <td>{{ $barang->id_barang ?? '-' }}</td>
                                            <td>{{ $barang->nama_barang ?? '-' }}</td>
                                            <td>{{ $barang->penitipan->penitip->id_penitip ?? '-' }}</td>
                                            <td>{{ $barang->penitipan->penitip->nama_penitip ?? '-' }}</td>
                                            <td>{{ $barang->tanggal_masuk ? \Carbon\Carbon::parse($barang->tanggal_masuk)->format('d/m/Y') : '-' }}</td>
                                            <td>{{ $barang->status_perpanjangan ? 'Ya' : 'Tidak' }}</td>
                                            <td>{{ $barang->penitipan->id_hunter ?? '-' }}</td>
                                            <td>{{ $barang->penitipan->hunter->nama_pegawai ?? '-' }}</td>
                                            <td>Rp{{ number_format($barang->harga_barang ?? 0, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3">
                                <a href="{{ route('laporan.stok_gudang.pdf') }}" target="_blank" class="btn btn-primary">
                                    Cetak PDF
                                </a>
                            </div>
                        @else
                            <div class="alert alert-info">
                                Tidak ada data stok barang di gudang.
                            </div>
                        @endif

                    {{-- Bagian Laporan Penjualan Per Kategori Barang --}}
                    @elseif($tab == 'penjualan-kategori')
                        <div class="mb-3">
                            <h4 class="float-left">ReUseMart</h4>
                            <div style="clear: both;"></div>
                            <div>Jl. Green Eco Park No. 456 Yogyakarta</div>
                        </div>
                        <div class="mb-2"></div>
                        <div>
                            <h4>LAPORAN PENJUALAN PER KATEGORI BARANG</h4>
                            Tahun : {{ $selectedYear }}<br>
                            Tanggal Cetak : {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}
                        </div>
                        <br>
                        <form action="{{ route('laporan.index') }}" method="GET" class="mb-4">
                            <input type="hidden" name="tab" value="penjualan-kategori">
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <label for="yearSelect" class="col-form-label">Pilih Tahun:</label>
                                </div>
                                <div class="col-auto">
                                    <select name="year" id="yearSelect" class="form-select">
                                        @php
                                            $currentYear = date('Y');
                                            $startYear = 2020;
                                        @endphp
                                        @for ($year = $currentYear; $year >= $startYear; $year--)
                                            <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>{{ $year }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">Tampilkan</button>
                                </div>
                            </div>
                        </form>
                        @if(isset($categorySales) && $categorySales->count() > 0)
                            <table class="table table-bordered table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kategori</th>
                                        <th>Jumlah item terjual</th>
                                        <th>Jumlah item gagal terjual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalTerjual = 0;
                                        $totalGagalTerjual = 0;
                                    @endphp
                                    @foreach($allCategories as $category)
                                        @php
                                            $data = $categorySales->firstWhere('id_kategori', $category->id_kategori);
                                            $terjual = $data ? $data->total_terjual : 0;
                                            $gagalTerjual = $data ? $data->total_gagal_terjual : 0;
                                            $totalTerjual += $terjual;
                                            $totalGagalTerjual += $gagalTerjual;
                                        @endphp
                                        <tr>
                                            <td>{{ $category->nama_kategori ?? '-' }}</td>
                                            <td>{{ $terjual }}</td>
                                            <td>{{ $gagalTerjual }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th>{{ $totalTerjual }}</th>
                                        <th>{{ $totalGagalTerjual }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="mt-3">
                                <a href="{{ route('laporan.penjualan_kategori.pdf', ['year' => $selectedYear]) }}" target="_blank" class="btn btn-primary">
                                    Cetak PDF
                                </a>
                            </div>
                        @else
                            <div class="alert alert-info">
                                Tidak ada data penjualan per kategori untuk tahun {{ $selectedYear }}.
                            </div>
                        @endif

                    {{-- Bagian Laporan Barang yang Masa Penitipannya Sudah Habis --}}
                    @elseif($tab == 'masa-penitipan-habis')
                        <div class="mb-3">
                            <h4 class="float-left">ReUseMart</h4>
                            <div style="clear: both;"></div>
                            <div>Jl. Green Eco Park No. 456 Yogyakarta</div>
                        </div>

                        <div class="mb-2"></div>

                        <div>
                            <h4>LAPORAN Barang yang Masa Penitipannya Sudah Habis</h4>
                            Tanggal Cetak : {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}
                        </div>

                        <br>

                        @if(isset($expiredConsignmentList) && $expiredConsignmentList->count() > 0)
                            <table class="table table-bordered table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kode Produk</th>
                                        <th>Nama Produk</th>
                                        <th>Id Penitip</th>
                                        <th>Nama Penitip</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Tanggal Akhir</th>
                                        <th>Batas Ambil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($expiredConsignmentList as $barang)
                                        <tr>
                                            <td>{{ $barang->id_barang ?? '-' }}</td>
                                            <td>{{ $barang->nama_barang ?? '-' }}</td>
                                            <td>{{ $barang->penitipan->penitip->id_penitip ?? '-' }}</td>
                                            <td>{{ $barang->penitipan->penitip->nama_penitip ?? '-' }}</td>
                                            <td>{{ $barang->tanggal_masuk ? \Carbon\Carbon::parse($barang->tanggal_masuk)->format('d/m/Y') : '-' }}</td>
                                            <td>{{ $barang->penitipan->tenggat_waktu ? \Carbon\Carbon::parse($barang->penitipan->tenggat_waktu)->format('d/m/Y') : '-' }}</td>
                                            <td>{{ $barang->tanggal_ambil ? \Carbon\Carbon::parse($barang->tanggal_ambil)->format('d/m/Y') : '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="mt-3">
                                <a href="{{ route('laporan.masa_penitipan_habis.pdf') }}" target="_blank" class="btn btn-primary">
                                    Cetak PDF
                                </a>
                            </div>
                        @else
                            <div class="alert alert-info">
                                Tidak ada barang yang masa penitipannya sudah habis.
                            </div>
                        @endif

                    {{-- Bagian Laporan Donasi Barang --}}
                    @elseif($tab == 'donasi')
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
                                            <td>{{ $donasi->tanggal_donasi ? \Carbon\Carbon::parse($donasi->tanggal_donasi)->format('d/m/Y') : '-' }}</td>
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
                    {{-- Bagian Laporan Request Donasi --}}
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log("DOMContentLoaded fired."); // Log baru: Konfirmasi DOMContentLoaded

        // Logika untuk Laporan Penjualan Bulanan (Grafik)
        const monthlySalesChartCanvas = document.getElementById('monthlySalesChart');
        // Log baru: Cek apakah elemen canvas ditemukan
        console.log("monthlySalesChartCanvas element:", monthlySalesChartCanvas); 
        let myChart; // Variabel untuk menyimpan instance chart

        if (monthlySalesChartCanvas) {
            console.log("monthlySalesChartCanvas found. Attempting to draw chart."); // Log baru: Canvas ditemukan
            
            const chartData = @json($chartData ?? []); // Pastikan variabel ini ada dari controller
            console.log("Chart Data from PHP:", chartData); // Log baru: Cek data dari PHP

            const labels = chartData.map(data => {
                const date = new Date();
                date.setMonth(data.month - 1); // Bulan di JS 0-indexed
                return date.toLocaleString('id-ID', { month: 'short' }); // Nama bulan singkat
            });
            const salesAmounts = chartData.map(data => data.total_gross_sales);

            try { // Tambahkan try-catch untuk inisialisasi chart
                myChart = new Chart(monthlySalesChartCanvas, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Penjualan Kotor (Rp)',
                            data: salesAmounts,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Jumlah Penjualan Kotor (Rp)'
                                },
                                ticks: {
                                    callback: function(value, index, values) {
                                        return 'Rp' + value.toLocaleString('id-ID'); // Format mata uang
                                    }
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Bulan'
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': Rp' + context.raw.toLocaleString('id-ID');
                                    }
                                }
                            }
                        }
                    }
                });
                console.log("Chart successfully initialized.", myChart); // Log baru: Chart berhasil
            } catch (e) {
                console.error("Error initializing Chart.js:", e); // Log Error: Jika ada masalah dengan Chart.js
            }


            // --- Logika untuk Tombol Cetak PDF Grafik ---
            const cetakPdfButton = document.getElementById('cetakPenjualanBulananPdf');
            // Log baru: Cek apakah tombol ditemukan
            console.log("cetakPenjualanBulananPdf button:", cetakPdfButton); 
            
            if (cetakPdfButton) {
                console.log("Attaching event listener to cetakPenjualanBulananPdf button."); // Log baru: Event listener ditambahkan
                cetakPdfButton.addEventListener('click', function() {
                    console.log("Cetak PDF button clicked."); // Log baru: Tombol diklik
                    if (myChart) {
                        console.log("myChart instance found, proceeding with image capture."); // Log baru: myChart ada
                        // Dapatkan data URL gambar dari canvas
                        const chartImage = monthlySalesChartCanvas.toDataURL('image/png', 1.0); // 'image/png', kualitas 1.0 untuk terbaik
                        
                        // Set nilai ke input hidden
                        document.getElementById('chartImageInput').value = chartImage;
                        console.log("chartImageInput value set. Length:", chartImage.length); // Log baru: Value diset
                        
                        // Submit form untuk PDF
                        document.getElementById('formCetakPenjualanBulananPdf').submit();
                        console.log("Form submitted."); // Log baru: Form di-submit
                    } else {
                        console.warn('Grafik belum siap (myChart is null/undefined). Mohon tunggu sebentar.'); // Peringatan
                        alert('Grafik belum siap. Mohon tunggu sebentar.');
                    }
                });
            } else {
                console.warn("Cetak PDF button not found. Event listener not attached."); // Peringatan: Tombol tidak ditemukan
            }
        } else {
            console.warn("monthlySalesChartCanvas element not found. Chart will not be drawn."); // Peringatan: Canvas tidak ditemukan
        }

        // Logic for 'countdown' element (existing warning, can be removed)
        const countdownEl = document.getElementById('countdown');
        if (!countdownEl) {
            console.warn("Element with ID 'countdown' not found. Countdown script will not run.");
        }
    });
</script>
@endpush