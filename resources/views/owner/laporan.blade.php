@extends('layouts.app') {{-- Pastikan layout ini mengimpor Tailwind CSS --}}

@section('content')
<div class="container mx-auto px-4 py-6"> {{-- mx-auto untuk centering, px-4 py-6 untuk padding --}}
    <div class="flex flex-wrap -mx-3"> {{-- Menggunakan flex dan flex-wrap untuk grid, -mx-3 untuk menetralkan padding kolum --}}
        <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0"> {{-- col-md-3 menjadi w-1/4 (25%) di md ke atas --}}
            <div class="bg-white shadow-md rounded-lg overflow-hidden"> {{-- Card styling --}}
                <div class="bg-gray-800 text-white px-4 py-3 font-semibold"> {{-- card-header bg-dark text-white --}}
                    Menu Laporan
                </div>
                <nav class="flex flex-col"> {{-- list-group list-group-flush --}}
                    <a href="{{ route('laporan.index', ['tab' => 'penjualan-bulanan']) }}" class="block px-4 py-2 text-gray-800 hover:bg-red-100 hover:text-red-700 transition-colors duration-200 {{ $tab == 'penjualan-bulanan' ? 'bg-red-500 text-white hover:bg-red-600' : '' }}">
                        Penjualan Bulanan
                    </a>
                    <a href="{{ route('laporan.index', ['tab' => 'komisi-bulanan']) }}" class="block px-4 py-2 text-gray-800 hover:bg-red-100 hover:text-red-700 transition-colors duration-200 {{ $tab == 'komisi-bulanan' ? 'bg-red-500 text-white hover:bg-red-600' : '' }}">
                        Komisi Bulanan
                    </a>
                    <a href="{{ route('laporan.index', ['tab' => 'stok-gudang']) }}" class="block px-4 py-2 text-gray-800 hover:bg-red-100 hover:text-red-700 transition-colors duration-200 {{ $tab == 'stok-gudang' ? 'bg-red-500 text-white hover:bg-red-600' : '' }}">
                        Stok Gudang
                    </a>
                    <a href="{{ route('laporan.index', ['tab' => 'penjualan-kategori']) }}" class="block px-4 py-2 text-gray-800 hover:bg-red-100 hover:text-red-700 transition-colors duration-200 {{ $tab == 'penjualan-kategori' ? 'bg-red-500 text-white hover:bg-red-600' : '' }}">
                        Penjualan Kategori
                    </a>
                    <a href="{{ route('laporan.index', ['tab' => 'masa-penitipan-habis']) }}" class="block px-4 py-2 text-gray-800 hover:bg-red-100 hover:text-red-700 transition-colors duration-200 {{ $tab == 'masa-penitipan-habis' ? 'bg-red-500 text-white hover:bg-red-600' : '' }}">
                        Barang yang Masa Penitipannya Habis
                    </a>
                    <a href="{{ route('laporan.index', ['tab' => 'donasi']) }}" class="block px-4 py-2 text-gray-800 hover:bg-red-100 hover:text-red-700 transition-colors duration-200 {{ $tab == 'donasi' ? 'bg-red-500 text-white hover:bg-red-600' : '' }}">
                        Donasi Barang
                    </a>
                    <a href="{{ route('laporan.index', ['tab' => 'request']) }}" class="block px-4 py-2 text-gray-800 hover:bg-red-100 hover:text-red-700 transition-colors duration-200 {{ $tab == 'request' ? 'bg-red-500 text-white hover:bg-red-600' : '' }}">
                        Request Donasi
                    </a>
                    <a href="{{ route('laporan.penitip') }}" class="block px-4 py-2 text-gray-800 hover:bg-red-100 hover:text-red-700 transition-colors duration-200">
                        Data Penitip
                    </a>
                </nav>
            </div>

            <div class="mt-6"> {{-- mt-3 --}}
                <a href="{{ route('dashboard.owner') }}" class="block w-full text-center px-4 py-2 border border-gray-800 text-gray-800 rounded-lg text-sm hover:bg-gray-800 hover:text-white transition-colors duration-200"> {{-- btn btn-secondary w-100 --}}
                    &larr; Kembali ke Dashboard
                </a>
            </div>
        </div>

        <div class="w-full md:w-3/4 px-3"> {{-- col-md-9 menjadi w-3/4 (75%) di md ke atas --}}
            <div class="bg-white shadow-md rounded-lg overflow-hidden"> {{-- Card styling --}}
                <div class="bg-gray-800 text-white px-4 py-3 font-semibold"> {{-- card-header bg-dark text-white --}}
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
                <div class="p-4"> {{-- card-body --}}
                    {{-- Bagian Laporan Penjualan Bulanan --}}
                    @if($tab == 'penjualan-bulanan')
                        <form id="penjualanBulananForm" action="{{ route('laporan.index') }}" method="GET" class="mb-4">
                            <input type="hidden" name="tab" value="penjualan-bulanan">
                            <div class="flex items-center space-x-4 mb-4"> {{-- row g-3 align-items-center --}}
                                <div class="flex-shrink-0"> {{-- col-auto --}}
                                    <label for="yearSelect" class="block text-gray-700 text-sm font-bold mb-2">Pilih Tahun:</label> {{-- col-form-label --}}
                                </div>
                                <div class="flex-grow"> {{-- col-auto --}}
                                    <select name="year" id="yearSelect" class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-red-500"> {{-- form-select --}}
                                        @php
                                            $currentYear = date('Y');
                                            $startYear = 2020;
                                        @endphp
                                        @for ($year = $currentYear; $year >= $startYear; $year--)
                                            <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>{{ $year }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="flex-shrink-0"> {{-- col-auto --}}
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition-colors duration-200">Tampilkan</button> {{-- btn btn-primary --}}
                                </div>
                            </div>
                        </form>
                        @if(isset($monthlySales) && $monthlySales->count() > 0)
                            <div class="overflow-x-auto"> {{-- Tambahkan untuk scroll horizontal jika tabel terlalu lebar --}}
                                <table class="min-w-full divide-y divide-gray-200 border border-gray-300"> {{-- table table-bordered table-striped --}}
                                    <thead class="bg-gray-50"> {{-- table-light --}}
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bulan</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Barang Terjual</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Penjualan Kotor</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
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
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $monthNames[$data->month] }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $data->total_items_sold }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">Rp{{ number_format($data->total_gross_sales, 0, ',', '.') }}</td>
                                            </tr>
                                            @php
                                                $totalItemsSold += $data->total_items_sold;
                                                $totalGrossSales += $data->total_gross_sales;
                                            @endphp
                                        @endforeach
                                        @for ($i = 1; $i <= 12; $i++)
                                            @if (!in_array($i, $monthlySales->pluck('month')->toArray()))
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">{{ $monthNames[$i] }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">...</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">...</td>
                                                </tr>
                                            @endif
                                        @endfor
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-gray-100 font-semibold">
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Total</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">{{ $totalItemsSold }}</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Rp{{ number_format($totalGrossSales, 0, ',', '.') }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="mt-6"> {{-- mt-3 --}}
                                {{-- Tombol Cetak PDF yang akan memicu JS --}}
                                <button type="button" id="cetakPenjualanBulananPdf" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition-colors duration-200">
                                    Cetak PDF
                                </button>
                                {{-- HIDDEN FORM DENGAN METHOD POST --}}
                                <form id="formCetakPenjualanBulananPdf" action="{{ route('laporan.penjualan_bulanan.pdf') }}" method="POST" target="_blank" class="hidden"> {{-- style="display: none;" menjadi hidden --}}
                                    @csrf {{-- Penting: Tambahkan CSRF token untuk POST requests --}}
                                    <input type="hidden" name="year" value="{{ $selectedYear }}">
                                    <input type="hidden" name="chart_image" id="chartImageInput">
                                </form>
                            </div>
                            <h5 class="mt-8 mb-4 text-xl font-semibold">Grafik Penjualan Bulanan</h5> {{-- mt-5 mb-3 --}}
                            <div class="relative h-96 w-full"> {{-- chart-container, height:400px; width:100% --}}
                                <canvas id="monthlySalesChart"></canvas>
                            </div>
                        @else
                            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert"> {{-- alert alert-info --}}
                                Tidak ada data penjualan bulanan untuk tahun {{ $selectedYear }}.
                            </div>
                        @endif

                    {{-- Bagian Laporan Komisi Bulanan per Produk --}}
                    @elseif($tab == 'komisi-bulanan')
                        <form action="{{ route('laporan.index') }}" method="GET" class="mb-4">
                            <input type="hidden" name="tab" value="komisi-bulanan">
                            <div class="flex items-center space-x-4 mb-4"> {{-- row g-3 align-items-center --}}
                                <div class="flex-shrink-0">
                                    <label for="monthSelect" class="block text-gray-700 text-sm font-bold mb-2">Pilih Bulan:</label>
                                </div>
                                <div class="flex-grow">
                                    <select name="month" id="monthSelect" class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-red-500">
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
                                <div class="flex-shrink-0">
                                    <label for="yearSelect" class="block text-gray-700 text-sm font-bold mb-2">Pilih Tahun:</label>
                                </div>
                                <div class="flex-grow">
                                    <select name="year" id="yearSelect" class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-red-500">
                                        @php
                                            $currentYear = date('Y');
                                            $startYear = 2020;
                                        @endphp
                                        @for ($year = $currentYear; $year >= $startYear; $year--)
                                            <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>{{ $year }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="flex-shrink-0">
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition-colors duration-200">Tampilkan</button>
                                </div>
                            </div>
                        </form>
                        @if(isset($monthlyCommissionList) && $monthlyCommissionList->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Produk</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Jual</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Masuk</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Laku</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Komisi Hunter</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Komisi ReUse Mart</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bonus Penitip</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @php
                                            $totalHargaJual = 0;
                                            $totalKomisiHunter = 0;
                                            $totalKomisiReuseMart = 0;
                                            $totalBonusPenitip = 0;
                                        @endphp
                                        @foreach($monthlyCommissionList as $item)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->barang->id_barang ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->barang->nama_barang ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">Rp{{ number_format($item->barang->harga_barang ?? 0, 0, ',', '.') }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->barang->tanggal_masuk ? \Carbon\Carbon::parse($item->barang->tanggal_masuk)->format('d/m/Y') : '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->transaksi->tanggal_transaksi ? \Carbon\Carbon::parse($item->transaksi->tanggal_transaksi)->format('d/m/Y') : '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">Rp{{ number_format($item->barang->komisi_hunter ?? 0, 0, ',', '.') }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">Rp{{ number_format($item->barang->komisi_reusemart ?? 0, 0, ',', '.') }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">Rp{{ number_format($item->barang->bonus_penitip ?? 0, 0, ',', '.') }}</td>
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
                                        <tr class="bg-gray-100 font-semibold">
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Total</th>
                                            <th></th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Rp{{ number_format($totalHargaJual, 0, ',', '.') }}</th>
                                            <th></th>
                                            <th></th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Rp{{ number_format($totalKomisiHunter, 0, ',', '.') }}</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Rp{{ number_format($totalKomisiReuseMart, 0, ',', '.') }}</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Rp{{ number_format($totalBonusPenitip, 0, ',', '.') }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="mt-6">
                                <a href="{{ route('laporan.komisi_bulanan.pdf', ['month' => $selectedMonth, 'year' => $selectedYear]) }}" target="_blank" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition-colors duration-200">
                                    Cetak PDF
                                </a>
                            </div>
                        @else
                            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                                Tidak ada data komisi untuk bulan {{ \Carbon\Carbon::create(null, $selectedMonth, 1)->locale('id')->isoFormat('MMMM') }} tahun {{ $selectedYear }}.
                            </div>
                        @endif

                    {{-- Bagian Laporan Stok Gudang --}}
                    @elseif($tab == 'stok-gudang')
                        @if(isset($stokGudangList) && $stokGudangList->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Produk</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Id Penitip</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Penitip</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Masuk</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perpanjangan</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Hunter</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Hunter</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($stokGudangList as $barang)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $barang->id_barang ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $barang->nama_barang ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $barang->penitipan->penitip->id_penitip ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $barang->penitipan->penitip->nama_penitip ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $barang->tanggal_masuk ? \Carbon\Carbon::parse($barang->tanggal_masuk)->format('d/m/Y') : '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $barang->status_perpanjangan ? 'Ya' : 'Tidak' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $barang->penitipan->id_hunter ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $barang->penitipan->hunter->nama_pegawai ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">Rp{{ number_format($barang->harga_barang ?? 0, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-6">
                                <a href="{{ route('laporan.stok_gudang.pdf') }}" target="_blank" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition-colors duration-200">
                                    Cetak PDF
                                </a>
                            </div>
                        @else
                            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                                Tidak ada data stok barang di gudang.
                            </div>
                        @endif

                    {{-- Bagian Laporan Penjualan Per Kategori Barang --}}
                    @elseif($tab == 'penjualan-kategori')
                        <form action="{{ route('laporan.index') }}" method="GET" class="mb-4">
                            <input type="hidden" name="tab" value="penjualan-kategori">
                            <div class="flex items-center space-x-4 mb-4">
                                <div class="flex-shrink-0">
                                    <label for="yearSelect" class="block text-gray-700 text-sm font-bold mb-2">Pilih Tahun:</label>
                                </div>
                                <div class="flex-grow">
                                    <select name="year" id="yearSelect" class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-red-500">
                                        @php
                                            $currentYear = date('Y');
                                            $startYear = 2020;
                                        @endphp
                                        @for ($year = $currentYear; $year >= $startYear; $year--)
                                            <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>{{ $year }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="flex-shrink-0">
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition-colors duration-200">Tampilkan</button>
                                </div>
                            </div>
                        </form>
                        @if(isset($categorySales) && $categorySales->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah item terjual</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah item gagal terjual</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
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
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $category->nama_kategori ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $terjual }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $gagalTerjual }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-gray-100 font-semibold">
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Total</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">{{ $totalTerjual }}</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">{{ $totalGagalTerjual }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="mt-6">
                                <a href="{{ route('laporan.penjualan_kategori.pdf', ['year' => $selectedYear]) }}" target="_blank" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition-colors duration-200">
                                    Cetak PDF
                                </a>
                            </div>
                        @else
                            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                                Tidak ada data penjualan per kategori untuk tahun {{ $selectedYear }}.
                            </div>
                        @endif

                    {{-- Bagian Laporan Barang yang Masa Penitipannya Sudah Habis --}}
                    @elseif($tab == 'masa-penitipan-habis')
                        @if(isset($expiredConsignmentList) && $expiredConsignmentList->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Produk</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Id Penitip</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Penitip</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Masuk</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Akhir</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Batas Ambil</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($expiredConsignmentList as $barang)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $barang->id_barang ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $barang->nama_barang ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $barang->penitipan->penitip->id_penitip ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $barang->penitipan->penitip->nama_penitip ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $barang->tanggal_masuk ? \Carbon\Carbon::parse($barang->tanggal_masuk)->format('d/m/Y') : '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $barang->penitipan->tenggat_waktu ? \Carbon\Carbon::parse($barang->penitipan->tenggat_waktu)->format('d/m/Y') : '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $barang->tanggal_ambil ? \Carbon\Carbon::parse($barang->tanggal_ambil)->format('d/m/Y') : '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-6">
                                <a href="{{ route('laporan.masa_penitipan_habis.pdf') }}" target="_blank" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition-colors duration-200">
                                    Cetak PDF
                                </a>
                            </div>
                        @else
                            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                                Tidak ada barang yang masa penitipannya sudah habis.
                            </div>
                        @endif

                    {{-- Bagian Laporan Donasi Barang --}}
                    @elseif($tab == 'donasi')
                        <form method="GET" action="{{ route('laporan.index') }}" class="mb-4">
                            <div class="flex items-center space-x-4 mb-4">
                                <div class="flex-shrink-0">
                                    <label for="tahun" class="block text-gray-700 text-sm font-bold mb-2">Pilih Tahun:</label>
                                </div>
                                <div class="flex-grow">
                                    <select name="tahun" id="tahun" class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-red-500" onchange="this.form.submit()">
                                        @php
                                            $currentYear = date('Y');
                                            $startYear = $currentYear - 5; // Sesuaikan rentang tahun
                                        @endphp
                                        @for($year = $currentYear; $year >= $startYear; $year--)
                                            <option value="{{ $year }}" {{ $tahun == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <input type="hidden" name="tab" value="{{ $tab }}">
                            </div>
                        </form>
                        @if(isset($donasiList) && $donasiList->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Produk</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Id Penitip</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Penitip</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Donasi</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Organisasi</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Penerima</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($donasiList as $donasi)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $donasi->barang->id_barang ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $donasi->barang->nama_barang ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $donasi->barang->penitipan->id_penitip ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $donasi->barang->penitipan->penitip->nama_penitip ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $donasi->tanggal_donasi ? \Carbon\Carbon::parse($donasi->tanggal_donasi)->format('d/m/Y') : '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $donasi->request && $donasi->request->organisasi ? $donasi->request->organisasi->nama_organisasi : '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $donasi->nama_penerima ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-6">
                                <a href="{{ route('laporan.donasi.pdf', ['tahun' => $tahun]) }}" target="_blank" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition-colors duration-200">
                                    Cetak PDF
                                </a>
                            </div>
                        @else
                            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                                Tidak ada data donasi barang.
                            </div>
                        @endif

                    {{-- Bagian Laporan Request Donasi --}}
                    @elseif($tab == 'request')
                        @if(isset($requestDonasiList) && $requestDonasiList->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Organisasi</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Request</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($requestDonasiList as $request)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $request->organisasi->id_organisasi ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $request->organisasi->nama_organisasi ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $request->organisasi->alamat_organisasi ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $request->keterangan_request ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-6">
                                <a href="{{ route('laporan.request.pdf') }}" target="_blank" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition-colors duration-200">
                                    Cetak PDF
                                </a>
                            </div>
                        @else
                            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
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
{{-- Perhatikan: Pastikan Bootstrap JS tidak bentrok jika sudah ada di layout.app --}}
{{-- Jika layout.app sudah punya Bootstrap, ini bisa dihapus atau pastikan tidak ada duplikasi. --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}

{{-- Chart.js tetap diperlukan untuk grafik --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log("DOMContentLoaded fired.");

        const monthlySalesChartCanvas = document.getElementById('monthlySalesChart');
        console.log("monthlySalesChartCanvas element:", monthlySalesChartCanvas);
        let myChart;

        if (monthlySalesChartCanvas) {
            console.log("monthlySalesChartCanvas found. Attempting to draw chart.");

            // Pastikan data dikirim dengan benar dari controller
            const chartData = @json($chartData ?? []);
            console.log("Chart Data from PHP:", chartData);

            // Periksa apakah chartData kosong atau tidak
            if (chartData.length > 0) {
                const labels = chartData.map(data => {
                    const date = new Date();
                    date.setMonth(data.month - 1); // Bulan di JS 0-indexed
                    return date.toLocaleString('id-ID', { month: 'short' }); // Nama bulan singkat
                });
                const salesAmounts = chartData.map(data => data.total_gross_sales);

                try {
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
                    console.log("Chart successfully initialized.", myChart);
                } catch (e) {
                    console.error("Error initializing Chart.js:", e);
                }
            } else {
                console.warn("chartData is empty. Chart will not be drawn.");
                // Opsional: Sembunyikan canvas jika tidak ada data
                monthlySalesChartCanvas.style.display = 'none';
                // Opsional: Tampilkan pesan di bawah canvas
                const chartContainer = monthlySalesChartCanvas.closest('.relative');
                if (chartContainer) {
                    const noDataMessage = document.createElement('div');
                    noDataMessage.className = 'bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mt-4';
                    noDataMessage.textContent = 'Tidak ada data untuk menampilkan grafik penjualan bulanan.';
                    chartContainer.parentNode.insertBefore(noDataMessage, chartContainer.nextSibling);
                }
            }


            // --- Logika untuk Tombol Cetak PDF Grafik ---
            const cetakPdfButton = document.getElementById('cetakPenjualanBulananPdf');
            console.log("cetakPenjualanBulananPdf button:", cetakPdfButton);

            if (cetakPdfButton) {
                console.log("Attaching event listener to cetakPenjualanBulananPdf button.");
                cetakPdfButton.addEventListener('click', function() {
                    console.log("Cetak PDF button clicked.");
                    if (myChart) {
                        console.log("myChart instance found, proceeding with image capture.");
                        // Dapatkan data URL gambar dari canvas
                        // Gunakan toBase64Image() yang lebih baik untuk Chart.js 3+
                        const chartImage = myChart.toBase64Image(); // atau monthlySalesChartCanvas.toDataURL('image/png', 1.0);
                        
                        // Set nilai ke input hidden
                        document.getElementById('chartImageInput').value = chartImage;
                        console.log("chartImageInput value set. Length:", chartImage.length);

                        // Submit form untuk PDF
                        document.getElementById('formCetakPenjualanBulananPdf').submit();
                        console.log("Form submitted.");
                    } else {
                        console.warn('Grafik belum siap (myChart is null/undefined). Mohon tunggu sebentar.');
                        alert('Grafik belum siap. Mohon tunggu sebentar.');
                    }
                });
            } else {
                console.warn("Cetak PDF button not found. Event listener not attached.");
            }
        } else {
            console.warn("monthlySalesChartCanvas element not found. Chart will not be drawn for this tab.");
        }

        // Logic for 'countdown' element (existing warning, can be removed if element is not intended)
        const countdownEl = document.getElementById('countdown');
        if (!countdownEl) {
            console.warn("Element with ID 'countdown' not found. Countdown script will not run.");
        }
    });
</script>
@endpush