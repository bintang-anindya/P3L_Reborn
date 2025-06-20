@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 py-8"> {{-- Tailwind container for central alignment and padding --}}

    <div class="flex justify-start mb-6"> {{-- Replaced d-flex justify-content-start mb-3 --}}
        <form action="{{ route('dashboard.gudang') }}" method="GET">
            <button class="inline-flex items-center bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50"> {{-- Tailwind button styling --}}
                <i class="fas fa-home mr-2"></i> Kembali ke Dashboard
            </button>
        </form>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert"> {{-- Tailwind alert success --}}
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert"> {{-- Tailwind alert danger --}}
            {{ session('error') }}
        </div>
    @endif

    {{-- Tampilkan error validasi --}}
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert"> {{-- Tailwind alert danger --}}
            <ul class="mb-0 list-disc list-inside"> {{-- Tailwind list styling --}}
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h3 class="text-3xl font-bold mb-6 text-gray-800">Dashboard Gudang</h3> {{-- Tailwind heading styling --}}

    {{-- Form Penitipan --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8"> {{-- Tailwind card styling --}}
        <div class="bg-gray-800 text-white px-6 py-4 font-semibold text-lg">Input Transaksi Penitipan Barang</div> {{-- Tailwind card-header --}}
        <div class="p-6"> {{-- Tailwind card-body --}}
            <form action="{{ route('gudang.inputBarang.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_pegawai" value="4"> {{-- Assuming this is a static ID for the current user/session --}}

                <div class="mb-4"> {{-- Tailwind margin-bottom --}}
                    <label for="nama_barang" class="block text-gray-700 text-sm font-bold mb-2">Nama Barang</label> {{-- Tailwind form-label --}}
                    <input type="text" name="nama_barang" id="nama_barang" 
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-red-500
                                  @error('nama_barang') border-red-500 @enderror" 
                           value="{{ old('nama_barang') }}" required> {{-- Tailwind form-control and error styling --}}
                    @error('nama_barang')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> {{-- Tailwind invalid-feedback --}}
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="pesan" class="block text-gray-700 text-sm font-bold mb-2">Pesan</label>
                    <input type="text" name="pesan" id="pesan" 
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-red-500
                                  @error('pesan') border-red-500 @enderror" 
                           value="{{ old('pesan') }}" required>
                    @error('pesan')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Berat Barang (kg)</label> {{-- Added (kg) for clarity --}}
                    <input type="number" name="berat" 
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-red-500
                                  @error('berat') border-red-500 @enderror" 
                           value="{{ old('berat') }}" step="0.01" required> {{-- Added step for decimals --}}
                    @error('berat')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi Barang</label>
                    <textarea name="deskripsi_barang" 
                              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-red-500 h-24 resize-y
                                     @error('deskripsi_barang') border-red-500 @enderror" 
                              required>{{ old('deskripsi_barang') }}</textarea> {{-- Changed to textarea for better multi-line input --}}
                    @error('deskripsi_barang')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="harga_barang" class="block text-gray-700 text-sm font-bold mb-2">Harga Barang (Rp)</label>
                    <div class="flex items-center"> {{-- Replaced input-group --}}
                        <span class="inline-flex items-center px-3 py-2 text-gray-700 bg-gray-200 border border-gray-300 rounded-l-md">Rp</span> {{-- Tailwind input-group-text --}}
                        <input type="number" name="harga_barang" id="harga_barang" 
                               class="shadow appearance-none border rounded-r w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-red-500
                                      @error('harga_barang') border-red-500 @enderror" 
                               value="{{ old('harga_barang') }}" min="0" step="1000" required 
                               placeholder="Masukkan harga barang">
                    </div>
                    @error('harga_barang')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Masukkan harga estimasi atau nilai barang dalam Rupiah</p> {{-- Tailwind form-text --}}
                </div>

                <div class="mb-4">
                    <label for="id_kategori" class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
                    <select name="id_kategori" id="id_kategori" 
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-red-500
                                   @error('id_kategori') border-red-500 @enderror" 
                            required onchange="toggleGaransi()">
                        <option value="">-- Pilih Kategori --</option>
                        @if(isset($kategoriList) && $kategoriList->count() > 0)
                            @foreach($kategoriList as $kategori)
                                <option value="{{ $kategori->id_kategori }}" 
                                        data-nama="{{ strtolower($kategori->nama_kategori) }}"
                                        {{ old('id_kategori') == $kategori->id_kategori ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        @else
                            <option value="" disabled>Tidak ada kategori tersedia</option>
                        @endif
                    </select>
                    @error('id_kategori')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4" id="garansi-container" style="display: none;">
                    <label for="tanggal_garansi" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Garansi <span class="text-blue-500 text-xs">(Khusus Elektronik & Gadget)</span></label> {{-- Tailwind text-info --}}
                    <input type="date" name="tanggal_garansi" id="tanggal_garansi" 
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-red-500
                                  @error('tanggal_garansi') border-red-500 @enderror" 
                           value="{{ old('tanggal_garansi') }}">
                    @error('tanggal_garansi')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Field ini hanya wajib diisi untuk kategori Elektronik & Gadget</p>
                </div>

                <div class="mb-4">
                    <label for="tanggal_masuk" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" id="tanggal_masuk" 
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-red-500
                                  @error('tanggal_masuk') border-red-500 @enderror" 
                           value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required onchange="setTenggat(this.value)">
                    @error('tanggal_masuk')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="tenggat_waktu" class="block text-gray-700 text-sm font-bold mb-2">Tenggat Waktu (otomatis 30 hari)</label>
                    <input type="date" name="tenggat_waktu" id="tenggat_waktu" 
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight bg-gray-100 cursor-not-allowed" 
                           readonly value="{{ old('tenggat_waktu') }}"> {{-- Add bg-gray-100 and cursor-not-allowed for readonly --}}
                </div>

                <div class="mb-4">
                    <label for="id_hunter" class="block text-gray-700 text-sm font-bold mb-2">Hunter <span class="text-gray-500 text-xs">(Opsional)</span></label> {{-- Tailwind text-muted --}}
                    <select name="id_hunter" id="id_hunter" 
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-red-500
                                   @error('id_hunter') border-red-500 @enderror">
                        <option value="">-- Pilih Hunter (Opsional) --</option>
                        @if(isset($hunterList) && $hunterList->count() > 0)
                            @foreach($hunterList as $hunter)
                                <option value="{{ $hunter->id_pegawai }}" {{ old('id_hunter') == $hunter->id_pegawai ? 'selected' : '' }}>
                                    {{ $hunter->nama_pegawai }}
                                </option>
                            @endforeach
                        @else
                            <option value="" disabled>Tidak ada hunter tersedia</option>
                        @endif
                    </select>
                    @error('id_hunter')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Hunter adalah pegawai yang bertugas mengumpulkan/mencari barang</p>
                </div>

                <div class="mb-4">
                    <label for="gambar_barang" class="block text-gray-700 text-sm font-bold mb-2">Gambar Barang</label>
                    <input type="file" name="gambar_barang" id="gambar_barang" 
                           class="block w-full text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100
                                  @error('gambar_barang') border-red-500 @enderror" 
                           accept="image/*" required> {{-- Tailwind file input styling --}}
                    @error('gambar_barang')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF. Maksimal 2MB</p>
                </div>

                <div class="mb-4">
                    <label for="gambar_tambahan" class="block text-gray-700 text-sm font-bold mb-2">Gambar Tambahan (Max 5)</label>
                    <input type="file" name="gambar_tambahan[]" id="gambar_tambahan" 
                           class="block w-full text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100
                                  @error('gambar_tambahan') border-red-500 @enderror" 
                           multiple accept="image/*">
                    @error('gambar_tambahan')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Anda bisa memilih lebih dari satu gambar</p>
                </div>

                <div class="mb-6"> {{-- Increased margin-bottom --}}
                    <label class="block text-gray-700 text-sm font-bold mb-2">Penitip</label>
                    <select name="id_penitip" 
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-red-500
                                   @error('id_penitip') border-red-500 @enderror" 
                            required>
                        <option value="">-- Pilih Penitip --</option>
                        @foreach($penitipList as $penitip)
                            <option value="{{ $penitip->id_penitip }}">{{ $penitip->nama_penitip }}</option>
                        @endforeach
                    </select>
                    @error('id_penitip')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4 mt-6"> {{-- Replaced d-grid gap-2 d-md-flex justify-content-md-end --}}
                    <button type="reset" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50">Reset</button>
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Barang Dititipkan --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden"> {{-- Tailwind card styling --}}
        <div class="bg-gray-800 text-white px-6 py-4 font-semibold flex justify-between items-center text-lg"> {{-- Tailwind card-header and flex for alignment --}}
            <span>Data Barang Dititipkan</span>
            <div class="relative w-64"> {{-- Tailwind search-box equivalent --}}
                <form id="searchForm" method="GET" action="{{ url()->current() }}">
                    <div class="flex items-center border border-gray-300 rounded-lg focus-within:border-red-500 focus-within:ring-2 focus-within:ring-red-500 focus-within:ring-opacity-50"> {{-- Tailwind input-group --}}
                        <input type="text" name="search" class="w-full py-2 px-3 rounded-l-lg focus:outline-none text-gray-700" placeholder="Cari barang..." 
                            value="{{ request('search') }}">
                        @if(request('search'))
                            <a href="{{ url()->current() }}" class="flex-shrink-0 bg-red-500 hover:bg-red-600 text-white py-2 px-3 rounded-r-lg transition-colors duration-200"> {{-- Tailwind btn btn-outline-danger --}}
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
        <div class="p-6 overflow-x-auto"> {{-- Tailwind card-body table-responsive --}}
            <table class="min-w-full bg-white border border-gray-300"> {{-- Tailwind table styling --}}
                <thead class="bg-gray-100"> {{-- Tailwind table-light --}}
                    <tr>
                        <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">Nama Barang</th>
                        <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">Harga</th>
                        <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">Pesan</th>
                        <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">Kategori</th>
                        <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">Tanggal Masuk</th>
                        <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">Tenggat Waktu</th>
                        <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">Gambar</th>
                        <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">Penitip</th>
                        <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">QC By</th>
                        <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">Hunter</th>
                        <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($barangList) && $barangList->count() > 0)
                        @foreach($barangList as $barang)
                        <tr class="hover:bg-gray-50"> {{-- Hover effect for table rows --}}
                            <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ $barang->nama_barang ?? '-' }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm">
                                @if(isset($barang->harga_barang) && $barang->harga_barang > 0)
                                    <span class="font-bold text-green-600">Rp {{ number_format($barang->harga_barang, 0, ',', '.') }}</span> {{-- Tailwind fw-bold text-success --}}
                                @else
                                    <span class="text-gray-500">-</span> {{-- Tailwind text-muted --}}
                                @endif
                            </td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ optional($barang->penitipan)->pesan ?? '-' }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ optional($barang->kategori)->nama_kategori ?? '-' }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm">
                                @if($barang->tanggal_masuk)
                                    {{ $barang->tanggal_masuk instanceof \Carbon\Carbon ? $barang->tanggal_masuk->format('d/m/Y') : $barang->tanggal_masuk }}
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm">
                                @if($barang->tenggat_waktu)
                                    {{ $barang->tenggat_waktu instanceof \Carbon\Carbon ? $barang->tenggat_waktu->format('d/m/Y') : $barang->tenggat_waktu }}
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm">
                                @if($barang->gambar_barang && file_exists(storage_path('app/public/' . $barang->gambar_barang)))
                                    <img src="{{ asset('storage/' . $barang->gambar_barang) }}" width="100" class="w-24 h-24 object-cover rounded-md shadow-sm border border-gray-200 mb-2" alt="Gambar {{ $barang->nama_barang }}"> {{-- Tailwind img-thumbnail --}}
                                    <!-- Gambar Tambahan -->
                                    @if($barang->gambarTambahan->count() > 0)
                                        <div class="flex flex-wrap gap-2"> {{-- Replaced mb-3 row --}}
                                            @foreach($barang->gambarTambahan as $gambar)
                                                <div class="relative"> {{-- Replaced col-md-3 mb-2 position-relative --}}
                                                    <img src="{{ asset('storage/' . $gambar->path_gambar) }}" class="w-20 h-20 object-cover rounded-md shadow-sm border border-gray-200" alt="Gambar Tambahan">
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                @else
                                    <span class="text-gray-500">Tidak ada gambar</span>
                                @endif
                            </td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ optional(optional($barang->penitipan)->penitip)->nama_penitip ?? '-' }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ optional(optional($barang->penitipan)->pegawai)->nama_pegawai ?? '-' }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm">
                                @if($barang->penitipan && $barang->penitipan->id_hunter)
                                    @php
                                        $hunter = $hunterList->where('id_pegawai', $barang->penitipan->id_hunter)->first();
                                    @endphp
                                    {{ $hunter->nama_pegawai ?? '-' }}
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm space-y-2 flex flex-col items-start"> {{-- Actions column with spacing --}}
                                @if($barang->penitipan)
                                    <button class="bg-yellow-500 hover:bg-yellow-600 text-white text-xs py-1 px-3 rounded-lg transition-colors duration-200" data-bs-toggle="modal" data-bs-target="#editPenitipanModal{{ $barang->penitipan->id_penitipan }}">Edit</button>
                                    <button class="bg-red-500 hover:bg-red-600 text-white text-xs py-1 px-3 rounded-lg transition-colors duration-200" data-bs-toggle="modal" data-bs-target="#hapusPenitipanModal{{ $barang->penitipan->id_penitipan }}">Hapus</button>
                                    <a href="{{ route('penitipan.nota', $barang->penitipan->id_penitipan) }}" class="bg-blue-500 hover:bg-blue-600 text-white text-xs py-1 px-3 rounded-lg transition-colors duration-200">PDF</a>
                                @else
                                    <span class="text-gray-500">No actions</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        <tr id="no-results-row" class="hidden"> {{-- hidden class instead of style="display: none;" --}}
                            <td colspan="11" class="py-4 text-center text-gray-600">Transaksi Penitipan Barang Tidak Ditemukan!</td> {{-- Adjusted colspan --}}
                        </tr>
                    @else
                        <tr>
                            <td colspan="11" class="py-4 text-center text-gray-600">Belum ada barang dititipkan</td> {{-- Adjusted colspan --}}
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modals - Only create if penitipan exists --}}
    @if(isset($barangList) && $barangList->count() > 0)
        @foreach($barangList as $barang)
            @if($barang->penitipan)
                <!-- Modal Edit Penitipan -->
                {{-- Note: The `modal fade` and `data-bs-*` attributes still rely on Bootstrap's JavaScript or a custom JS solution that mimics its behavior. --}}
                <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-800 bg-opacity-75 transition-opacity duration-300 ease-in-out hidden" id="editPenitipanModal{{ $barang->penitipan->id_penitipan }}" tabindex="-1" aria-labelledby="editPenitipanLabel{{ $barang->penitipan->id_penitipan }}" aria-hidden="true">
                    <div class="relative bg-white rounded-lg shadow-xl max-w-4xl mx-auto w-full transform transition-all duration-300 ease-in-out scale-95 opacity-0"> {{-- Tailwind modal-dialog modal-lg --}}
                        <form action="{{ route('gudang.inputBarang.update', $barang->penitipan->id_penitipan) }}" method="POST" enctype="multipart/form-data" id="editForm{{ $barang->penitipan->id_penitipan }}">
                            @csrf
                            @method('PUT')
                            <div class="flex items-center justify-between p-4 border-b border-gray-200"> {{-- Tailwind modal-header --}}
                                <h5 class="text-xl font-semibold text-gray-800" id="editPenitipanLabel{{ $barang->penitipan->id_penitipan }}">Edit Data Penitipan & Barang</h5>
                                <button type="button" class="text-gray-500 hover:text-gray-700 text-2xl leading-none" data-bs-dismiss="modal" aria-label="Close">&times;</button> {{-- Tailwind btn-close --}}
                            </div>
                            <div class="p-6"> {{-- Tailwind modal-body --}}
                                <div class="flex flex-wrap -mx-3"> {{-- Tailwind row --}}
                                    <!-- Data Barang -->
                                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0"> {{-- Tailwind col-md-6 --}}
                                        <h5 class="text-lg font-bold mb-4 text-gray-700">Data Barang</h5>
                                        <div class="mb-4">
                                            <label for="nama_barang" class="block text-gray-700 text-sm font-bold mb-2">Nama Barang</label>
                                            <input type="text" name="nama_barang" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-red-500" value="{{ $barang->nama_barang }}" required>
                                        </div>

                                        <div class="mb-4">
                                            <label for="berat" class="block text-gray-700 text-sm font-bold mb-2">Berat (kg)</label>
                                            <input type="number" name="berat" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-red-500" step="0.01" value="{{ $barang->berat }}" required>
                                        </div>

                                        <div class="mb-4">
                                            <label for="deskripsi_barang" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                                            <textarea name="deskripsi_barang" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-red-500 h-24 resize-y" rows="3" required>{{ $barang->deskripsi_barang }}</textarea>
                                        </div>

                                        <div class="mb-4">
                                            <label for="harga_barang" class="block text-gray-700 text-sm font-bold mb-2">Harga (Rp)</label>
                                            <div class="flex items-center">
                                                <span class="inline-flex items-center px-3 py-2 text-gray-700 bg-gray-200 border border-gray-300 rounded-l-md">Rp</span>
                                                <input type="number" name="harga_barang" class="shadow appearance-none border rounded-r w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-red-500" value="{{ $barang->harga_barang }}" required>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label for="id_kategori_edit{{ $barang->id_barang }}" class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
                                            <select name="id_kategori" id="id_kategori_edit{{ $barang->id_barang }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-red-500" required onchange="toggleGaransiEdit(this, 'garansi-container-edit{{ $barang->id_barang }}', 'tanggal_garansi_edit{{ $barang->id_barang }}')">
                                            <option value="">-- Pilih Kategori --</option>
                                                @if(isset($kategoriList) && $kategoriList->count() > 0)
                                                    @foreach($kategoriList as $kategori)
                                                        <option value="{{ $kategori->id_kategori }}" 
                                                                data-nama="{{ strtolower($kategori->nama_kategori) }}"
                                                                {{ $barang->id_kategori == $kategori->id_kategori ? 'selected' : '' }}>
                                                            {{ $kategori->nama_kategori }}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option value="" disabled>Tidak ada kategori tersedia</option>
                                                @endif
                                            </select>
                                        </div>

                                        <div class="mb-4" id="garansi-container-edit{{ $barang->id_barang }}" style="display: {{ (optional($barang->kategori)->nama_kategori && (strtolower($barang->kategori->nama_kategori) == 'elektronik' || strtolower($barang->kategori->nama_kategori) == 'gadget')) ? 'block' : 'none' }};">
                                            <label for="tanggal_garansi_edit{{ $barang->id_barang }}" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Garansi <span class="text-blue-500 text-xs">(Khusus Elektronik & Gadget)</span></label>
                                            <input type="date" name="tanggal_garansi" id="tanggal_garansi_edit{{ $barang->id_barang }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-red-500" value="{{ $barang->tanggal_garansi ? (\Carbon\Carbon::parse($barang->tanggal_garansi)->format('Y-m-d')) : '' }}">
                                        </div>

                                        <div class="mb-4">
                                            <label for="gambar_barang_edit{{ $barang->id_barang }}" class="block text-gray-700 text-sm font-bold mb-2">Gambar Barang</label>
                                            <input type="file" name="gambar_barang" id="gambar_barang_edit{{ $barang->id_barang }}" class="block w-full text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                            @if($barang->gambar_barang)
                                                <p class="text-xs text-gray-500 mt-1">Gambar saat ini: 
                                                    <a href="{{ asset('storage/' . $barang->gambar_barang) }}" target="_blank" class="text-blue-600 hover:underline">Lihat</a>
                                                </p>
                                            @endif
                                        </div>

                                        <div class="mb-4">
                                            <label for="gambar_tambahan_edit{{ $barang->id_barang }}" class="block text-gray-700 text-sm font-bold mb-2">Gambar Tambahan (Max 5)</label>
                                            <input type="file" name="gambar_tambahan[]" id="gambar_tambahan_edit{{ $barang->id_barang }}" class="block w-full text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" multiple accept="image/*">
                                            @if($barang->gambarTambahan->count() > 0)
                                                <p class="text-xs text-gray-500 mt-1">Gambar saat ini: 
                                                    @foreach($barang->gambarTambahan as $gambar)
                                                        <a href="{{ asset('storage/' . $gambar->path_gambar) }}" target="_blank" class="text-blue-600 hover:underline mr-1">Lihat</a>
                                                    @endforeach
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Data Penitipan -->
                                    <div class="w-full md:w-1/2 px-3"> {{-- Tailwind col-md-6 --}}
                                        <h5 class="text-lg font-bold mb-4 text-gray-700">Data Penitipan</h5>
                                        <div class="mb-4">
                                            <label for="pesan_penitipan_edit{{ $barang->penitipan->id_penitipan }}" class="block text-gray-700 text-sm font-bold mb-2">Pesan</label>
                                            <textarea name="pesan" id="pesan_penitipan_edit{{ $barang->penitipan->id_penitipan }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-red-500 h-24 resize-y" rows="3" required>{{ $barang->penitipan->pesan }}</textarea>
                                        </div>
                                        <div class="mb-4">
                                            <label for="tanggal_masuk_penitipan_edit{{ $barang->penitipan->id_penitipan }}" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Masuk Gudang</label>
                                            <input type="date" name="tanggal_masuk" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-red-500" id="tanggal_masuk_penitipan_edit{{ $barang->penitipan->id_penitipan }}" 
                                                value="{{ $barang->penitipan->tanggal_masuk ? (\Carbon\Carbon::parse($barang->penitipan->tanggal_masuk)->format('Y-m-d')) : '' }}" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="id_penitip_edit{{ $barang->penitipan->id_penitipan }}" class="block text-gray-700 text-sm font-bold mb-2">Penitip</label>
                                            <select name="id_penitip" id="id_penitip_edit{{ $barang->penitipan->id_penitipan }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-red-500" required>
                                                @foreach($penitipList as $penitip)
                                                    <option value="{{ $penitip->id_penitip }}" {{ $barang->penitipan->id_penitip == $penitip->id_penitip ? 'selected' : '' }}>
                                                        {{ $penitip->nama_penitip }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label for="id_pegawai_edit{{ $barang->penitipan->id_penitipan }}" class="block text-gray-700 text-sm font-bold mb-2">Pegawai QC</label>
                                            <select name="id_pegawai" id="id_pegawai_edit{{ $barang->penitipan->id_penitipan }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-red-500" required>
                                                @foreach($pegawais as $pegawai)
                                                    <option value="{{ $pegawai->id_pegawai }}" {{ $barang->penitipan->id_pegawai == $pegawai->id_pegawai ? 'selected' : '' }}>
                                                        {{ $pegawai->nama_pegawai }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label for="id_hunter_penitipan_edit{{ $barang->penitipan->id_penitipan }}" class="block text-gray-700 text-sm font-bold mb-2">Hunter <span class="text-gray-500 text-xs">(Opsional)</span></label>
                                            <select name="id_hunter" id="id_hunter_penitipan_edit{{ $barang->penitipan->id_penitipan }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-red-500">
                                                <option value="">-- Pilih Hunter (Opsional) --</option>
                                                @foreach($hunterList as $hunter)
                                                    <option value="{{ $hunter->id_pegawai }}" {{ optional($barang->penitipan)->id_hunter == $hunter->id_pegawai ? 'selected' : '' }}>
                                                        {{ $hunter->nama_pegawai }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end p-4 border-t border-gray-200 space-x-3"> {{-- Tailwind modal-footer --}}
                                <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Hapus Penitipan -->
                <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-800 bg-opacity-75 transition-opacity duration-300 ease-in-out hidden" id="hapusPenitipanModal{{ $barang->penitipan->id_penitipan }}" tabindex="-1" aria-labelledby="hapusPenitipanLabel{{ $barang->penitipan->id_penitipan }}" aria-hidden="true">
                    <div class="relative bg-white rounded-lg shadow-xl max-w-lg mx-auto w-full transform transition-all duration-300 ease-in-out scale-95 opacity-0"> {{-- Tailwind modal-dialog --}}
                        <form action="{{ route('gudang.inputBarang.destroy', $barang->penitipan->id_penitipan) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="flex items-center justify-between p-4 border-b border-gray-200"> {{-- Tailwind modal-header --}}
                                <h5 class="text-xl font-semibold text-gray-800" id="hapusPenitipanLabel{{ $barang->penitipan->id_penitipan }}">Konfirmasi Hapus</h5>
                                <button type="button" class="text-gray-500 hover:text-gray-700 text-2xl leading-none" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                            </div>
                            <div class="p-6"> {{-- Tailwind modal-body --}}
                                <p class="mb-4 text-gray-700">Apakah Anda yakin ingin menghapus data penitipan milik <strong class="font-semibold">{{ optional(optional($barang->penitipan)->penitip)->nama_penitip ?? 'Unknown' }}</strong> beserta seluruh barang yang dititipkan?</p>
                                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert"> {{-- Tailwind alert alert-warning --}}
                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                    <strong class="font-semibold">Peringatan:</strong> Tindakan ini tidak dapat dibatalkan!
                                </div>
                            </div>
                            <div class="flex justify-end p-4 border-t border-gray-200 space-x-3"> {{-- Tailwind modal-footer --}}
                                <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200">
                                    <i class="fas fa-trash mr-2"></i> Hapus
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        @endforeach
    @endif

</div>

{{-- Script untuk hitung tenggat dan toggle garansi --}}
<script>
    // Initial setup for the main form's tanggal_masuk
    document.addEventListener('DOMContentLoaded', function() {
        const tanggalMasukInput = document.getElementById('tanggal_masuk');
        if (tanggalMasukInput && tanggalMasukInput.value) {
            setTenggat(tanggalMasukInput.value);
        }
        toggleGaransi(); // Call on load to set initial state for main form

        // If you are using Bootstrap's modal JS, these will trigger automatically.
        // If not, you'll need custom JS to handle opening/closing modals with these IDs.
        // Example for showing a modal (you'd need similar for hiding):
        // var myModal = document.getElementById('myModal')
        // var myInput = document.getElementById('myInput')
        // myModal.addEventListener('shown.bs.modal', function () {
        //   myInput.focus()
        // })
    });

    function setTenggat(tanggal) {
        const tenggatWaktuInput = document.getElementById('tenggat_waktu');
        if (tanggal && tenggatWaktuInput) {
            const tgl = new Date(tanggal);
            tgl.setDate(tgl.getDate() + 30);
            tenggatWaktuInput.value = tgl.toISOString().split('T')[0];
        }
    }

    function toggleGaransi() {
        const kategoriSelect = document.getElementById('id_kategori');
        const garansiContainer = document.getElementById('garansi-container');
        const garansiInput = document.getElementById('tanggal_garansi');
        
        if (kategoriSelect && garansiContainer && garansiInput) {
            const selectedOption = kategoriSelect.options[kategoriSelect.selectedIndex];
            
            if (selectedOption && selectedOption.dataset.nama) {
                const namaKategori = selectedOption.dataset.nama.toLowerCase();
                
                if (namaKategori.includes('elektronik') || namaKategori.includes('gadget')) {
                    garansiContainer.style.display = 'block';
                    garansiInput.required = true;
                    garansiInput.disabled = false;
                } else {
                    garansiContainer.style.display = 'none';
                    garansiInput.required = false;
                    garansiInput.disabled = true;
                    garansiInput.value = ''; // Clear value when hidden
                }
            } else {
                garansiContainer.style.display = 'none';
                garansiInput.required = false;
                garansiInput.disabled = true;
                garansiInput.value = '';
            }
        }
    }

    // Function for edit modals' garansi toggle
    function toggleGaransiEdit(selectElement, containerId, inputId) {
        const kategoriSelect = selectElement;
        const garansiContainer = document.getElementById(containerId);
        const garansiInput = document.getElementById(inputId);

        if (kategoriSelect && garansiContainer && garansiInput) {
            const selectedOption = kategoriSelect.options[kategoriSelect.selectedIndex];
            
            if (selectedOption && selectedOption.dataset.nama) {
                const namaKategori = selectedOption.dataset.nama.toLowerCase();
                
                if (namaKategori.includes('elektronik') || namaKategori.includes('gadget')) {
                    garansiContainer.style.display = 'block';
                    garansiInput.required = true;
                    garansiInput.disabled = false;
                } else {
                    garansiContainer.style.display = 'none';
                    garansiInput.required = false;
                    garansiInput.disabled = true;
                    garansiInput.value = '';
                }
            } else {
                garansiContainer.style.display = 'none';
                garansiInput.required = false;
                garansiInput.disabled = true;
                garansiInput.value = '';
            }
        }
    }

    // Initialize toggleGaransi for all edit modals when they are opened
    // This part assumes you're still using Bootstrap's JS for modal (data-bs-toggle).
    // If not, you'd need to manually trigger toggleGaransiEdit when a modal is shown.
    document.querySelectorAll('[id^="editPenitipanModal"]').forEach(modalEl => {
        modalEl.addEventListener('show.bs.modal', function () {
            const barangId = modalEl.id.replace('editPenitipanModal', '');
            const kategoriSelect = document.getElementById('id_kategori_edit' + barangId);
            if (kategoriSelect) {
                toggleGaransiEdit(kategoriSelect, 'garansi-container-edit' + barangId, 'tanggal_garansi_edit' + barangId);
            }
        });
    });

    // Handle initial state for dynamically generated modals (if any are open on load due to old input)
    document.querySelectorAll('[id^="editPenitipanModal"]').forEach(modalEl => {
        if (modalEl.classList.contains('show')) { // Check if modal is visible (e.g., after validation error)
            const barangId = modalEl.id.replace('editPenitipanModal', '');
            const kategoriSelect = document.getElementById('id_kategori_edit' + barangId);
            if (kategoriSelect) {
                toggleGaransiEdit(kategoriSelect, 'garansi-container-edit' + barangId, 'tanggal_garansi_edit' + barangId);
            }
        }
    });

    // Live search functionality for the table
    const searchInput = document.querySelector('#searchForm input[name="search"]');
    const tableRows = document.querySelectorAll('.min-w-full tbody tr');
    const noResultsRow = document.getElementById('no-results-row');

    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            let hasResults = false;

            tableRows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                if (row.id === 'no-results-row') return; // Skip the no results row itself

                if (rowText.includes(searchTerm)) {
                    row.style.display = ''; // Show row
                    hasResults = true;
                } else {
                    row.style.display = 'none'; // Hide row
                }
            });

            if (noResultsRow) {
                if (hasResults) {
                    noResultsRow.classList.add('hidden');
                } else {
                    noResultsRow.classList.remove('hidden');
                }
            }
        });
    }

</script>