<!DOCTYPE html>
<html>
    <head>
        <title>Alamat Manager</title>
    </head>
    <body>
        <h1>Alamat Manager</h1>

        {{-- Form Tambah Alamat --}}
        <form method="POST" action="{{ route('alamat.store') }}">
            @csrf
            <label for="detail">Detail Alamat:</label>
            <input type="text" name="detail" required>
            <button type="submit">Tambah Alamat</button>
        </form>

        <hr>

        {{-- Form Pencarian Alamat --}}
        <form method="GET" action="{{ route('alamat.search') }}">
            <label for="keyword">Cari Alamat:</label>
            <input type="text" name="keyword" required>
            <button type="submit">Cari</button>
        </form>

        @if (session('not_found'))
            <p style="color:red;">{{ session('not_found') }}</p>
        @endif

        @if (isset($hasil_pencarian))
            <h3>Hasil Pencarian:</h3>
            @foreach ($hasil_pencarian as $alamat)
                <p>{{ $alamat->detail }}</p>
            @endforeach
        @endif

        <hr>

        {{-- Daftar Alamat User Login --}}
        <h2>Daftar Alamat Saya</h2>
        @forelse ($alamats as $alamat)
            <form action="{{ route('alamat.update', $alamat->id_alamat) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="text" name="detail" value="{{ $alamat->detail }}" required>
                <button type="submit">Edit Alamat</button>
            </form>

            <form action="{{ route('alamat.destroy', $alamat->id_alamat) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Hapus</button>
            </form>

            <form action="{{ route('alamat.setPrimary', $alamat->id_alamat) }}" method="POST">
                @csrf
                <button type="submit" {{ $alamat->is_primary ? 'disabled' : '' }}>
                    {{ $alamat->is_primary ? 'Alamat Utama' : 'Jadikan Alamat Utama' }}
                </button>
            </form>

            <br><br>
        @empty
            <p>Belum ada alamat yang ditambahkan.</p>
        @endforelse

        <hr>

        {{-- Daftar Pembeli Login --}}
        <h2>Data Pembeli Login</h2>
        <p>
            {{ $pembeli->nama_pembeli }} -
            Alamat:
            @if ($pembeli->alamats->count())
                <ul>
                    @foreach ($pembeli->alamats as $alamat)
                        <li>{{ $alamat->detail }}</li>
                    @endforeach
                </ul>
            @else
                Belum memiliki alamat
            @endif
        </p>
    </body>
</html>
