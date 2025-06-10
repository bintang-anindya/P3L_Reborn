<!DOCTYPE html>
<html>
<head>
    <title>Alamat Manager</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body, html {
    margin: 0;
    padding: 0;
    height: 100%;
    font-family: 'Roboto', Arial, sans-serif;
    background-color: #fff;
    color: #333;
}

.topbar {
    background-color: #000;
    color: #fff;
    padding: 8px 20px;
    font-size: 0.875rem;
    width: 100%;
    margin: 0;
}

.topbar a {
    color: #fff;
    text-decoration: underline;
}

.navbar {
    background-color: #fff;
    border-bottom: 1px solid #ddd;
    padding: 0.75rem 1rem;
    width: 100%;
    margin: 0;
}

.navbar .container {
    padding-left: 0;
    padding-right: 0;
    max-width: 100%;
}

.navbar .nav-link {
    color: #000;
    font-weight: 500;
    transition: color 0.3s ease;
}

.navbar .nav-link:hover {
    color: #f44336;
}

.navbar .fa-user-circle.active {
    border: 1px solid #212529;
    border-radius: 5px;
    padding: 4px;
}

/* Tambahan agar navbar menempel dengan topbar */
.topbar + .navbar {
    margin-top: 0;
    border-top: none;
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
            filter: grayscale(70%) brightness(0.6);
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.9); /* semi-transparan putih */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15); /* aksen hitam samar */
            margin-top: 20px;
        }

        h1, h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 1.5rem;
            border-bottom: 2px solid #000;
            display: inline-block;
            padding-bottom: 4px;
            margin-bottom: 10px;
        }

        .success-message {
            background-color: rgba(40, 167, 69, 0.1);
            border: 1px solid #28a745;
            color: #28a745;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }

        .error-message {
            background-color: rgba(220, 53, 69, 0.1);
            border: 1px solid #dc3545;
            color: #dc3545;
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
            border: 1px solid #000;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            width: 100%;
            max-width: 600px;
            text-align: center;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .alamat-card:hover {
            transform: scale(1.02);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .alamat-utama {
            background-color: rgba(0, 0, 0, 0.05);
            border: 1px solid #000;
        }

        .alamat-card input[type="text"] {
            width: 70%;
            padding: 6px;
            border: 1px solid #000;
            border-radius: 4px;
            background-color: #fff;
            color: #333;
        }

        .alamat-card .button-group {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px;
            margin-top: 8px;
        }

        .btn {
            padding: 6px 12px;
            border: 1px solid #000;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin: 3px;
            background-color: #fff;
            color: #333;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn-edit {
            background-color: #fff;
            color: #28a745;
            border: 1px solid #28a745;
        }

        .btn-edit:hover {
            background-color: #28a745;
            color: #fff;
        }

        .btn-delete {
            background-color: #fff;
            color: #dc3545;
            border: 1px solid #dc3545;
        }

        .btn-delete:hover {
            background-color: #dc3545;
            color: #fff;
        }

        .btn-primary {
            background-color: #fff;
            color: #000;
            border: 1px solid #000;
        }

        .btn-primary:hover {
            background-color: #000;
            color: #fff;
        }

        .btn-back {
            background-color: #fff;
            color: #000;
            text-decoration: none;
            padding: 8px 14px;
            border: 1px solid #000;
            border-radius: 4px;
            display: inline-block;
            margin-top: 10px;
        }

        .btn-back:hover {
            background-color: #000;
            color: #fff;
        }

        .button-group span {
            font-weight: bold;
            color: #000;
        }

        input[type="text"]::placeholder {
            color: #aaa;
        }

        a {
            color: #000;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>

    <div class="topbar text-center">
        Perbanyak Belanja dan Dapatkan Poin Serta Merchandise Menarik! 
        <a href="{{ route('dashboard.pembeli') }}">Belanja</a>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard.pembeli') }}">ReUseMart</a>
            <form class="d-flex ms-auto me-3">
                <input class="form-control me-2" type="search" placeholder="Apa yang anda butuhkan?">
            </form>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('diskusi.index') }}" class="btn btn-outline-dark btn-sm">Diskusi</a>
                <a href="{{ route('alamat.manager') }}" class="btn btn-outline-dark btn-sm">Kelola Alamat</a>
                <a href="{{ route('dashboard.pembeli') }}" class="text-dark">
                    <i class="fas fa-user-circle"></i>
                </a>
                <a href="#" class="text-dark"><i class="fas fa-heart"></i></a>
                <a href="{{ route('keranjang.index') }}" class="text-dark">
                    <i class="fas fa-shopping-cart"></i>
                </a>
            </div>  
        </div>
    </nav>


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
                                <span>Alamat Utama</span>
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
