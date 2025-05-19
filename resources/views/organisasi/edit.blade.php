@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Organisasi</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('organisasi.update', $organisasi->id_organisasi) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Organisasi</label>
            <input type="text" name="nama_organisasi" class="form-control" value="{{ old('nama_organisasi', $organisasi->nama_organisasi) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username_organisasi" class="form-control" value="{{ old('username_organisasi', $organisasi->username_organisasi) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email_organisasi" class="form-control" value="{{ old('email_organisasi', $organisasi->email_organisasi) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="text" name="password_organisasi" class="form-control" value="{{ old('password_organisasi', $organisasi->password_organisasi) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat_organisasi" class="form-control" rows="2" required>{{ old('alamat_organisasi', $organisasi->alamat_organisasi) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">No Telepon</label>
            <input type="text" name="no_telp_organisasi" class="form-control" value="{{ old('no_telp_organisasi', $organisasi->no_telp_organisasi) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Organisasi</button>
        <a href="{{ route('organisasi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
