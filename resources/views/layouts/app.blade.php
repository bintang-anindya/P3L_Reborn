<!DOCTYPE html>
<html lang="id"> {{-- Mengubah lang ke id untuk konsistensi --}}
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReUseMart</title>
    {{-- Hapus Bootstrap CSS karena kita akan pakai Tailwind --}}
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"> --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"> --}}

    {{-- Tailwind CSS CDN. Pastikan ini selalu dimuat. --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Jika Anda menggunakan konfigurasi kustom atau postcss, Anda akan mengkompilasi Tailwind dan menyertakan file CSS Anda di sini. --}}
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}

    {{-- Font Awesome untuk ikon, jika diperlukan --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Roboto', sans-serif; {{-- Menggunakan font Roboto yang konsisten dengan halaman utama --}}
            background-color: #f8f9fa; {{-- Warna latar belakang terang --}}
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        /* Navigasi (jika ada di layout ini, menyesuaikan dengan ReUseMart home) */
        .nav-link-custom { /* Nama kelas kustom untuk menghindari konflik */
            color: #000 !important;
            transition: color 0.2s ease-in-out; /* Animasi transisi hover */
        }

        .nav-link-custom:hover {
            color: #dc3545 !important; /* Warna merah yang digunakan di halaman utama */
        }

        /* Penyesuaian untuk sticky footer */
        footer {
            background-color: #1a202c; /* Warna abu-abu gelap dari footer halaman utama */
            color: #cbd5e0; /* Warna teks abu-abu terang */
            text-align: center;
            padding: 1rem;
            margin-top: auto; /* Mendorong footer ke bagian bawah */
            width: 100%;
        }

        footer a {
            color: #cbd5e0; /* Warna tautan di footer */
            text-decoration: none;
            transition: color 0.2s ease-in-out;
        }

        footer a:hover {
            color: #fff;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen"> {{-- Memindahkan properti flexbox ke body --}}

    {{-- Main content area --}}
    <div class="flex-grow"> {{-- flex-grow-1 di Bootstrap, menjadi flex-grow di Tailwind --}}
        @yield('content')
    </div>

    <footer class="mt-auto py-4 bg-gray-900 text-white text-center"> {{-- Menggunakan kelas Tailwind untuk styling footer --}}
        <div class="container mx-auto px-4"> {{-- container text-center --}}
            <p>&copy; {{ date('Y') }} ReUseMart. All rights reserved.</p>
            <div class="mt-2">
                <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">Privacy Policy</a>
                <span class="mx-2">|</span>
                <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">Terms & Conditions</a>
            </div>
        </div>
    </footer>

    {{-- Hapus Bootstrap JS karena kita tidak memakainya lagi --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}

    <script>
        // Logika JavaScript untuk 'countdown' tetap sama, pastikan elemennya ada di halaman anak.
        const countdownEl = document.getElementById('countdown');

        if (countdownEl) {
            const end = new Date();
            end.setDate(end.getDate() + 3); // Default 3 hari dari sekarang

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = end - now;

                if (distance < 0) {
                    countdownEl.innerHTML = "EXPIRED";
                    clearInterval(countdownInterval);
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                countdownEl.innerHTML = `Days ${days < 10 ? '0'+days : days} :
                                         ${hours < 10 ? '0'+hours : hours} :
                                         ${minutes < 10 ? '0'+minutes : minutes} :
                                         ${seconds < 10 ? '0'+seconds : seconds}`;
            }

            updateCountdown();
            const countdownInterval = setInterval(updateCountdown, 1000);
        } else {
            console.warn("Element with ID 'countdown' not found. Countdown script will not run.");
        }
    </script>
    @stack('scripts')
</body>
</html>