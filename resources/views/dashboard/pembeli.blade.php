<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReUseMart - E-Commerce</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #fff;
            color: #000;
        }
        .topbar {
            background-color: #000;
            color: #fff;
            padding: 5px 15px;
            font-size: 0.875rem;
        }
        .navbar {
            background-color: #fff;
            border-bottom: 1px solid #ddd;
        }
        .navbar .nav-link {
            color: #000;
            font-weight: 500;
        }
        .navbar .nav-link:hover {
            color: #f44336;
        }
        .hero {
            background: #000;
            color: #fff;
            padding: var(--hero-padding-y, 0rem) var(--hero-padding-x, 2rem);
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-radius: 10px;
        }

        .hero-small {
            --hero-padding-y: 0.5rem;
        }

        .hero-large {
            --hero-padding-y: 3rem;
        }
        .hero img {
            max-width: 400px;
        }
        .hero h1 {
            font-size: 2rem;
            font-weight: bold;
        }
        .sidebar {
            border-right: 1px solid #ddd;
            padding: 1rem;
        }
        .sidebar a {
            display: block;
            padding: 8px 0;
            color: #000;
            text-decoration: none;
        }
        .sidebar a:hover {
            color: #f44336;
        }
        .flash-sale {
            background: #fff;
            padding: 2rem;
        }
        .flash-sale .product-card {
            border: 1px solid #eee;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
        }
        .product-card img {
            width: 100%;
            height: 150px;
            object-fit: contain;
            border-radius: 20px; 
        }
        .product-card .discount {
            background: #f44336;
            color: #fff;
            font-size: 0.8rem;
            padding: 2px 6px;
            border-radius: 5px;
            position: absolute;
            top: 10px;
            left: 10px;
        }
        .product-price {
            color: #f44336;
            font-weight: bold;
        }
        .original-price {
            text-decoration: line-through;
            color: #888;
            font-size: 0.9rem;
        }
        .footer {
            background-color: #111;
            color: #fff;
            text-align: center;
            padding: 1rem;
            position: fixed;
            bottom: 0;
            width: 100%;
            z-index: 100;
        }
        .horizontal-scroll-container {
            overflow-x: auto;
            white-space: nowrap;
            padding-bottom: 1rem;
        }

        .horizontal-scroll-container::-webkit-scrollbar {
            height: 10px;
        }

        .horizontal-scroll-container::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 5px;
        }

        .horizontal-scroll-container::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
    </style>
</head>
<body>
    <div class="topbar text-mid">
        Perbanyak Belanja dan Dapatkan Poin Serta Merchandise Menarik! <a href="#" class="text-white text-decoration-underline">Belanja</a>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">ReUseMart</a>
            <form class="d-flex ms-auto me-3">
                <input class="form-control me-2" type="search" placeholder="Apa yang anda butuhkan?">
            </form>
            <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('diskusi.index') }}" class="btn btn-outline-dark btn-sm">Diskusi</a>
                    <a href="{{ route('alamat.manager') }}" class="btn btn-outline-dark btn-sm">Kelola Alamat</a>
                <a href="{{ route('profilPembeli') }}" class="me-3">
                    <i class="fas fa-user-circle fa-lg"></i>
                </a>
                <a href="{{ route('liveCode.pembeli') }}" class="text-dark"><i class="fas fa-heart"></i></a>
                <a href="{{ route('keranjang.index') }}" class="text-dark"><i class="fas fa-shopping-cart"></i></a>
            </div>
        </div>
    </nav>

     <div class="container-fluid">
        <div class="row">
            <aside class="col-md-2 sidebar">
                <a href="{{ route('kategori', ['id' => 1]) }}">Elektronik & Gadget</a>
                <a href="{{ route('kategori', ['id' => 2]) }}">Pakaian & Aksesoris</a>
                <a href="{{ route('kategori', ['id' => 3]) }}">Perabotan Rumah Tangga</a>
                <a href="{{ route('kategori', ['id' => 4]) }}">Buku, Alat Tulis, & Sekolah</a>
                <a href="{{ route('kategori', ['id' => 5]) }}">Hobi, Mainan, & Koleksi</a>
                <a href="{{ route('kategori', ['id' => 6]) }}">Perlengkapan Bayi & Anak</a>
                <a href="{{ route('kategori', ['id' => 7]) }}">Otomotif & Aksesoris</a>
                <a href="{{ route('kategori', ['id' => 8]) }}">Taman & Outdoor</a>
                <a href="{{ route('kategori', ['id' => 9]) }}">Kantor & Industri</a>
                <a href="{{ route('kategori', ['id' => 10]) }}">Kosmetik & Perawatan Diri</a>
            </aside>
            <main class="col-md-10">
                <section class="hero d-flex justify-content-between align-items-center">
                    <div>
                        <h1>Diskon hingga 10%</h1>
                        <a href="#" class="btn btn-outline-light mt-3">Belanja Sekarang</a>
                    </div>

                    <img src="{{ asset('assets/images/keluarga di crop.PNG') }}" alt="Promo">
                </section>

                @if(isset($kategori))
                    <section class="flash-sale mt-5">
                        <h5 class="text-danger">Kategori</h5>
                        <h2 class="fw-bold">{{ $kategori->nama_kategori }}</h2>
                        <div class="horizontal-scroll-container mt-4 d-flex flex-nowrap overflow-auto px-2">
                            @forelse ($barang->where('status_barang', 'tersedia') as $item)
                                <div class="me-3" style="min-width: 200px; flex-shrink: 0;">
                                    <x-product-card2 :item="$item" />
                                </div>
                            @empty
                                <p class="ms-2">Tidak ada barang dalam kategori ini.</p>
                            @endforelse
                        </div>
                    </section>
                @else
                    <section class="flash-sale mt-5">
                        <h5 class="text-danger">Hits Hari Ini</h5>
                        <h2 class="fw-bold">Baru Ditambahkan</h2>
                        <div class="horizontal-scroll-container mt-4 d-flex flex-nowrap overflow-auto px-2">
                            @foreach ($barangBaru->where('status_barang', 'tersedia') as $barang)
                                <div class="me-3" style="min-width: 200px; flex-shrink: 0;">
                                    <x-product-card2 :item="$barang" />
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif
            </main>
        </div>
    </div>

    <footer class="footer mt-5">
        <p>&copy; 2025 ReUseMart. All Rights Reserved.</p>
    </footer>
</body>
</html>