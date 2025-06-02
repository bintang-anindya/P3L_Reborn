@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('diskusi.index') }}" class="btn btn-secondary mb-3">← Kembali ke Daftar Diskusi</a>

        <h2>Diskusi untuk {{ $diskusi->barang->nama_barang }}</h2>

        {{-- Diskusi Utama --}}
        <div class="border p-3 mb-3 rounded bg-white">
            <strong>{{ $diskusi->pembeli->username_pembeli ?? 'Anonim' }}:</strong>
            <p>{{ $diskusi->isi_diskusi }}</p>
        </div>

        {{-- Balasan ke diskusi utama --}}
        @if ($diskusi->balasan->count())
            <h4>Balasan:</h4>
            @foreach ($diskusi->balasan as $balasan)
                <div class="border p-2 mb-2 rounded bg-light">
                    <strong>{{ $balasan->pegawai->nama_pegawai ?? $balasan->pembeli->username_pembeli ?? 'Pengguna' }}:</strong>
                    <p>{{ $balasan->isi_balasan }}</p>
                    <small class="text-muted">{{ $balasan->tanggal_balasan }}</small>
                </div>
            @endforeach
        @endif

        {{-- Diskusi lanjutan dari pembeli --}}
        @if ($diskusi->anak->count())
            <h4 class="mt-4">Lanjutan Diskusi:</h4>
            @foreach ($diskusi->anak as $lanjut)
                <div class="ms-3 border p-3 mb-2 rounded bg-white">
                    <strong>{{ $lanjut->pembeli->username_pembeli ?? 'Anonim' }}:</strong>
                    <p>{{ $lanjut->isi_diskusi }}</p>

                    {{-- Balasan ke diskusi lanjutan --}}
                    @foreach ($lanjut->balasan as $balasan)
                        <div class="ms-3 border p-2 mb-2 rounded bg-light">
                            <strong>{{ $balasan->pegawai->nama_pegawai ?? $balasan->pembeli->username_pembeli ?? 'Pengguna' }}:</strong>
                            <p>{{ $balasan->isi_balasan }}</p>
                            <small class="text-muted">{{ $balasan->tanggal_balasan }}</small>
                        </div>
                    @endforeach
                </div>
            @endforeach
        @endif

        {{-- Form Balasan --}}
        <form action="{{ route('diskusi.storeBalasan', $diskusi->id_diskusi) }}" method="POST">
            @csrf
            <div class="form-group mt-3">
                <textarea name="isi_balasan" class="form-control" rows="4" placeholder="Tulis balasan atau lanjutan diskusi..."></textarea>
            </div>
            <button type="submit" class="btn btn-success mt-2">Kirim</button>
        </form>
    </div>
@endsection
