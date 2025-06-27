
@extends('layouts.app')

@section('content')
<div class="container py-4">

    <!-- Tombol Kembali di Pojok Kiri -->
    <div class="mb-3">
        <a href="{{ route('penitip.profil') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <h2 class="text-center mb-4">Pengajuan Penarikan Saldo</h2>

    <div class="row justify-content-center">
        <div class="col-md-8">

            <!-- Kartu Profil -->
            <div class="card shadow rounded-4 mb-4">
                <div class="card-body text-center">
                    <h4 class="mb-3">👤 {{ $user->nama_penitip }}</h4>            
                    <p><i class="fas fa-wallet me-2"></i><strong>Saldo:</strong> Rp. {{ number_format($penitip->saldo_penitip, 0, ',', '.') }}</p>
                    <p><i class="fas fa-trophy me-2"></i><strong>Poin:</strong> {{ $penitip->poin_penitip }}</p>
                </div>
            </div>

            <div class="card shadow rounded-4 mb-4">
                <div class="card-body">
                    <h5 class="card-title text-start">📜 Penarikan Saldo</h5>
                    <form action="{{ route('tariksaldo', $penitip->id_penitip) }}" method="POST" enctype="multipart/form-data" class="d-inline">
                        @csrf
                        <div class="mb-3">
                            <label for="nominal_tarik" class="form-label">Masukkan Nominal Tarik (Rp)</label>
                            <input type="number" name="nominal_tarik" class="form-control" value="{{ $penitip->nominal_tarik }}" required>
                            @error('nominal_tarik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3"> 
                            <button type="submit" class="btn btn-primary">Tarik</button>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
