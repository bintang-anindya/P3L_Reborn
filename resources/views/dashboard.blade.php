<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReUseMart - E-Commerce</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #f44336; /* Red accent */
            --dark-color: #000;
            --light-bg: #f8f9fa; /* Lighter background for main sections */
            --body-bg: #ffffff; /* White background for body */
            --text-color: #333; /* Darker text for readability */
            --border-color: #eee;
            --card-bg: #fff;
        }

        body {
            font-family: 'Poppins', 'Roboto', sans-serif;
            background-color: var(--body-bg);
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-image: url('data:image/svg+xml;utf8,<svg width="100%" height="100%" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="p" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="1" cy="1" r="0.5" fill="%23f0f0f0"/></pattern></defs><rect width="100%" height="100%" fill="url(%23p)"/></svg>');
            background-size: 20px 20px;
        }

        .topbar {
            background-color: var(--dark-color);
            color: #fff;
            padding: 8px 15px;
            font-size: 0.85rem;
            text-align: center;
        }
        .topbar a {
            color: #fff;
            text-decoration: underline;
            font-weight: 600;
        }

        .navbar {
            background-color: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
        .navbar .navbar-brand {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark-color);
        }
        .navbar .form-control {
            border-radius: 25px;
            padding: 0.75rem 1.25rem;
            border-color: #ddd;
        }
        .navbar .btn-outline-dark {
            border-radius: 25px;
            font-weight: 600;
            padding: 0.5rem 1.2rem;
            transition: all 0.3s ease;
        }
        .navbar .btn-outline-dark:hover {
            background-color: var(--dark-color);
            color: #fff;
        }
        .navbar .fas {
            font-size: 1.25rem;
            margin-right: 15px;
            color: var(--text-color);
            cursor: pointer;
            transition: color 0.3s ease;
        }
        .navbar .fas:hover {
            color: var(--primary-color);
        }

        .hero {
            background: linear-gradient(135deg, var(--dark-color) 0%, #333 100%);
            color: #fff;
            padding: 2rem 3rem;
            border-radius: 15px;
            margin-top: 25px; /* Added margin-top for spacing */
            display: flex;
            align-items: center;
            justify-content: space-between;
            overflow: hidden; /* Ensure image doesn't overflow */
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        .hero h1 {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.2;
        }
        .hero .btn {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #fff;
            padding: 0.8rem 2rem;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(244, 67, 54, 0.3);
        }
        .hero .btn:hover {
            background-color: #e53935;
            border-color: #e53935;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(244, 67, 54, 0.4);
        }
        .hero img {
            max-width: 450px; /* Slightly larger image */
            height: auto;
            border-radius: 10px;
            margin-left: 2rem;
            filter: drop-shadow(5px 5px 15px rgba(0,0,0,0.3)); /* Shadow for image */
        }
        
        /* Ensure content pushes footer down */
        .container-fluid {
            flex-grow: 1;
        }

        .sidebar {
            background-color: var(--card-bg);
            border-right: 1px solid var(--border-color);
            padding: 1.5rem;
            margin-top: 25px; /* Align with hero section */
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            height: fit-content; /* Adjust height to content */
        }
        .sidebar a {
            display: block;
            padding: 10px 0;
            color: var(--text-color);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .sidebar a:hover {
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .flash-sale {
            background-color: var(--light-bg);
            padding: 2.5rem 2rem;
            border-radius: 15px;
            margin-top: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        .flash-sale h2 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }
        .flash-sale h5 {
            color: var(--primary-color);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 1rem;
        }

        .horizontal-scroll-container {
            overflow-x: auto;
            white-space: nowrap;
            padding-bottom: 1rem;
            scrollbar-width: thin; /* Firefox */
            scrollbar-color: #ccc #f1f1f1; /* Firefox */
        }
        .horizontal-scroll-container::-webkit-scrollbar {
            height: 8px;
        }
        .horizontal-scroll-container::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 5px;
        }
        .horizontal-scroll-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 5px;
        }
        
        .product-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.07);
            height: 100%; /* Ensure cards in a row have same height */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        .product-card img {
            width: 100%;
            height: 160px; /* Slightly increased height */
            object-fit: cover; /* Changed to cover to fill space better, can be 'contain' if preferred */
            border-radius: 8px; /* Slightly less rounded for internal image */
            margin-bottom: 10px;
            background-color: #f0f0f0; /* Placeholder background */
        }
        .product-card .discount {
            background: var(--primary-color);
            color: #fff;
            font-size: 0.75rem;
            padding: 3px 8px;
            border-radius: 5px;
            position: absolute;
            top: 10px;
            left: 10px;
            font-weight: 600;
        }
        .product-card .product-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 5px;
            white-space: normal; /* Allow text to wrap */
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2; /* Limit to 2 lines */
            -webkit-box-orient: vertical;
        }
        .product-price {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 5px;
        }
        .original-price {
            text-decoration: line-through;
            color: #888;
            font-size: 0.85rem;
            margin-bottom: 10px;
        }

        .footer {
            background-color: var(--dark-color);
            color: #f0f0f0;
            text-align: center;
            padding: 1.5rem;
            margin-top: auto; /* Push footer to bottom */
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        }
        .footer p {
            margin-bottom: 0;
            font-size: 0.9rem;
        }

        @media (max-width: 991.98px) {
            .hero {
                flex-direction: column;
                text-align: center;
                padding: 2rem;
            }
            .hero img {
                margin-top: 1.5rem;
                margin-left: 0;
                max-width: 100%;
            }
            .sidebar {
                border-right: none;
                border-bottom: 1px solid var(--border-color);
                margin-bottom: 25px;
                padding-bottom: 0;
            }
            .sidebar a {
                display: inline-block;
                margin-right: 15px;
            }
            .navbar .form-control {
                width: auto;
                flex-grow: 1;
            }
        }

        @media (max-width: 767.98px) {
            .navbar .d-flex {
                width: 100%;
                margin-top: 10px;
                margin-right: 0 !important;
                margin-left: 0 !important;
            }
            .navbar .d-flex input {
                width: 100%;
            }
            .navbar div:last-child {
                width: 100%;
                text-align: center;
                margin-top: 10px;
            }
            .navbar .fas {
                margin: 0 10px;
            }
            .sidebar {
                padding: 1rem;
                text-align: center;
            }
            .sidebar a {
                margin-right: 10px;
                font-size: 0.9rem;
                padding: 8px 0;
            }
            .hero h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="topbar">
        Perbanyak Belanja dan Dapatkan Poin Serta Merchandise Menarik! <a href="#" class="text-white text-decoration-underline">Belanja</a>
    </div>

    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">ReUseMart</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <form class="d-flex ms-lg-auto me-lg-3 my-2 my-lg-0">
                    <input class="form-control" type="search" placeholder="Apa yang anda butuhkan?" aria-label="Search">
                </form>
                <div class="d-flex align-items-center">
                    <i class="fas fa-user me-3"></i>
                    <i class="fas fa-heart me-3"></i>
                    <i class="fas fa-shopping-cart me-3"></i>
                    <a href="{{ route('loginPage') }}" class="btn btn-outline-dark">Login/Register</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-4 px-lg-5">
        <div class="row">
            <aside class="col-md-3 col-lg-2">
                <div class="sidebar">
                    <h6 class="fw-bold mb-3 text-uppercase text-dark">Kategori</h6>
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
                </div>
            </aside>
            <main class="col-md-9 col-lg-10">
                <section class="hero">
                    <div>
                        <h1>Diskon hingga 10%</h1>
                        <p class="lead">Temukan barang bekas berkualitas dengan harga terbaik!</p>
                        <a href="#" class="btn mt-3">Belanja Sekarang</a>
                    </div>
                    <img src="{{ asset('assets/images/keluarga di crop.PNG') }}" alt="Promo ReUseMart">
                </section>

                @if(isset($kategori))
                    <section class="flash-sale mt-4">
                        <h5 class="text-danger">KATEGORI</h5>
                        <h2 class="fw-bold">{{ $kategori->nama_kategori }}</h2>
                        <div class="horizontal-scroll-container mt-4 d-flex flex-nowrap px-2">
                            @forelse ($barang->where('status_barang', 'tersedia') as $item)
                                <div class="me-4" style="min-width: 220px; flex-shrink: 0;">
                                    <x-product-card :item="$item" />
                                </div>
                            @empty
                                <p class="ms-2 text-muted">Tidak ada barang dalam kategori ini.</p>
                            @endforelse
                        </div>
                    </section>
                @else
                    <section class="flash-sale mt-4">
                        <h5 class="text-danger">HITS HARI INI</h5>
                        <h2 class="fw-bold">Baru Ditambahkan</h2>
                        <div class="horizontal-scroll-container mt-4 d-flex flex-nowrap px-2">
                            @foreach ($barangBaru->where('status_barang', 'tersedia') as $barang)
                                <div class="me-4" style="min-width: 220px; flex-shrink: 0;">
                                    <x-product-card :item="$barang" />
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif
            </main>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 ReUseMart. All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>