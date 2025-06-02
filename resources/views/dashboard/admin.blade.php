@extends('layouts.app')
@section('content')
<div class="container">
    <div class="d-flex justify-content-end mb-3">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>

    <h3>Data Pegawai</h3>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Search Bar --}}
    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('pegawai.index') }}" method="GET" class="row g-3">
                <div class="col-md-8">
                    <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama atau role..." value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Cari</button>
                    <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
>>>>>>> 4ec2240b89d5fc489b7bc2f35b0f8670f070846f
        </div>
    </div>

    {{-- Form Create/Edit --}}
    <div class="card mb-3">
        <div class="card-header">
            {{ isset($editMode) && $editMode ? 'Edit Pegawai' : 'Tambah Pegawai' }}
        </div>
        <div class="card-body">
            <form action="{{ isset($editMode) && $editMode ? route('pegawai.update', $pegawai->id_pegawai) : route('pegawai.store') }}" method="POST">
                @csrf
                @if(isset($editMode) && $editMode)
                    @method('PUT')
                @endif

                <div class="form-group mb-2">
                    <label>Nama</label>
                    <input type="text" name="nama_pegawai" class="form-control" value="{{ old('nama_pegawai', $pegawai->nama_pegawai ?? '') }}" required>
                    @error('nama_pegawai')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group mb-2">
                    <label>Email</label>
                    <input type="email" name="email_pegawai" class="form-control" value="{{ old('email_pegawai', $pegawai->email_pegawai ?? '') }}" required>
                    @error('email_pegawai')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group mb-2">
                    <label>Username</label>
                    <input type="text" name="username_pegawai" class="form-control" value="{{ old('username_pegawai', $pegawai->username_pegawai ?? '') }}" required>
                    @error('username_pegawai')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group mb-2">
                    <label>Password</label>
                    <input type="password" name="password_pegawai" class="form-control" {{ isset($editMode) ? '' : 'required' }}>
                    <small class="text-muted">{{ isset($editMode) ? 'Kosongkan jika tidak ingin mengubah password' : '' }}</small>
                    @error('password_pegawai')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group mb-2">
                    <label>No Telp</label>
                    <input type="text" name="no_telp_pegawai" class="form-control" value="{{ old('no_telp_pegawai', $pegawai->no_telp_pegawai ?? '') }}" required>
                    @error('no_telp_pegawai')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group mb-2">
                    <label>Role</label>
                    <select name="id_role" class="form-control" required>
                        <option value="">-- Pilih Role --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id_role }}" {{ (old('id_role', $pegawai->id_role ?? '') == $role->id_role) ? 'selected' : '' }}>
                                {{ $role->nama_role }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_role')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success mt-2">{{ isset($editMode) ? 'Update' : 'Simpan' }}</button>
                @if(isset($editMode))
                    <a href="{{ route('pegawai.index') }}" class="btn btn-secondary mt-2">Batal</a>
                @endif
            </form>
        </div>
    </div>

    {{-- Table Data --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>No Telp</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($pegawaiList->count() > 0)
                            @foreach($pegawaiList as $p)
                            <tr>
                                <td>{{ $p->nama_pegawai }}</td>
                                <td>{{ $p->email_pegawai }}</td>
                                <td>{{ $p->username_pegawai }}</td>
                                <td>{{ $p->no_telp_pegawai }}</td>
                                <td>{{ $p->role->nama_role ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('pegawai.edit', $p->id_pegawai) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('pegawai.destroy', $p->id_pegawai) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection