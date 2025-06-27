@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ReUseMart - Keranjang Belanja</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Font: Inter (mengganti Roboto untuk konsistensi) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa; /* Warna latar belakang umum */
        }
        /* Custom styles for Swiper navigation */
        .swiper-button-next,
        .swiper-button-prev {
            color: #374151; /* Ubah warna panah jadi abu-abu gelap */
            /* Tailwind classes below will handle sizing and opacity */
            @apply w-10 h-10 p-2 bg-white bg-opacity-70 rounded-full shadow-md transition-all duration-300;
        }
        .swiper-button-next:hover,
        .swiper-button-prev:hover {
             @apply bg-opacity-90 scale-105;
        }
        /* Override Swiper's default opacity on desktop for better visibility */
        @media (min-width: 768px) {
            .swiper-button-next,
            .swiper-button-prev {
                opacity: 1 !important;
            }
        }
        .swiper-button-next::after,
        .swiper-button-prev::after {
            font-size: 1.5rem !important; /* Ukuran ikon panah */
        }

        /* Custom styles for modal overlay */
        .modal-overlay {
            @apply fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 transition-opacity duration-300 ease-in-out;
        }
        .modal-container {
            @apply bg-white rounded-xl shadow-xl max-w-sm w-full mx-4 transform transition-all duration-300 ease-in-out;
        }
        .modal-header {
            @apply px-6 py-4 flex justify-between items-center border-b border-gray-200;
        }
        .modal-body {
            @apply px-6 py-4 text-gray-700;
        }
        .modal-footer {
            @apply px-6 py-4 flex justify-end items-center border-t border-gray-200 bg-gray-50 rounded-b-xl;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    @php
    $totalHarga = 0;
    foreach ($items as $item) {
        $totalHarga += $item->barang->harga_barang;
    }

    // Poin tukar dan diskon dihitung di backend, tetap seperti semula
    $poinTukar = session('poin_tukar', 0);
    if ($poinTukar > $pembeli->poin_pembeli) {
        $poinTukar = 0;
    }

    $faktorDiskon = ($totalHarga > 500000) ? 1 : 1; // Jika ada logika diskon berbeda, sesuaikan
    $nilaiDiskon = $poinTukar * 100 * $faktorDiskon;
    // Ongkir default di backend, tapi nanti di JS akan diupdate otomatis
    $ongkirDefault = ($totalHarga >= 1500000) ? 0 : 100000;
    $nilaiDiskon = min($nilaiDiskon, $totalHarga + $ongkirDefault);
    $totalPembayaranDefault = $totalHarga + $ongkirDefault - $nilaiDiskon;
    if ($totalPembayaranDefault < 0) {
        $totalPembayaranDefault = 0;
        $poinTukar = 0;
        session()->forget('poin_tukar');
    }
    $maxPoinTukar = floor(($totalHarga + $ongkirDefault) / (100 * $faktorDiskon)); // Perbaikan perhitungan maxPoinTukar
    if ($maxPoinTukar > $pembeli->poin_pembeli) {
        $maxPoinTukar = $pembeli->poin_pembeli;
    }
    @endphp

    <!-- Topbar Promosi -->
    <div class="topbar bg-gray-900 text-white py-2 px-4 text-center text-sm font-medium rounded-b-lg shadow-md">
        Perbanyak Belanja dan Dapatkan Poin Serta Merchandise Menarik!
        <a href="{{ route('dashboard.pembeli') }}" class="text-white hover:text-red-400 underline ml-1 transition duration-300">Belanja Sekarang!</a>
    </div>

    <!-- Navbar -->
    <nav class="bg-white shadow-sm py-4">
        <div class="container mx-auto px-4 flex items-center justify-between">
            <!-- Brand Logo -->
            <a class="text-2xl font-extrabold text-gray-800 hover:text-red-600 transition duration-300" href="{{ route('dashboard.pembeli') }}">ReUseMart</a>

            <!-- Search Bar -->
            <form class="flex-grow max-w-md mx-4">
                <div class="relative">
                    <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition duration-300" type="search" placeholder="Cari produk impianmu...">
                    <button type="submit" class="absolute right-0 top-0 mt-2 mr-3 text-gray-500 hover:text-red-500 transition duration-300">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

            <!-- Navigation Icons/Buttons -->
            <div class="flex items-center space-x-6 text-gray-700">
                <!-- Diskusi Button -->
                <a href="{{ route('diskusi.index') }}" class="px-3 py-2 text-gray-700 rounded-lg font-medium hover:bg-gray-100 hover:text-red-600 transition duration-300">Diskusi</a>
                <!-- Kelola Alamat Button -->
                <a href="{{ route('alamat.manager') }}" class="px-3 py-2 text-gray-700 rounded-lg font-medium hover:bg-gray-100 hover:text-red-600 transition duration-300">Kelola Alamat</a>
                <!-- User Profile Icon -->
                <a href="{{ route('profilPembeli') }}" class="hover:text-red-500 transition duration-300" title="Profil Pengguna">
                    <i class="fas fa-user-circle text-xl"></i>
                </a>
                <!-- Wishlist Icon -->
                <a href="{{ route('liveCode.pembeli') }}" class="hover:text-red-500 transition duration-300" title="Daftar Keinginan">
                    <i class="fas fa-heart text-xl"></i>
                </a>
                <!-- Shopping Cart Icon - Marked as active -->
                <a href="{{ route('keranjang.index') }}" class="relative hover:text-red-500 transition duration-300 p-2 border border-gray-700 rounded-lg" title="Keranjang Belanja">
                    <i class="fas fa-shopping-cart text-xl"></i>
                    <!-- Notifikasi keranjang (opsional, contoh: jika ada 3 item) -->
                    <span class="absolute -top-1 -right-2 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full">3</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <main id="mainContent" class="container mx-auto mt-8 px-4 flex-grow"
          data-totalharga="{{ $totalHarga }}"
          data-faktordiskon="{{ $faktorDiskon }}">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 border-l-4 border-red-600 pl-4 leading-tight">Keranjang Belanja</h2>

        @if($items->isEmpty())
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg shadow-sm flex items-center justify-between">
                <p class="font-medium">Belum ada barang yang Anda pilih.</p>
                <a href="{{ route('dashboard.pembeli') }}" class="px-5 py-2 bg-gray-800 text-white rounded-lg font-medium hover:bg-gray-700 transition duration-300 shadow-md">Belanja Sekarang</a>
            </div>
        @else
            <!-- Swiper Carousel untuk Item Keranjang -->
            <div class="swiper mySwiper mb-8">
                <div class="swiper-wrapper">
                    @foreach($items as $item)
                    <div class="swiper-slide h-auto">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col h-full transform hover:scale-103 transition-all duration-300">
                            <img src="{{ asset('storage/' . $item->barang->gambar_barang) }}" class="w-full h-48 object-cover rounded-t-xl transition-transform duration-300 hover:scale-105" alt="{{ $item->barang->nama_barang }}">
                            <div class="p-4 flex flex-col justify-between flex-grow">
                                <div>
                                    <h5 class="text-lg font-semibold text-gray-800 mb-1 truncate">{{ $item->barang->nama_barang }}</h5>
                                    <p class="text-red-600 font-bold text-xl mb-3">
                                        Rp {{ number_format($item->barang->harga_barang, 0, ',', '.') }}
                                    </p>
                                </div>
                                <button type="button" class="btn bg-red-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-700 transition duration-300 w-full btnHapus" data-id="{{ $item->id_barang }}">Hapus</button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination mt-4"></div>
                <!-- Add Navigation (Next/Prev buttons) -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>

            <form id="checkoutForm" action="{{ route('transaksi.checkout') }}" method="POST" class="bg-white shadow-lg rounded-xl p-6 border border-gray-200">
                @csrf

                <!-- Alamat -->
                <div class="mb-5">
                    <label for="alamat_pembeli" class="block text-gray-700 text-lg font-semibold mb-2">Pilih Alamat Pengiriman:</label>
                    <select name="alamat_pembeli" id="alamat_pembeli" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" required>
                        @if ($alamatUtama)
                            <option value="{{ $alamatUtama->id_alamat }}">
                                [Utama] {{ $alamatUtama->detail }}
                            </option>
                        @endif
                        @foreach($alamatPembeli as $alamat)
                            @if (!$alamatUtama || $alamat->id_alamat !== $alamatUtama->id_alamat)
                                <option value="{{ $alamat->id_alamat }}">
                                    {{ $alamat->detail }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <!-- Metode Pengiriman -->
                <div class="mb-5">
                    <label for="metode_pengiriman" class="block text-gray-700 text-lg font-semibold mb-2">Pilih Metode Pengiriman:</label>
                    <select name="metode_pengiriman" id="metode_pengiriman" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" required>
                        <option value="" disabled selected>-- Pilih Metode Pengiriman --</option>
                    </select>
                </div>

                <!-- Poin Anda -->
                <div class="mb-5">
                    <label class="block text-gray-700 text-lg font-semibold mb-2">Poin Anda:</label>
                    <div class="bg-gray-800 text-white p-4 rounded-lg flex items-center shadow-sm">
                        <i class="fas fa-coins text-yellow-400 text-2xl mr-3"></i>
                        <div>
                            <strong id="poinPembeli" class="text-xl">{{ $pembeli->poin_pembeli }}</strong> poin tersedia
                        </div>
                    </div>
                </div>

                <!-- Poin Tukar -->
                <div class="mb-6">
                    <label for="poin_tukar" class="block text-gray-700 text-lg font-semibold mb-2">Tukar Poin:</label>
                    <input type="number" id="poin_tukar" name="poin_tukar" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" min="0" max="{{ $maxPoinTukar }}" value="{{ $poinTukar }}" step="1" />
                    <p class="text-sm text-gray-600 mt-2">Anda dapat menukar hingga {{ $maxPoinTukar }} poin.</p>
                </div>

                <!-- Ringkasan Pembayaran -->
                <div class="border-t border-gray-200 pt-6 mt-6">
                    <div class="flex justify-between items-center mb-3">
                        <h5 class="text-lg text-gray-700">Subtotal:</h5>
                        <span class="text-red-600 font-bold text-lg" id="subtotalDisplay">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-3">
                        <h5 class="text-lg text-gray-700">Ongkir:</h5>
                        <span class="text-red-600 font-bold text-lg" id="ongkirDisplay">Rp {{ number_format($ongkirDefault, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-4">
                        <h5 class="text-lg text-gray-700">Diskon dari Poin:</h5>
                        <span class="text-green-600 font-bold text-lg" id="diskonDisplay">- Rp {{ number_format($nilaiDiskon, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center border-t-2 border-gray-300 pt-4">
                        <h4 class="text-2xl font-bold text-gray-800">Total Pembayaran:</h4>
                        <span class="text-red-600 font-extrabold text-3xl" id="totalDisplay">Rp {{ number_format($totalPembayaranDefault, 0, ',', '.') }}</span>
                    </div>
                    <button type="submit" class="w-full mt-8 px-8 py-4 bg-red-600 text-white font-bold text-xl rounded-xl hover:bg-red-700 transition duration-300 shadow-lg transform hover:scale-105 active:scale-95 focus:outline-none focus:ring-4 focus:ring-red-300">Checkout</button>
                </div>
            </form>
        @endif
    </main>

    <!-- Modals (Custom Tailwind-based) -->
    <!-- Confirm Delete Modal -->
    <div id="confirmDeleteModal" class="modal-overlay hidden opacity-0 pointer-events-none">
        <div class="modal-container">
            <form id="formDelete" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="text-xl font-semibold" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="text-gray-500 hover:text-gray-700 text-2xl" onclick="closeModal('confirmDeleteModal')">&times;</button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus barang ini dari keranjang?
                </div>
                <div class="modal-footer">
                    <button type="button" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-300" onclick="closeModal('confirmDeleteModal')">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-300">Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Info Modal -->
    <div id="infoModal" class="modal-overlay hidden opacity-0 pointer-events-none">
        <div class="modal-container">
            <div class="modal-header">
                <h5 class="text-xl font-semibold" id="infoModalLabel">Informasi</h5>
                <button type="button" class="text-gray-500 hover:text-gray-700 text-2xl" onclick="closeModal('infoModal')">&times;</button>
            </div>
            <div class="modal-body" id="infoModalBody"></div>
            <div class="modal-footer">
                <button type="button" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300" onclick="closeModal('infoModal')">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <script>
        // Custom Modal Functions (mengganti Bootstrap Modal JS)
        function showModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                // Remove hidden first to make it visible (display: flex from @apply)
                modal.classList.remove('hidden');
                // Make it clickable
                modal.classList.remove('pointer-events-none');
                // Apply opacity transition after a short delay to allow 'display' change to render
                setTimeout(() => {
                    modal.classList.remove('opacity-0');
                }, 10);
            }
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                // Start fade out
                modal.classList.add('opacity-0');
                // Make it not clickable immediately
                modal.classList.add('pointer-events-none');
                // After fade out, hide completely
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300); // Should match transition-opacity duration in CSS
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Event listener untuk tombol hapus
            document.querySelectorAll('.btnHapus').forEach(btn => {
                btn.addEventListener('click', function () {
                    let idBarang = this.dataset.id;
                    let form = document.getElementById('formDelete');
                    form.action = '/keranjang/hapus/' + idBarang;
                    showModal('confirmDeleteModal'); // Menggunakan fungsi modal kustom
                });
            });

            // Jika ada session error_poin_tukar, tampilkan modal info
            @if(session('error_poin_tukar'))
                document.getElementById('infoModalBody').textContent = "{{ session('error_poin_tukar') }}";
                showModal('infoModal'); // Menggunakan fungsi modal kustom

                const inputPoin = document.getElementById('poin_tukar');
                if (inputPoin) {
                    inputPoin.value = 0;
                }
            @endif

            // Logic perhitungan harga dan ongkir
            const mainContentContainer = document.getElementById('mainContent'); // Mengambil elemen main dengan ID baru
            const alamatSelect = document.getElementById('alamat_pembeli');
            const metodeSelect = document.getElementById('metode_pengiriman');
            const poinTukarInput = document.getElementById('poin_tukar');

            const alamatMap = {
                @if ($alamatUtama)
                    "{{ $alamatUtama->id_alamat }}": `{{ strtolower($alamatUtama->detail) }}`,
                @endif
                @foreach ($alamatPembeli as $alamat)
                    "{{ $alamat->id_alamat }}": `{{ strtolower($alamat->detail) }}`,
                @endforeach
            };

            const subtotalDisplay = document.getElementById('subtotalDisplay');
            const ongkirDisplay = document.getElementById('ongkirDisplay');
            const diskonDisplay = document.getElementById('diskonDisplay');
            const totalDisplay = document.getElementById('totalDisplay');

            // Mengambil nilai dari dataset elemen mainContentContainer
            const totalHarga = parseInt(mainContentContainer.dataset.totalharga);
            const faktorDiskon = parseFloat(mainContentContainer.dataset.faktordiskon);
            const poinPembeliSaatIni = parseInt(document.getElementById('poinPembeli').textContent);

            function updateMetodePengiriman() {
                const selectedAlamatId = alamatSelect.value;
                const alamatDetail = alamatMap[selectedAlamatId] || "";

                metodeSelect.innerHTML = '<option value="" disabled selected>-- Pilih Metode Pengiriman --</option>';

                if (alamatDetail.includes('yogyakarta')) {
                    const optionKurir = document.createElement('option');
                    optionKurir.value = 'kurir';
                    optionKurir.textContent = 'Kurir';

                    const optionAmbil = document.createElement('option');
                    optionAmbil.value = 'ambil_sendiri';
                    optionAmbil.textContent = 'Ambil Sendiri';

                    metodeSelect.appendChild(optionKurir);
                    metodeSelect.appendChild(optionAmbil);

                    metodeSelect.disabled = false;
                } else if (alamatDetail.trim() !== '') {
                    const optionAmbil = document.createElement('option');
                    optionAmbil.value = 'ambil_sendiri';
                    optionAmbil.textContent = 'Ambil Sendiri';

                    metodeSelect.appendChild(optionAmbil);

                    metodeSelect.disabled = false;
                } else {
                    metodeSelect.disabled = true;
                }

                metodeSelect.value = ""; // Reset metode selected
                updateHarga();
            }

            function formatRupiah(angka) {
                return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            function updateHarga() {
                let ongkir = 0;
                const metode = metodeSelect.value;

                if (metode === 'kurir') {
                    ongkir = totalHarga < 1500000 ? 100000 : 0;
                } else if (metode === 'ambil_sendiri') {
                    ongkir = 0;
                }

                let poinTukar = parseInt(poinTukarInput.value) || 0;

                // Pastikan poinTukar tidak melebihi poin yang tersedia
                if (poinTukar > poinPembeliSaatIni) {
                    poinTukar = poinPembeliSaatIni;
                    poinTukarInput.value = poinPembeliSaatIni;
                }
                // Pastikan poinTukar tidak melebihi maxPoinTukar yang diizinkan (berdasarkan harga total+ongkir)
                const maxPoinForCurrentOrder = Math.floor((totalHarga + ongkir) / (100 * faktorDiskon));
                if (poinTukar > maxPoinForCurrentOrder) {
                    poinTukar = maxPoinForCurrentOrder;
                    poinTukarInput.value = poinTukar;
                }

                let diskon = poinTukar * 100 * faktorDiskon;
                const totalMaksimal = totalHarga + ongkir;

                // Validasi supaya diskon tidak lebih dari totalMaksimal
                if (diskon > totalMaksimal) {
                    diskon = totalMaksimal; // Diskon maksimal adalah totalHarga + ongkir
                    poinTukar = Math.floor(totalMaksimal / (100 * faktorDiskon)); // Sesuaikan poin tukar
                    poinTukarInput.value = poinTukar;
                }

                let totalPembayaran = totalHarga + ongkir - diskon;
                if (totalPembayaran < 0) totalPembayaran = 0;

                subtotalDisplay.textContent = 'Rp ' + formatRupiah(totalHarga);
                ongkirDisplay.textContent = 'Rp ' + formatRupiah(ongkir);
                diskonDisplay.textContent = '- Rp ' + formatRupiah(diskon);
                totalDisplay.textContent = 'Rp ' + formatRupiah(totalPembayaran);
            }

            alamatSelect.addEventListener('change', updateMetodePengiriman);
            metodeSelect.addEventListener('change', updateHarga);
            poinTukarInput.addEventListener('input', updateHarga);

            // Inisialisasi pada load
            updateMetodePengiriman();

            // Handle form submission
            const checkoutForm = document.getElementById('checkoutForm');
            checkoutForm.addEventListener('submit', function (e) {
                const metode = metodeSelect.value;
                if (!metode) {
                    e.preventDefault();
                    document.getElementById('infoModalBody').textContent = 'Silakan pilih metode pengiriman terlebih dahulu.';
                    showModal('infoModal');
                    metodeSelect.focus(); // Fokus ke elemen select
                }
            });

            // Inisialisasi Swiper
            var swiper = new Swiper(".mySwiper", {
                slidesPerView: 3,
                spaceBetween: 20,
                loop: false, // Biasanya loop false untuk keranjang
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                breakpoints: {
                    // Ketika lebar layar <= 576px
                    320: {
                        slidesPerView: 1,
                        spaceBetween: 10,
                    },
                    // Ketika lebar layar <= 768px
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 15,
                    },
                    // Ketika lebar layar <= 992px
                    992: {
                        slidesPerView: 3,
                        spaceBetween: 20,
                    }
                }
            });
        });
    </script>
</body>
</html>
@endsection
