@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8"> {{-- Replaced container-fluid with Tailwind equivalent --}}
    <div class="flex flex-wrap -mx-3"> {{-- Replaced row with flex and negative margin --}}
        <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0"> {{-- Replaced col-md-3 with w-1/4 and padding --}}
            <div class="bg-white rounded-lg shadow-md overflow-hidden"> {{-- Replaced card with Tailwind styling --}}
                <div class="bg-gray-800 text-white px-4 py-3 font-semibold"> {{-- Replaced card-header bg-dark text-white --}}
                    Menu Laporan
                </div>
                <div class="divide-y divide-gray-200"> {{-- Replaced list-group list-group-flush --}}
                    <a href="{{ route('laporan.index', ['tab' => 'donasi']) }}" class="block px-4 py-3 text-gray-700 hover:bg-gray-100 transition-colors duration-200"> {{-- Replaced list-group-item --}}
                        Donasi Barang
                    </a>
                    <a href="{{ route('laporan.index', ['tab' => 'request']) }}" class="block px-4 py-3 text-gray-700 hover:bg-gray-100 transition-colors duration-200"> {{-- Replaced list-group-item --}}
                        Request Donasi
                    </a>
                    <a href="{{ route('laporan.penitip') }}" class="block px-4 py-3 bg-red-600 text-white font-semibold"> {{-- Replaced list-group-item active --}}
                        Data Penitip
                    </a>
                </div>
            </div>

            <div class="mt-6"> {{-- Replaced mt-3 --}}
                <a href="{{ route('dashboard.owner') }}" class="w-full inline-block bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-4 rounded-lg text-center transition-colors duration-200"> {{-- Replaced btn btn-secondary w-100 --}}
                    &larr; Kembali ke Dashboard
                </a>
            </div>
        </div>

        <div class="w-full md:w-3/4 px-3"> {{-- Replaced col-md-9 with w-3/4 and padding --}}
            <div class="bg-white rounded-lg shadow-md overflow-hidden"> {{-- Replaced card --}}
                <div class="bg-gray-800 text-white px-4 py-3 font-semibold"> {{-- Replaced card-header --}}
                    Laporan Transaksi Penitip
                </div>
                <div class="p-6"> {{-- Replaced card-body with padding --}}
                    <form action="{{ route('laporan.penitip') }}" method="GET" class="mb-8"> {{-- Increased mb --}}
                        <div class="flex flex-wrap -mx-3 items-end"> {{-- Replaced row with flex, negative margin, and align-items-end --}}
                            <div class="w-full md:w-1/4 px-3 mb-4 md:mb-0"> {{-- Replaced col-md-4 --}}
                                <label for="penitip" class="block text-gray-700 text-sm font-bold mb-2">Pilih Penitip</label>
                                <select name="penitip" id="penitip" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-red-500" required> {{-- Replaced form-select with Tailwind form styles --}}
                                    <option value="">-- Pilih Penitip --</option>
                                    @foreach($penitipList as $p)
                                        <option value="{{ $p->id_penitip }}" {{ request('penitip') == $p->id_penitip ? 'selected' : '' }}>
                                            {{ $p->nama_penitip }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-full md:w-1/5 px-3 mb-4 md:mb-0"> {{-- Replaced col-md-3 --}}
                                <label for="bulan" class="block text-gray-700 text-sm font-bold mb-2">Bulan</label>
                                <select name="bulan" id="bulan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-red-500" required>
                                    <option value="">-- Pilih Bulan --</option>
                                    @for($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create()->month($m)->locale('id')->isoFormat('MMMM') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="w-full md:w-1/5 px-3 mb-4 md:mb-0"> {{-- Replaced col-md-3 --}}
                                <label for="tahun" class="block text-gray-700 text-sm font-bold mb-2">Tahun</label>
                                <select name="tahun" id="tahun" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-red-500" required>
                                    @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                                        <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="w-full md:w-1/4 px-3 mb-4 md:mb-0"> {{-- Replaced col-md-2 with a slightly larger width --}}
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">Tampilkan</button> {{-- Replaced btn btn-primary --}}
                            </div>
                        </div>
                    </form>

                    @if(isset($barangs) && count($barangs) > 0)
                        <div class="mb-4"> {{-- Replaced mb-3 --}}
                            <a href="{{ route('laporan.printPenitip', ['penitip' => request('penitip'), 'bulan' => request('bulan'), 'tahun' => request('tahun')]) }}" target="_blank" class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition-colors duration-200"> {{-- Replaced btn btn-danger --}}
                                <i class="fas fa-print mr-2"></i> Cetak PDF
                            </a>
                        </div>
                        <div class="overflow-x-auto"> {{-- Added for responsive table --}}
                            <table class="min-w-full bg-white border border-gray-300"> {{-- Replaced table table-bordered table-striped --}}
                                <thead class="bg-gray-100"> {{-- Replaced table-light --}}
                                    <tr>
                                        <th class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-700">Kode Produk</th>
                                        <th class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-700">Nama Produk</th>
                                        <th class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-700">Tanggal Masuk</th>
                                        <th class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-700">Tanggal Laku</th>
                                        <th class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-700">Harga Jual Bersih</th>
                                        <th class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-700">Bonus Terjual Cepat</th>
                                        <th class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-700">Pendapatan</th>
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
                                                // Ensure tanggal_keluar is after tanggal_masuk for bonus calculation
                                                if ($tanggalKeluar->greaterThan($tanggalMasuk)) {
                                                    $selisihHari = $tanggalMasuk->diffInDays($tanggalKeluar); // diffInDays calculates absolute difference by default
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
                                            <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ $barang->id_barang }}</td>
                                            <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ $barang->nama_barang }}</td>
                                            <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ \Carbon\Carbon::parse($barang->tanggal_masuk)->format('d M Y') }}</td>
                                            <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ $barang->tanggal_keluar ? \Carbon\Carbon::parse($barang->tanggal_keluar)->format('d M Y') : '-' }}</td>
                                            <td class="py-2 px-4 border-b border-gray-200 text-sm">Rp {{ number_format($hargaJualBersih, 0, ',', '.') }}</td>
                                            <td class="py-2 px-4 border-b border-gray-200 text-sm">Rp {{ number_format($bonusCepat, 0, ',', '.') }}</td>
                                            <td class="py-2 px-4 border-b border-gray-200 text-sm">Rp {{ number_format($pendapatan, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="bg-gray-50">
                                        <td colspan="4" class="py-2 px-4 border-b text-right font-bold text-gray-800">Total</td> {{-- Adjusted colspan and alignment --}}
                                        <td class="py-2 px-4 border-b font-bold text-gray-800">Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
                                        <td class="py-2 px-4 border-b font-bold text-gray-800">Rp {{ number_format($totalBonus, 0, ',', '.') }}</td>
                                        <td class="py-2 px-4 border-b font-bold text-gray-800">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @elseif(request()->filled(['penitip', 'bulan', 'tahun']))
                        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert"> {{-- Replaced alert alert-info --}}
                            Tidak ada transaksi untuk penitip ini pada bulan dan tahun yang dipilih.
                        </div>
                    @else
                        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert"> {{-- Replaced alert alert-info --}}
                            Silakan pilih penitip, bulan, dan tahun untuk melihat laporan.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection