<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReUseMart</title>
    {{-- Ini adalah link Bootstrap dan Font Awesome yang Anda gunakan --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    {{-- Ini adalah link Tailwind CSS yang Anda gunakan, seharusnya di sini jika di `@apply` di style --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', 'Roboto', sans-serif; /* Menggunakan font dari Poppins/Roboto */
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
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
            text-align: center;
            padding: 1rem;
            margin-top: auto;
            width: 100%;
        }

        footer a {
            color: #ccc;
            text-decoration: none;
        }

        footer a:hover {
            color: #fff;
        }

        /* Styles for custom modals (copied from your original) */
        .modal-overlay {
            position: fixed; /* Explicitly fixed */
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background-color: rgba(0, 0, 0, 0.5); /* bg-black bg-opacity-50 */
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999; /* Ensure it's on top of other content */
            transition: opacity 300ms ease-in-out; /* transition-opacity duration-300 ease-in-out */
        }
        .modal-container {
            background-color: white; /* bg-white */
            border-radius: 0.75rem; /* rounded-xl */
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1); /* shadow-xl */
            max-width: 24rem; /* max-w-sm */
            width: 100%;
            margin: 0 1rem; /* mx-4 */
            transform: scale(1); /* Ensure no conflicting transform */
            transition: all 300ms ease-in-out; /* transition-all duration-300 ease-in-out */
        }
        .modal-header {
            padding: 1rem 1.5rem; /* px-6 py-4 */
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e5e7eb; /* border-b border-gray-200 */
        }
        .modal-body {
            padding: 1rem 1.5rem; /* px-6 py-4 */
            color: #4b5563; /* text-gray-700 */
        }
        .modal-footer {
            padding: 1rem 1.5rem; /* px-6 py-4 */
            display: flex;
            justify-content: flex-end;
            align-items: center;
            border-top: 1px solid #e5e7eb; /* border-t border-gray-200 */
            background-color: #f9fafb; /* bg-gray-50 */
            border-bottom-left-radius: 0.75rem; /* rounded-b-xl */
            border-bottom-right-radius: 0.75rem;
        }

        /* Utility classes for modal visibility */
        .modal-overlay.hidden {
            display: none;
        }
        .modal-overlay.opacity-0 {
            opacity: 0;
        }
        .modal-overlay.pointer-events-none {
            pointer-events: none;
        }
    </style>
    @stack('styles')
</head>
<body>

    {{-- Ini adalah div yang akan membungkus konten utama --}}
    <div class="flex-grow-1">
        @yield('content')
    </div>

    {{-- Footer --}}
    <footer class="mt-5">
        <div class="container text-center">
            <p>&copy; {{ date('Y') }} ReUseMart. All rights reserved.</p>
            <div>
                <a href="#">Privacy Policy</a> | <a href="#">Terms & Conditions</a>
            </div>
        </div>
    </footer>

    {{-- JavaScript utama --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Contoh skrip countdown (tetap di sini karena ini bagian dari layout app)
        const countdownEl = document.getElementById('countdown');

        if (countdownEl) {
            const end = new Date();
            end.setDate(end.getDate() + 3);

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

    {{-- STACK UNTUK SCRIPT TAMBAHAN DARI CHILD VIEWS --}}
    @stack('scripts')

    {{-- STACK UNTUK MODAL DARI CHILD VIEWS (PENTING!) --}}
    {{-- Modals diletakkan di sini agar berada di level root body dan fixed positioning bekerja dengan benar --}}
    @stack('modals')

</body>
</html>