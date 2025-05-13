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
        }

        .nav-link {
            color: #000 !important;
        }

        .nav-link:hover {
            color: #dc3545 !important;
        }

        footer {
            background-color: #222;
            color: #ccc;
            padding: 2rem 0;
        }

        footer a {
            color: #ccc;
            text-decoration: none;
        }

        footer a:hover {
            color: #fff;
        }
    </style>
</head>
<body>

    <!-- Content yang akan di-extend -->
    @yield('content')

    <!-- Footer -->
    <footer class="mt-5">
        <div class="container text-center">
            <p>&copy; {{ date('Y') }} ReUseMart. All rights reserved.</p>
            <div>
                <a href="#">Privacy Policy</a> | <a href="#">Terms & Conditions</a>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Countdown Script -->
    <script>
        // Countdown logic (default 3 days)
        const countdownEl = document.getElementById('countdown');
        const end = new Date();
        end.setDate(end.getDate() + 3);

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = end - now;

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
        setInterval(updateCountdown, 1000);
    </script>
</body>
</html>
