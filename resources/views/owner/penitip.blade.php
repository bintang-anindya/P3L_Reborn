@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6"> {{-- container-fluid menjadi container mx-auto px-4 py-6 --}}
    <div class="flex flex-wrap -mx-3"> {{-- row menjadi flex flex-wrap -mx-3 --}}
        <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0"> {{-- col-md-3 menjadi w-full md:w-1/4 px-3 --}}
            <div class="bg-white shadow-md rounded-lg overflow-hidden"> {{-- card styling --}}
                <div class="bg-gray-800 text-white px-4 py-3 font-semibold"> {{-- card-header bg-dark text-white --}}
                    Menu Laporan
                </div>
                <nav class="flex flex-col"> {{-- list-group list-group-flush --}}
                    <a href="{{ route('laporan.index', ['tab' => 'penjualan-bulanan']) }}" class="block px-4 py-2 text-gray-800 hover:bg-red-100 hover:text-red-700 transition-colors duration-200">
                        Penjualan Bulanan
                    </a>
                    <a href="{{ route('laporan.index', ['tab' => 'komisi-bulanan']) }}" class="block px-4 py-2 text-gray-800 hover:bg-red-100 hover:text-red-700 transition-colors duration-200">
                        Komisi Bulanan
                    </a>
                    <a href="{{ route('laporan.index', ['tab' => 'stok-gudang']) }}" class="block px-4 py-2 text-gray-800 hover:bg-red-100 hover:text-red-700 transition-colors duration-200">
                        Stok Gudang
                    </a>
                    <a href="{{ route('laporan.index', ['tab' => 'penjualan-kategori']) }}" class="block px-4 py-2 text-gray-800 hover:bg-red-100 hover:text-red-700 transition-colors duration-200">
                        Penjualan Kategori
                    </a>
                    <a href="{{ route('laporan.index', ['tab' => 'masa-penitipan-habis']) }}" class="block px-4 py-2 text-gray-800 hover:bg-red-100 hover:text-red-700 transition-colors duration-200">
                        Barang yang Masa Penitipannya Habis
                    </a>
                    <a href="{{ route('laporan.index', ['tab' => 'donasi']) }}" class="block px-4 py-2 text-gray-800 hover:bg-red-100 hover:text-red-700 transition-colors duration-200">
                        Donasi Barang
                    </a>
                    <a href="{{ route('laporan.index', ['tab' => 'request']) }}" class="block px-4 py-2 text-gray-800 hover:bg-red-100 hover:text-red-700 transition-colors duration-200">
                        Request Donasi
                    </a>
                    <a href="{{ route('laporan.penitip') }}" class="block px-4 py-2 text-gray-800 hover:bg-red-100 hover:text-red-700 transition-colors duration-200 bg-red-500 text-white hover:bg-red-600"> {{-- active class for Data Penitip --}}
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

        <div class="w-full md:w-3/4 px-3"> {{-- col-md-9 menjadi w-full md:w-3/4 px-3 --}}
            <div class="bg-white shadow-md rounded-lg overflow-hidden"> {{-- card styling --}}
                <div class="bg-gray-800 text-white px-4 py-3 font-semibold"> {{-- card-header bg-dark text-white --}}
                    Laporan Transaksi Penitip
                </div>
                <div class="p-4"> {{-- card-body --}}
                    <form action="{{ route('laporan.penitip') }}" method="GET" class="mb-6"> {{-- mb-4 --}}
                        <div class="flex flex-wrap -mx-2 items-end"> {{-- row menjadi flex flex-wrap -mx-2 items-end --}}
                            <div class="w-full md:w-1/3 px-2 mb-4 md:mb-0"> {{-- col-md-4 menjadi w-full md:w-1/3 px-2 --}}
                                <label for="penitip" class="block text-gray-700 text-sm font-bold mb-2">Pilih Penitip</label> {{-- label styling --}}
                                <select name="penitip" id="penitip" class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-red-500" required> {{-- form-select styling --}}
                                    <option value="">-- Pilih Penitip --</option>
                                    @foreach($penitipList as $p)
                                        <option value="{{ $p->id_penitip }}" {{ request('penitip') == $p->id_penitip ? 'selected' : '' }}>
                                            {{ $p->nama_penitip }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4 md:mb-0"> {{-- col-md-3 menjadi w-full md:w-1/4 px-2 --}}
                                <label for="bulan" class="block text-gray-700 text-sm font-bold mb-2">Bulan</label>
                                <select name="bulan" id="bulan" class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-red-500" required>
                                    <option value="">-- Pilih Bulan --</option>
                                    @for($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create()->month($m)->locale('id')->isoFormat('MMMM') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4 md:mb-0"> {{-- col-md-3 menjadi w-full md:w-1/4 px-2 --}}
                                <label for="tahun" class="block text-gray-700 text-sm font-bold mb-2">Tahun</label>
                                <select name="tahun" id="tahun" class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-red-500" required>
                                    @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                                        <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="w-full md:w-1/5 px-2 mt-2"> {{-- col-md-2 d-flex align-items-end menjadi w-full md:w-1/5 px-2 --}}
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded w-full transition-colors duration-200">Tampilkan</button> {{-- btn btn-primary w-100 --}}
                            </div>
                        </div>
                    </form>

                    @if(isset($barangs) && count($barangs) > 0)
                        <div class="mb-4"> {{-- mb-3 --}}
                            <a href="{{ route('laporan.printPenitip', ['penitip' => request('penitip'), 'bulan' => request('bulan'), 'tahun' => request('tahun')]) }}" target="_blank" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-flex items-center transition-colors duration-200"> {{-- btn btn-danger --}}
                                <i class="fas fa-print mr-2"></i> Cetak PDF {{-- Font Awesome icon --}}
                            </a>
                        </div>
                        <div class="overflow-x-auto"> {{-- Tambahkan untuk scroll horizontal jika tabel terlalu lebar --}}
                            <table class="min-w-full divide-y divide-gray-200 border border-gray-300"> {{-- table table-bordered table-striped --}}
                                <thead class="bg-gray-50"> {{-- table-light --}}
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Produk</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Masuk</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Laku</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Jual Bersih</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bonus Terjual Cepat</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pendapatan</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
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
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $barang->id_barang }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $barang->nama_barang }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($barang->tanggal_masuk)->format('d M Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $barang->tanggal_keluar ? \Carbon\Carbon::parse($barang->tanggal_keluar)->format('d M Y') : '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($hargaJualBersih, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($bonusCepat, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($pendapatan, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="bg-gray-100 font-semibold"> {{-- fw-bold --}}
                                        <td colspan="4" class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Total</td> {{-- text-center fw-bold --}}
                                        <td class="px-6 py-3 text-xs font-bold text-gray-700 uppercase tracking-wider">Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
                                        <td class="px-6 py-3 text-xs font-bold text-gray-700 uppercase tracking-wider">Rp {{ number_format($totalBonus, 0, ',', '.') }}</td>
                                        <td class="px-6 py-3 text-xs font-bold text-gray-700 uppercase tracking-wider">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @elseif(request()->filled(['penitip', 'bulan', 'tahun']))
                        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert"> {{-- alert alert-info --}}
                            Tidak ada transaksi untuk penitip ini pada bulan dan tahun yang dipilih.
                        </div>
                    @else
                        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert"> {{-- alert alert-info --}}
                            Silakan pilih penitip, bulan, dan tahun untuk melihat laporan.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection