<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReUseMart - E-Commerce</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #fff;
            color: #000;
        }
        /* Custom scrollbar for horizontal-scroll-container */
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
<body class="min-h-screen flex flex-col">
    <div class="bg-black text-white py-1.5 px-4 text-sm text-center">
        Perbanyak Belanja dan Dapatkan Poin Serta Merchandise Menarik! <a href="#" class="text-white underline hover:no-underline">Belanja</a>
    </div>

    <nav class="bg-white border-b border-gray-200 py-4">
        <div class="container mx-auto flex items-center justify-between px-4">
            <a class="text-xl font-bold text-gray-900" href="#">ReUseMart</a>
            <form class="flex-grow max-w-lg mx-4">
                <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" type="search" placeholder="Apa yang anda butuhkan?">
            </form>
            <div class="flex items-center space-x-6">
                <a href="{{ route('diskusi.index') }}" class="px-3 py-1.5 border border-gray-800 text-gray-800 rounded-lg text-sm hover:bg-gray-800 hover:text-white transition-colors duration-200">Diskusi</a>
                <a href="{{ route('alamat.manager') }}" class="px-3 py-1.5 border border-gray-800 text-gray-800 rounded-lg text-sm hover:bg-gray-800 hover:text-white transition-colors duration-200">Kelola Alamat</a>
                <a href="{{ route('profilPembeli') }}" class="text-gray-800 hover:text-red-500 transition-colors duration-200">
                    <i class="fas fa-user-circle text-xl"></i>
                </a>
                <a href="{{ route('liveCode.pembeli') }}" class="text-gray-800 hover:text-red-500 transition-colors duration-200"><i class="fas fa-heart text-xl"></i></a>
                <a href="{{ route('keranjang.index') }}" class="text-gray-800 hover:text-red-500 transition-colors duration-200"><i class="fas fa-shopping-cart text-xl"></i></a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto flex flex-grow px-4 mt-6">
        <aside class="w-1/5 pr-6 border-r border-gray-200 py-4">
            <h3 class="font-semibold text-lg mb-2">Kategori</h3>
            <nav>
                <a href="{{ route('kategori', ['id' => 1]) }}" class="block py-2 text-gray-900 hover:text-red-500 transition-colors duration-200">Elektronik & Gadget</a>
                <a href="{{ route('kategori', ['id' => 2]) }}" class="block py-2 text-gray-900 hover:text-red-500 transition-colors duration-200">Pakaian & Aksesoris</a>
                <a href="{{ route('kategori', ['id' => 3]) }}" class="block py-2 text-gray-900 hover:text-red-500 transition-colors duration-200">Perabotan Rumah Tangga</a>
                <a href="{{ route('kategori', ['id' => 4]) }}" class="block py-2 text-gray-900 hover:text-red-500 transition-colors duration-200">Buku, Alat Tulis, & Sekolah</a>
                <a href="{{ route('kategori', ['id' => 5]) }}" class="block py-2 text-gray-900 hover:text-red-500 transition-colors duration-200">Hobi, Mainan, & Koleksi</a>
                <a href="{{ route('kategori', ['id' => 6]) }}" class="block py-2 text-gray-900 hover:text-red-500 transition-colors duration-200">Perlengkapan Bayi & Anak</a>
                <a href="{{ route('kategori', ['id' => 7]) }}" class="block py-2 text-gray-900 hover:text-red-500 transition-colors duration-200">Otomotif & Aksesoris</a>
                <a href="{{ route('kategori', ['id' => 8]) }}" class="block py-2 text-gray-900 hover:text-red-500 transition-colors duration-200">Taman & Outdoor</a>
                <a href="{{ route('kategori', ['id' => 9]) }}" class="block py-2 text-gray-900 hover:text-red-500 transition-colors duration-200">Kantor & Industri</a>
                <a href="{{ route('kategori', ['id' => 10]) }}" class="block py-2 text-gray-900 hover:text-red-500 transition-colors duration-200">Kosmetik & Perawatan Diri</a>
            </nav>
        </aside>
        <main class="w-4/5 pl-6">
            <section class="hero bg-black text-white p-8 rounded-lg flex items-center justify-between shadow-lg">
                <div>
                    <h1 class="text-3xl font-bold mb-4">Diskon hingga 10%</h1>
                    <a href="#" class="px-6 py-3 border border-white text-white rounded-lg hover:bg-white hover:text-black transition-colors duration-200">Belanja Sekarang</a>
                </div>
                <img src="{{ asset('assets/images/keluarga di crop.PNG') }}" alt="Promo" class="max-w-xs md:max-w-md lg:max-w-lg rounded-lg">
            </section>

            @if(isset($kategori))
                <section class="mt-10">
                    <h5 class="text-red-500 text-lg font-semibold">Kategori</h5>
                    <h2 class="text-3xl font-bold mb-6">{{ $kategori->nama_kategori }}</h2>
                    <div class="horizontal-scroll-container flex flex-nowrap overflow-x-auto pb-4 px-2 -mx-2">
                        @forelse ($barang->where('status_barang', 'tersedia') as $item)
                            <div class="flex-shrink-0 w-52 mx-2">
                                {{-- Assuming x-product-card2 handles its own styling --}}
                                <x-product-card2 :item="$item" />
                            </div>
                        @empty
                            <p class="ml-2 text-gray-600">Tidak ada barang dalam kategori ini.</p>
                        @endforelse
                    </div>
                </section>
            @else
                <section class="mt-10">
                    <h5 class="text-red-500 text-lg font-semibold">Hits Hari Ini</h5>
                    <h2 class="text-3xl font-bold mb-6">Baru Ditambahkan</h2>
                    <div class="horizontal-scroll-container flex flex-nowrap overflow-x-auto pb-4 px-2 -mx-2">
                        @foreach ($barangBaru->where('status_barang', 'tersedia') as $barang)
                            <div class="flex-shrink-0 w-52 mx-2">
                                {{-- Assuming x-product-card2 handles its own styling --}}
                                <x-product-card2 :item="$barang" />
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif
        </main>
    </div>

    <footer class="bg-gray-900 text-white text-center py-4 mt-auto">
        <p>&copy; 2025 ReUseMart. All Rights Reserved.</p>
    </footer>
</body>
</html>