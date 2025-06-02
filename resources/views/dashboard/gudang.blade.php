@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-end mb-3">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Tampilkan error validasi --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h3>Dashboard Gudang</h3>

    {{-- Form Penitipan --}}
    <div class="card mb-4">
        <div class="card-header">Input Transaksi Penitipan Barang</div>
        <div class="card-body">
            <form action="{{ route('penitipan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_pegawai" value="4">

                <div class="mb-3">
                    <label for="nama_barang" class="form-label">Nama Barang</label>
                    <input type="text" name="nama_barang" id="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror" value="{{ old('nama_barang') }}" required>
                    @error('nama_barang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="pesan" class="form-label">Pesan</label>
                    <input type="text" name="pesan" id="pesan" class="form-control @error('pesan') is-invalid @enderror" value="{{ old('pesan') }}" required>
                    @error('pesan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Berat Barang</label>
                    <input type="number" name="berat" class="form-control @error('berat') is-invalid @enderror" value="{{ old('berat') }}" required>
                    @error('berat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Deskripsi Barang</label>
                    <input type="text" name="deskripsi_barang" class="form-control @error('deskripsi_barang') is-invalid @enderror" value="{{ old('deskripsi_barang') }}" required>
                    @error('deskripsi_barang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="harga_barang" class="form-label">Harga Barang (Rp)</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="harga_barang" id="harga_barang" class="form-control @error('harga_barang') is-invalid @enderror" 
                               value="{{ old('harga_barang') }}" min="0" step="1000" required 
                               placeholder="Masukkan harga barang">
                        @error('harga_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="form-text text-muted">Masukkan harga estimasi atau nilai barang dalam Rupiah</small>
                </div>

                <div class="mb-3">
                    <label for="id_kategori" class="form-label">Kategori</label>
                    <select name="id_kategori" id="id_kategori" class="form-control @error('id_kategori') is-invalid @enderror" required onchange="toggleGaransi()">
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
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3" id="garansi-container" style="display: none;">
                    <label for="tanggal_garansi" class="form-label">Tanggal Garansi <span class="text-info">(Khusus Elektronik & Gadget)</span></label>
                    <input type="date" name="tanggal_garansi" id="tanggal_garansi" class="form-control @error('tanggal_garansi') is-invalid @enderror" value="{{ old('tanggal_garansi') }}">
                    @error('tanggal_garansi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Field ini hanya wajib diisi untuk kategori Elektronik & Gadget</small>
                </div>

                <div class="mb-3">
                    <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" id="tanggal_masuk" class="form-control @error('tanggal_masuk') is-invalid @enderror" value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required onchange="setTenggat(this.value)">
                    @error('tanggal_masuk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tenggat_waktu" class="form-label">Tenggat Waktu (otomatis 30 hari)</label>
                    <input type="date" name="tenggat_waktu" id="tenggat_waktu" class="form-control" readonly value="{{ old('tenggat_waktu') }}">
                </div>

                <div class="mb-3">
                    <label for="gambar_barang" class="form-label">Gambar Barang</label>
                    <input type="file" name="gambar_barang" id="gambar_barang" class="form-control @error('gambar_barang') is-invalid @enderror" accept="image/*" required>
                    @error('gambar_barang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                </div>

                <div class="mb-3">
                    <label for="gambar_tambahan" class="form-label">Gambar Tambahan (Max 5)</label>
                    <input type="file" name="gambar_tambahan[]" id="gambar_tambahan" class="form-control @error('gambar_tambahan') is-invalid @enderror" multiple accept="image/*">
                    @error('gambar_tambahan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Anda bisa memilih lebih dari satu gambar</small>
                </div>

                <div class="mb-3">
                    <label>Penitip</label>
                    <select name="id_penitip" class="form-control" required>
                        <option value="">-- Pilih Penitip --</option>
                        @foreach($penitipList as $penitip)
                            <option value="{{ $penitip->id_penitip }}">{{ $penitip->nama_penitip }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="reset" class="btn btn-secondary me-md-2">Reset</button>
                    <button type="submit" class="btn btn-success">Simpan Data</button>
                </div>

            </form>
        </div>
    </div>

    {{-- Tabel Barang Dititipkan --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Data Barang Dititipkan</span>
            <div class="search-box" style="width: 300px;">
                <form id="searchForm" method="GET" action="{{ url()->current() }}">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari barang..." 
                            value="{{ request('search') }}">
                        @if(request('search'))
                            <a href="{{ url()->current() }}" class="btn btn-outline-danger">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Pesan</th>
                        <th>Kategori</th>
                        <th>Tanggal Masuk</th>
                        <th>Tenggat Waktu</th>
                        <th>Gambar</th>
                        <th>Penitip</th>
                        <th>QC By</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($barangList) && $barangList->count() > 0)
                        @foreach($barangList as $barang)
                        <tr>
                            <td>{{ $barang->nama_barang ?? '-' }}</td>
                            <td>
                                @if(isset($barang->harga_barang) && $barang->harga_barang > 0)
                                    <span class="fw-bold text-success">Rp {{ number_format($barang->harga_barang, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ optional($barang->penitipan)->pesan ?? '-' }}</td>
                            <td>{{ optional($barang->kategori)->nama_kategori ?? '-' }}</td>
                            <td>
                                @if($barang->tanggal_masuk)
                                    {{ $barang->tanggal_masuk instanceof \Carbon\Carbon ? $barang->tanggal_masuk->format('d/m/Y') : $barang->tanggal_masuk }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($barang->tenggat_waktu)
                                    {{ $barang->tenggat_waktu instanceof \Carbon\Carbon ? $barang->tenggat_waktu->format('d/m/Y') : $barang->tenggat_waktu }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($barang->gambar_barang && file_exists(storage_path('app/public/' . $barang->gambar_barang)))
                                    <img src="{{ asset('storage/' . $barang->gambar_barang) }}" width="100" class="img-thumbnail" alt="Gambar {{ $barang->nama_barang }}">
                                    <!-- Gambar Tambahan -->
                                    @if($barang->gambarTambahan->count() > 0)
                                        <div class="mb-3">
                                            <div class="row">
                                                @foreach($barang->gambarTambahan as $gambar)
                                                    <div class="col-md-3 mb-2 position-relative">
                                                        <img src="{{ asset('storage/' . $gambar->path_gambar) }}" class="img-thumbnail" width="150">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <span class="text-muted">Tidak ada gambar</span>
                                @endif
                            </td>
                            <td>{{ optional(optional($barang->penitipan)->penitip)->nama_penitip ?? '-' }}</td>
                            <td>{{ optional(optional($barang->penitipan)->pegawai)->nama_pegawai ?? '-' }}</td>
                            <td>
                                @if($barang->penitipan)
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editPenitipanModal{{ $barang->penitipan->id_penitipan }}">Edit</button>
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#hapusPenitipanModal{{ $barang->penitipan->id_penitipan }}">Hapus</button>
                                    <a href="{{ route('penitipan.nota', $barang->penitipan->id_penitipan) }}" class="btn btn-sm btn-info">PDF</a>
                                @else
                                    <span class="text-muted">No actions</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        <tr id="no-results-row" style="display: none;">
                            <td colspan="10" class="text-center">Transaksi Penitipan Barang Tidak Ditemukan!</td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="10" class="text-center">Belum ada barang dititipkan</td>
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
                <div class="modal fade" id="editPenitipanModal{{ $barang->penitipan->id_penitipan }}" tabindex="-1" aria-labelledby="editPenitipanLabel{{ $barang->penitipan->id_penitipan }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="{{ route('penitipan.update', $barang->penitipan->id_penitipan) }}" method="POST" enctype="multipart/form-data" id="editForm{{ $barang->penitipan->id_penitipan }}">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editPenitipanLabel{{ $barang->penitipan->id_penitipan }}">Edit Data Penitipan & Barang</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <!-- Data Barang -->
                                        <div class="col-md-6">
                                            <h5>Data Barang</h5>
                                            <div class="mb-3">
                                                <label for="nama_barang" class="form-label">Nama Barang</label>
                                                <input type="text" name="nama_barang" class="form-control" value="{{ $barang->nama_barang }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="berat" class="form-label">Berat (kg)</label>
                                                <input type="number" name="berat" class="form-control" step="0.01" value="{{ $barang->berat }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="deskripsi_barang" class="form-label">Deskripsi</label>
                                                <textarea name="deskripsi_barang" class="form-control" rows="3" required>{{ $barang->deskripsi_barang }}</textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label for="harga_barang" class="form-label">Harga (Rp)</label>
                                                <input type="number" name="harga_barang" class="form-control" value="{{ $barang->harga_barang }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="id_kategori" class="form-label">Kategori</label>
                                                <select name="id_kategori" id="id_kategori" class="form-control @error('id_kategori') is-invalid @enderror" required onchange="toggleGaransi()">
                                                <option value="{{ $barang->id_kategori }}">-- Pilih Kategori --</option>
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
                                            </div>

                                            <div class="mb-3">
                                                <label for="gambar_barang" class="form-label">Gambar Barang</label>
                                                <input type="file" name="gambar_barang" class="form-control">
                                                @if($barang->gambar_barang)
                                                    <small class="text-muted">Gambar saat ini: 
                                                        <a href="{{ asset('storage/' . $barang->gambar_barang) }}" target="_blank">Lihat</a>
                                                    </small>
                                                @endif
                                            </div>

                                            <div class="mb-3">
                                                <label for="gambar_tambahan" class="form-label">Gambar Tambahan (Max 5)</label>
                                                <input type="file" name="gambar_tambahan[]" id="gambar_tambahan" class="form-control @error('gambar_tambahan') is-invalid @enderror" multiple accept="image/*">
                                                @error('gambar_tambahan')
                                                    @foreach($barang->gambarTambahan as $gambar)
                                                        <small class="text-muted">Gambar saat ini: 
                                                            <a href="{{ asset('storage/' . $gambar->path_gambar) }}" target="_blank">Lihat</a>
                                                    @endforeach
                                                @enderror
                                                <small class="text-muted">Anda bisa memilih lebih dari satu gambar</small>
                                            </div>
                                        </div>

                                        <!-- Data Penitipan -->
                                        <div class="col-md-6">
                                            <h5>Data Penitipan</h5>
                                            <div class="mb-3">
                                                <label for="pesan" class="form-label">Pesan</label>
                                                <textarea name="pesan" class="form-control" rows="3" required>{{ $barang->penitipan->pesan }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tanggal_masuk{{ $barang->penitipan->id_penitipan }}">Tanggal Masuk Gudang</label>
                                                <input type="date" name="tanggal_masuk" class="form-control" id="tanggal_masuk{{ $barang->penitipan->id_penitipan }}" 
                                                    value="{{ $barang->penitipan->tanggal_masuk ? ($barang->penitipan->tanggal_masuk instanceof \Carbon\Carbon ? $barang->penitipan->tanggal_masuk->format('Y-m-d') : $barang->penitipan->tanggal_masuk) : '' }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="id_penitip" class="form-label">Penitip</label>
                                                <select name="id_penitip" class="form-control" required>
                                                    @foreach($penitipList as $penitip)
                                                        <option value="{{ $penitip->id_penitip }}" {{ $barang->penitipan->id_penitip == $penitip->id_penitip ? 'selected' : '' }}>
                                                            {{ $penitip->nama_penitip }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="id_pegawai" class="form-label">Pegawai QC</label>
                                                <select name="id_pegawai" class="form-control" required>
                                                    @foreach($pegawais as $pegawai)
                                                        <option value="{{ $pegawai->id_pegawai }}" {{ $barang->penitipan->id_pegawai == $pegawai->id_pegawai ? 'selected' : '' }}>
                                                            {{ $pegawai->nama_pegawai }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Hapus Penitipan -->
                <div class="modal fade" id="hapusPenitipanModal{{ $barang->penitipan->id_penitipan }}" tabindex="-1" aria-labelledby="hapusPenitipanLabel{{ $barang->penitipan->id_penitipan }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('penitipan.destroy', $barang->penitipan->id_penitipan) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="hapusPenitipanLabel{{ $barang->penitipan->id_penitipan }}">Konfirmasi Hapus</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah Anda yakin ingin menghapus data penitipan milik <strong>{{ optional(optional($barang->penitipan)->penitip)->nama_penitip ?? 'Unknown' }}</strong> beserta seluruh barang yang dititipkan?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endif

</div>

{{-- Script untuk hitung tenggat dan toggle garansi --}}
<script>
    // Your existing JavaScript functions here
    function setTenggat(tanggal) {
        if (tanggal) {
            const tgl = new Date(tanggal);
            tgl.setDate(tgl.getDate() + 30);
            document.getElementById('tenggat_waktu').value = tgl.toISOString().split('T')[0];
        }
    }

    function toggleGaransi() {
        const kategoriSelect = document.getElementById('id_kategori');
        const selectedOption = kategoriSelect.options[kategoriSelect.selectedIndex];
        const garansiContainer = document.getElementById('garansi-container');
        const garansiInput = document.getElementById('tanggal_garansi');
        
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

    document.addEventListener('DOMContentLoaded', function() {
        const tanggalMasuk = document.getElementById('tanggal_masuk').value;
        if (tanggalMasuk) {
            setTenggat(tanggalMasuk);
        }
        toggleGaransi();
    });

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('input[name="search"]');
        
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const searchValue = e.target.value.toLowerCase();
                const rows = document.querySelectorAll('tbody tr');
                
                rows.forEach(row => {
                    const rowText = row.textContent.toLowerCase();
                    if (rowText.includes(searchValue)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });

                if (noResultsRow) {
                    if (searchValue && !hasMatches) {
                        noResultsRow.style.display = '';
                    } else {
                        noResultsRow.style.display = 'none';
                    }
                }
            });
        }
    });

    $(document).ready(function() {
        $('form[id^="editForm"]').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            const formData = new FormData(this);
            
            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Tutup modal
                    $('.modal').modal('hide');
                    // Tampilkan pesan sukses
                    alert('Data berhasil diperbarui');
                    // Reload halaman
                    window.location.reload();
                },
                error: function(xhr) {
                    let errorMessage = 'Terjadi kesalahan';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseText) {
                        errorMessage = xhr.responseText;
                    }
                    alert(errorMessage);
                }
            });
        });
    });
</script>

@endsection