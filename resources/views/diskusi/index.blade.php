@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Diskusi Barang</h2>
        <div class="row">
            <a href="{{ route('dashboard.pembeli') }}" class="btn btn-secondary mb-3">← Kembali ke Dashboard</a>

            @foreach ($diskusi as $diskus)
                <div class="col-md-4">
                    <div class="card">
                        <img src="{{ $diskus->barang->image_url }}" class="card-img-top" alt="{{ $diskus->barang->nama }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $diskus->barang->nama }}</h5>
                            <p class="card-text">{{ $diskus->isi_diskusi }}</p>
                            <a href="{{ route('diskusi.show', $diskus->id_diskusi) }}" class="btn btn-primary">Lihat Diskusi</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
