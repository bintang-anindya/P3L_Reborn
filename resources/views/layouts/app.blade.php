<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReUseMart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
            /* Flexbox untuk sticky footer */
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Pastikan body setidaknya setinggi viewport */
            margin: 0; /* Hapus margin default browser */
        }

        .nav-link {
            color: #000 !important;
        }

        .nav-link:hover {
            color: #dc3545 !important;
        }

        /* Hapus properti positioning dari footer */
        footer {
            background-color: #222;
            color: #ccc;
            text-align: center;
            padding: 1rem;
            /* Flexbox untuk mendorong footer ke bawah */
            margin-top: auto; /* Ini akan mendorong footer ke bagian bawah */
            width: 100%; /* Pastikan footer mengambil seluruh lebar */
            /* Z-index tidak lagi diperlukan karena tidak fixed */
            /* z-index: 100; */
        }

        footer a {
            color: #ccc;
            text-decoration: none;
        }

        footer a:hover {
            color: #fff;
        }

        /* Menambahkan margin-bottom pada konten agar tidak tumpang tindih dengan footer */
        /* ini jika Anda ingin memastikan ada ruang di atas footer */
        /* .content-wrapper {
            padding-bottom: 70px;
        } */
    </style>
</head>
<body>

    <div class="flex-grow-1">
        @yield('content')
    </div>

    <footer class="mt-5">
        <div class="container text-center">
            <p>&copy; {{ date('Y') }} ReUseMart. All rights reserved.</p>
            <div>
                <a href="#">Privacy Policy</a> | <a href="#">Terms & Conditions</a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Pastikan elemen 'countdown' ada di halaman yang meng-extend layout ini
        // Jika tidak ada, script ini akan error atau tidak berfungsi.
        // Anda mungkin ingin menambahkan pengecekan sebelum mengakses countdownEl.
        const countdownEl = document.getElementById('countdown');

        // Hanya jalankan logic countdown jika elemen ditemukan
        if (countdownEl) {
            const end = new Date();
            end.setDate(end.getDate() + 3); // Default 3 hari dari sekarang

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = end - now;

                if (distance < 0) {
                    countdownEl.innerHTML = "EXPIRED";
                    clearInterval(countdownInterval); // Hentikan interval
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
            const countdownInterval = setInterval(updateCountdown, 1000); // Simpan ID interval
        } else {
            console.warn("Element with ID 'countdown' not found. Countdown script will not run.");
        }
    </script>
    @stack('scripts') 
</body>
</html>