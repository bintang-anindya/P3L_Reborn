<!DOCTYPE html>
<html>
<head>
    <title>Alamat Manager</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
        }

        /* Video background */
        .video-background {
            position: fixed;
            top: 0;
            left: 0;
            min-width: 100%;
            min-height: 100%;
            z-index: -1;
            object-fit: cover;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.9); /* semi-transparent background */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
            margin-top: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .success-message {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }

        .error-message {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }

        .form-section {
            margin-bottom: 20px;
            text-align: center;
        }

        .alamat-list {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .alamat-card {
            border: 1px solid #ccc;
            background-color: #fafafa;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            width: 100%;
            max-width: 600px;
            text-align: center;
        }

        .alamat-utama {
            background-color: #e6f7ff;
            border: 1px solid #91d5ff;
        }

        .alamat-card form {
            display: inline-block;
            margin: 5px;
        }

        .alamat-card input[type="text"] {
            width: 70%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 5px;
        }

        .alamat-card .button-group {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px; /* jarak antar tombol */
            margin-top: 8px;
        }

        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin: 3px;
        }

        .btn-edit {
            background-color: #28a745;
            color: white;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-back {
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            padding: 8px 14px;
            border-radius: 4px;
            display: inline-block;
            margin-top: 10px;
        }

        .button-group form {
            display: inline;
        }

        .button-group span {
            font-weight: bold;
        }
    </style>
</head>
<body>

    {{-- Background Video --}}
    <video autoplay muted loop class="video-background">
        <source src="{{ asset('assets/videos/5585939-hd_1920_1080_25fps.mp4') }}" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>

    <div class="container">
        <h1>Alamat Manager</h1>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        @if (session('not_found'))
            <div class="error-message">
                {{ session('not_found') }}
            </div>
        @endif

        {{-- Form Tambah Alamat --}}
        <div class="form-section">
            <h2>Tambah Alamat Baru</h2>
            <form method="POST" action="{{ route('alamat.store') }}">
                @csrf
                <input type="text" name="detail" placeholder="Detail Alamat" required>
                <button type="submit" class="btn btn-primary">Tambah Alamat</button>
            </form>
        </div>

        {{-- Daftar Alamat --}}
        <div class="form-section">
            <h2>Daftar Alamat Saya</h2>
            <div class="alamat-list">
                @forelse ($alamats as $alamat)
                    <div class="alamat-card {{ $alamat->id_alamat == $pembeli->id_alamat_utama ? 'alamat-utama' : '' }}">
                        <form action="{{ route('alamat.update', $alamat->id_alamat) }}" method="POST" style="margin-bottom: 8px;">
                            @csrf
                            @method('PUT')
                            <input type="text" name="detail" value="{{ $alamat->detail }}" required>
                            <button type="submit" class="btn btn-edit">Simpan</button>
                        </form>
                        
                        <div class="button-group">
                            <form action="{{ route('alamat.destroy', $alamat->id_alamat) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete">Hapus</button>
                            </form>

                            @if ($alamat->id_alamat == $pembeli->id_alamat_utama)
                                <span style="align-self: center;"> Alamat Utama</span>
                            @else
                                <form action="{{ route('alamat.setPrimary', $alamat->id_alamat) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Jadikan Alamat Utama</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <p>Belum ada alamat yang ditambahkan.</p>
                @endforelse
            </div>
        </div>

        {{-- Data Pembeli --}}
        <div class="form-section">
            <h2>Data Pembeli Login</h2>
            <p><strong>Nama:</strong> {{ $pembeli->nama_pembeli }}</p>
            <p><strong>Alamat Utama:</strong>
                @if($pembeli->id_alamat_utama && $pembeli->alamats->where('id_alamat', $pembeli->id_alamat_utama)->first())
                    {{ $pembeli->alamats->where('id_alamat', $pembeli->id_alamat_utama)->first()->detail }}
                @else
                    Belum ditentukan
                @endif
            </p>
        </div>

        {{-- Tombol Kembali --}}
        <div class="form-section">
            <a href="{{ route('dashboard.pembeli') }}" class="btn-back">⬅ Kembali</a>
        </div>
    </div>
</body>
</html>
