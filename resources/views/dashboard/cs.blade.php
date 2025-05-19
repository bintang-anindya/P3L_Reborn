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

                <a href="#" class="text-dark"><i class="fas fa-heart"></i></a>
                <a href="#" class="text-dark"><i class="fas fa-shopping-cart"></i></a>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <aside class="col-md-2 sidebar">
                <a href="#">Fashion Wanita</a>
                <a href="#">Fashion Pria</a>
                <a href="#">Elektronik</a>
                <a href="#">Gaya Hidup dan Perabot</a>
                <a href="#">Olahraga</a>
                <a href="#">Keperluan Bayi</a>
                <a href="#">Hewan Peliharaan</a>
                <a href="#">Kecantikan</a>
            </aside>
            <main class="col-md-10">
                <section class="hero d-flex justify-content-between align-items-center">
                    <div>
                        <h1>Diskon hingga 10%</h1>
                        <a href="#" class="btn btn-outline-light mt-3">Belanja Sekarang</a>
                    </div>
                    <img src="assets/images/keluarga di crop.PNG" alt="Promo">
                </section>

                <section class="flash-sale mt-5">
                    <h5 class="text-danger">Hits Hari Ini</h5>
                    <h2 class="fw-bold">Baru Ditambahkan</h2>
                    <div class="horizontal-scroll-container mt-4 d-flex flex-nowrap">
                        <div class="col-md-2">
                            <div class="product-card position-relative">
                                <div class="discount">-40%</div>
                                <img src="https://via.placeholder.com/150" alt="Gamepad">
                                <p class="mt-2">HAVIT HV-G92 Gamepad</p>
                                <div><span class="product-price">$120</span> <span class="original-price">$160</span></div>
                                <div class="text-warning">★★★★★ (88)</div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="product-card position-relative">
                                <div class="discount">-40%</div>
                                <img src="https://via.placeholder.com/150" alt="Gamepad">
                                <p class="mt-2">HAVIT HV-G92 Gamepad</p>
                                <div><span class="product-price">$120</span> <span class="original-price">$160</span></div>
                                <div class="text-warning">★★★★★ (88)</div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="product-card position-relative">
                                <div class="discount">-40%</div>
                                <img src="https://via.placeholder.com/150" alt="Gamepad">
                                <p class="mt-2">HAVIT HV-G92 Gamepad</p>
                                <div><span class="product-price">$120</span> <span class="original-price">$160</span></div>
                                <div class="text-warning">★★★★★ (88)</div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="product-card position-relative">
                                <div class="discount">-40%</div>
                                <img src="https://via.placeholder.com/150" alt="Gamepad">
                                <p class="mt-2">HAVIT HV-G92 Gamepad</p>
                                <div><span class="product-price">$120</span> <span class="original-price">$160</span></div>
                                <div class="text-warning">★★★★★ (88)</div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="product-card position-relative">
                                <div class="discount">-40%</div>
                                <img src="https://via.placeholder.com/150" alt="Gamepad">
                                <p class="mt-2">HAVIT HV-G92 Gamepad</p>
                                <div><span class="product-price">$120</span> <span class="original-price">$160</span></div>
                                <div class="text-warning">★★★★★ (88)</div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="product-card position-relative">
                                <div class="discount">-40%</div>
                                <img src="https://via.placeholder.com/150" alt="Gamepad">
                                <p class="mt-2">HAVIT HV-G92 Gamepad</p>
                                <div><span class="product-price">$120</span> <span class="original-price">$160</span></div>
                                <div class="text-warning">★★★★★ (88)</div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="product-card position-relative">
                                <div class="discount">-40%</div>
                                <img src="https://via.placeholder.com/150" alt="Gamepad">
                                <p class="mt-2">HAVIT HV-G92 Gamepad</p>
                                <div><span class="product-price">$120</span> <span class="original-price">$160</span></div>
                                <div class="text-warning">★★★★★ (88)</div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="product-card position-relative">
                                <div class="discount">-40%</div>
                                <img src="https://via.placeholder.com/150" alt="Gamepad">
                                <p class="mt-2">HAVIT HV-G92 Gamepad</p>
                                <div><span class="product-price">$120</span> <span class="original-price">$160</span></div>
                                <div class="text-warning">★★★★★ (88)</div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="product-card position-relative">
                                <div class="discount">-40%</div>
                                <img src="https://via.placeholder.com/150" alt="Gamepad">
                                <p class="mt-2">HAVIT HV-G92 Gamepad</p>
                                <div><span class="product-price">$120</span> <span class="original-price">$160</span></div>
                                <div class="text-warning">★★★★★ (88)</div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="flash-sale mt-5">
                    <h5 class="text-danger">Hits Hari Ini</h5>
                    <h2 class="fw-bold">Flash Sales</h2>
                    <div class="row mt-4">
                        <div class="col-md-2">
                            <div class="product-card position-relative">
                                <div class="discount">-40%</div>
                                <img src="https://m.media-amazon.com/images/I/51T%2B823iYtL._AC_UF1000,1000_QL80_.jpg" alt="Gamepad">
                                <p class="mt-2">HAVIT HV-G92 Gamepad</p>
                                <div><span class="product-price">$120</span> <span class="original-price">$160</span></div>
                                <div class="text-warning">★★★★★ (88)</div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="product-card position-relative">
                                <div class="discount">-40%</div>
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/be/Joko_Widodo_2019_official_portrait.jpg/250px-Joko_Widodo_2019_official_portrait.jpg" alt="Gamepad">
                                <p class="mt-2">Jokowi</p>
                                <div><span class="product-price">$5</span> <span class="original-price">$7</span></div>
                                <div class="text-warning">★ (1)</div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="product-card position-relative">
                                <div class="discount">-40%</div>
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTLsCm4rARF1hyTXZYmp5VpIoVODucVxFPXTQ&s" alt="Gamepad">
                                <p class="mt-2">Air Jordick</p>
                                <div><span class="product-price">$1299</span> <span class="original-price">$1899</span></div>
                                <div class="text-warning">★★★★★ (143)</div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </div>

    <footer class="footer mt-5">
        <p>&copy; 2025 ReUseMart. All Rights Reserved.</p>
    </footer>
</body>
</html>