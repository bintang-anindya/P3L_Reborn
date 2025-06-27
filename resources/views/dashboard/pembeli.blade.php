<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReUseMart - E-Commerce</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
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

        /* Custom scrollbar for horizontal-scroll-container */
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

        /* Product Card specific styling not directly in Tailwind */
        .product-card-tailwind {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.07);
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .product-card-tailwind:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        .product-card-tailwind img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
            background-color: #f0f0f0;
        }
        .product-card-tailwind .discount {
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
        .product-card-tailwind .product-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 5px;
            white-space: normal;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
        .product-card-tailwind .product-price {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 5px;
        }
        .product-card-tailwind .original-price {
            text-decoration: line-through;
            color: #888;
            font-size: 0.85rem;
            margin-bottom: 10px;
        }

        /* Responsive adjustments */
        @media (max-width: 991.98px) {
            .hero-mobile-flex-col {
                flex-direction: column;
                text-align: center;
            }
            .hero-img-mobile-mt {
                margin-top: 1.5rem;
                margin-left: 0;
                max-width: 100%;
            }
            .sidebar-mobile-styles {
                border-right: none;
                border-bottom: 1px solid var(--border-color);
                margin-bottom: 25px;
                padding-bottom: 0;
            }
            .sidebar-link-inline-block a {
                display: inline-block;
                margin-right: 15px;
            }
        }

        @media (max-width: 767.98px) {
            .navbar-search-mobile {
                width: 100%;
                margin-top: 10px;
                margin-right: 0 !important;
                margin-left: 0 !important;
            }
            .navbar-search-mobile input {
                width: 100%;
            }
            .navbar-icons-mobile {
                width: 100%;
                text-align: center;
                margin-top: 10px;
            }
            .navbar-icons-mobile .fas {
                margin: 0 10px;
            }
            .sidebar-mobile-center {
                padding: 1rem;
                text-align: center;
            }
            .sidebar-mobile-link-small a {
                margin-right: 10px;
                font-size: 0.9rem;
                padding: 8px 0;
            }
            .hero-h1-mobile {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    <div class="bg-black text-white py-2 px-4 text-sm text-center font-poppins">
        Perbanyak Belanja dan Dapatkan Poin Serta Merchandise Menarik! <a href="#" class="text-white underline font-semibold">Belanja</a>
    </div>

    <nav class="bg-white border-b border-gray-200 shadow-md py-4">
        <div class="container mx-auto flex items-center justify-between px-4">
            <a class="text-2xl font-bold text-gray-900 font-poppins" href="{{ route('home') }}">ReUseMart</a>
            <div class="flex-grow max-w-lg mx-4">
                <form class="flex">
                    <input class="w-full px-5 py-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-red-500 text-base" type="search" placeholder="Apa yang anda butuhkan?">
                </form>
            </div>
            <div class="flex items-center space-x-6 text-gray-700">
                <a href="{{ route('diskusi.index') }}" class="px-4 py-2 border border-gray-800 text-gray-800 rounded-full text-sm font-semibold hover:bg-gray-800 hover:text-white transition-colors duration-300">Diskusi</a>
                <a href="{{ route('alamat.manager') }}" class="px-4 py-2 border border-gray-800 text-gray-800 rounded-full text-sm font-semibold hover:bg-gray-800 hover:text-white transition-colors duration-300">Kelola Alamat</a>
                <a href="{{ route('profilPembeli') }}" class="hover:text-red-500 transition-colors duration-300">
                    <i class="fas fa-user text-xl"></i>
                </a>
                <a href="{{ route('liveCode.pembeli') }}" class="hover:text-red-500 transition-colors duration-300"><i class="fas fa-heart text-xl"></i></a>
                <a href="{{ route('keranjang.index') }}" class="hover:text-red-500 transition-colors duration-300"><i class="fas fa-shopping-cart text-xl"></i></a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto flex flex-grow px-4 mt-6 lg:px-5">
        <aside class="w-full md:w-1/3 lg:w-1/5 pr-6 py-4 sidebar-mobile-styles rounded-xl shadow-md bg-white">
            <h6 class="font-bold mb-3 text-uppercase text-gray-900 text-lg font-poppins">Kategori</h6>
            <nav class="sidebar-link-inline-block sidebar-mobile-link-small">
                <a href="{{ route('kategori', ['id' => 1]) }}" class="block py-2 text-gray-700 font-medium hover:text-red-500 hover:translate-x-1 transition-all duration-300">Elektronik & Gadget</a>
                <a href="{{ route('kategori', ['id' => 2]) }}" class="block py-2 text-gray-700 font-medium hover:text-red-500 hover:translate-x-1 transition-all duration-300">Pakaian & Aksesoris</a>
                <a href="{{ route('kategori', ['id' => 3]) }}" class="block py-2 text-gray-700 font-medium hover:text-red-500 hover:translate-x-1 transition-all duration-300">Perabotan Rumah Tangga</a>
                <a href="{{ route('kategori', ['id' => 4]) }}" class="block py-2 text-gray-700 font-medium hover:text-red-500 hover:translate-x-1 transition-all duration-300">Buku, Alat Tulis, & Sekolah</a>
                <a href="{{ route('kategori', ['id' => 5]) }}" class="block py-2 text-gray-700 font-medium hover:text-red-500 hover:translate-x-1 transition-all duration-300">Hobi, Mainan, & Koleksi</a>
                <a href="{{ route('kategori', ['id' => 6]) }}" class="block py-2 text-gray-700 font-medium hover:text-red-500 hover:translate-x-1 transition-all duration-300">Perlengkapan Bayi & Anak</a>
                <a href="{{ route('kategori', ['id' => 7]) }}" class="block py-2 text-gray-700 font-medium hover:text-red-500 hover:translate-x-1 transition-all duration-300">Otomotif & Aksesoris</a>
                <a href="{{ route('kategori', ['id' => 8]) }}" class="block py-2 text-gray-700 font-medium hover:text-red-500 hover:translate-x-1 transition-all duration-300">Taman & Outdoor</a>
                <a href="{{ route('kategori', ['id' => 9]) }}" class="block py-2 text-gray-700 font-medium hover:text-red-500 hover:translate-x-1 transition-all duration-300">Kantor & Industri</a>
                <a href="{{ route('kategori', ['id' => 10]) }}" class="block py-2 text-gray-700 font-medium hover:text-red-500 hover:translate-x-1 transition-all duration-300">Kosmetik & Perawatan Diri</a>
            </nav>
        </aside>
        <main class="w-full md:w-2/3 lg:w-4/5 md:pl-6 mt-6 md:mt-0">
            <section class="hero bg-gradient-to-br from-black to-gray-800 text-white p-8 rounded-xl flex items-center justify-between shadow-xl hero-mobile-flex-col">
                <div>
                    <h1 class="text-4xl font-bold mb-4 leading-tight hero-h1-mobile">Diskon hingga 10%</h1>
                    <p class="text-lg mb-6">Temukan barang bekas berkualitas dengan harga terbaik!</p>
                    <a href="#" class="inline-block bg-red-500 hover:bg-red-600 text-white px-8 py-3 rounded-full font-semibold transition-all duration-300 shadow-lg hover:shadow-xl">Belanja Sekarang</a>
                </div>
                <img src="{{ asset('assets/images/keluarga di crop.PNG') }}" alt="Promo ReUseMart" class="max-w-sm h-auto rounded-lg ml-8 hero-img-mobile-mt filter drop-shadow-lg">
            </section>

            @if(isset($kategori))
                <section class="flash-sale bg-gray-50 p-8 rounded-xl mt-8 shadow-md">
                    <h5 class="text-red-500 text-sm font-semibold uppercase tracking-wider mb-2">KATEGORI</h5>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ $kategori->nama_kategori }}</h2>
                    <div class="horizontal-scroll-container flex flex-nowrap overflow-x-auto pb-4 px-2 -mx-2">
                        @forelse ($barang->where('status_barang', 'tersedia') as $item)
                            <div class="flex-shrink-0 w-56 mx-2">
                                <div class="product-card-tailwind">
                                    {{-- Assuming the actual image path and routes are handled correctly --}}
                                    @if($item->diskon > 0)
                                        <span class="discount">{{ $item->diskon }}% OFF</span>
                                    @endif
                                    <img src="{{ $item->gambar_barang ? asset('storage/' . $item->gambar_barang) : asset('assets/images/default-product.png') }}" alt="{{ $item->nama_barang }}">
                                    <div class="flex-grow flex flex-col justify-between">
                                        <h3 class="product-title">{{ $item->nama_barang }}</h3>
                                        @if($item->diskon > 0)
                                            <p class="original-price">Rp {{ number_format($item->harga_normal, 0, ',', '.') }}</p>
                                        @endif
                                        <p class="product-price">Rp {{ number_format($item->harga_diskon > 0 ? $item->harga_diskon : $item->harga_normal, 0, ',', '.') }}</p>
                                        {{-- Add a link to product detail page if available --}}
                                        <a href="{{ route('detailBarangPembeli', $item->id_barang) }}" class="mt-auto block bg-blue-500 text-white py-2 px-4 rounded-md text-sm font-semibold hover:bg-blue-600 transition-colors duration-300">Lihat Detail</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="ml-2 text-gray-600">Tidak ada barang dalam kategori ini.</p>
                        @endforelse
                    </div>
                </section>
            @else
                <section class="flash-sale bg-gray-50 p-8 rounded-xl mt-8 shadow-md">
                    <h5 class="text-red-500 text-sm font-semibold uppercase tracking-wider mb-2">HITS HARI INI</h5>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Baru Ditambahkan</h2>
                    <div class="horizontal-scroll-container flex flex-nowrap overflow-x-auto pb-4 px-2 -mx-2">
                        @foreach ($barangBaru->where('status_barang', 'tersedia') as $barang)
                            <div class="flex-shrink-0 w-56 mx-2">
                                <div class="product-card-tailwind">
                                    {{-- Assuming the actual image path and routes are handled correctly --}}
                                    @if($barang->diskon > 0)
                                        <span class="discount">{{ $barang->diskon }}% OFF</span>
                                    @endif
                                    <img src="{{ $barang->gambar_barang ? asset('storage/' . $barang->gambar_barang) : asset('assets/images/default-product.png') }}" alt="{{ $barang->nama_barang }}">
                                    <div class="flex-grow flex flex-col justify-between">
                                        <h3 class="product-title">{{ $barang->nama_barang }}</h3>
                                        @if($barang->diskon > 0)
                                            <p class="original-price">Rp {{ number_format($barang->harga_normal, 0, ',', '.') }}</p>
                                        @endif
                                        <p class="product-price">Rp {{ number_format($barang->harga_diskon > 0 ? $barang->harga_diskon : $barang->harga_normal, 0, ',', '.') }}</p>
                                        {{-- Add a link to product detail page if available --}}
                                        <a href="{{ route('detailBarangPembeli', $barang->id_barang) }}" class="mt-auto block bg-blue-500 text-white py-2 px-4 rounded-md text-sm font-semibold hover:bg-blue-600 transition-colors duration-300">Lihat Detail</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif
        </main>
    </div>

    <footer class="bg-gray-900 text-gray-200 text-center py-6 mt-auto shadow-inner">
        <p class="text-sm font-roboto">&copy; 2025 ReUseMart. All Rights Reserved.</p>
    </footer>
</body>
</html>