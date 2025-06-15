<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password - ReUseMart</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to right, #f8f8f8, #e6e6e6);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden; /* Prevent horizontal scroll */
        }

        .topbar {
            background-color: #000;
            color: #fff;
            padding: 8px 20px; /* Increased padding for better visual */
            font-size: 0.9rem; /* Slightly larger font */
            position: relative;
            z-index: 10;
            text-align: center; /* Centered text */
        }

        .navbar {
            background-color: #fff;
            border-bottom: 1px solid #ddd;
            position: relative;
            z-index: 10;
            padding: 15px 0; /* Added vertical padding */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); /* Subtle shadow for depth */
        }

        .navbar .nav-link {
            color: #000;
            font-weight: 500;
            transition: color 0.3s ease; /* Smooth transition on hover */
        }

        .navbar .nav-link:hover {
            color: #f44336;
        }

        .navbar-brand {
            font-size: 1.75rem; /* Larger brand name */
            font-weight: 700 !important; /* Ensure bold is applied */
            color: #333 !important; /* Darker brand color */
        }

        .form-control.me-2 {
            border-radius: 25px; /* Pill-shaped search bar */
            padding-left: 1.5rem;
            padding-right: 1.5rem;
            border: 1px solid #ccc;
        }

        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 1rem; /* Increased padding for more breathing room */
        }

        .change-password-card {
            background-color: #fff;
            border-radius: 16px;
            padding: 2.5rem; /* Increased padding inside the card */
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15); /* More pronounced shadow */
            width: 100%;
            max-width: 450px; /* Slightly wider card */
            border: 1px solid #eee; /* Light border */
        }

        .change-password-card h3 {
            margin-bottom: 2rem; /* More space below heading */
            font-weight: 700; /* Bolder heading */
            color: #222; /* Darker heading color */
        }

        .form-label {
            font-weight: 500;
            color: #555;
            margin-bottom: .5rem;
        }

        .form-control, .form-select {
            border-radius: 10px; /* Slightly more rounded corners */
            padding: 0.75rem 1rem; /* Better padding within inputs */
            border: 1px solid #ddd;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05); /* Inner shadow for depth */
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #f44336; /* Highlight on focus */
            box-shadow: 0 0 0 0.25rem rgba(244, 67, 54, 0.25); /* Glow effect on focus */
            outline: none;
        }

        .btn-submit {
            border-radius: 10px;
            background-color: #f44336; /* Red primary button */
            color: #fff;
            padding: 0.85rem 1.5rem; /* Generous button padding */
            font-size: 1.1rem; /* Larger font size for button */
            font-weight: 700;
            border: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-submit:hover {
            background-color: #e63946; /* Darker red on hover */
            transform: translateY(-2px); /* Slight lift effect */
        }

        .register-link {
            font-size: 0.95rem; /* Slightly larger text */
            color: #666;
            margin-top: 1.5rem; /* More space above the link */
        }

        .register-link a {
            color: #f44336; /* Red link color */
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .register-link a:hover {
            color: #e63946;
            text-decoration: underline;
        }

        video.bg-video {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            z-index: -1;
            object-fit: cover;
            filter: brightness(0.7); /* Slightly dim the video for better text readability */
        }

        .alert {
            border-radius: 8px;
            font-size: 0.95rem;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem; /* More space below alerts */
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }
    </style>
</head>
<body>
    <video autoplay muted loop class="bg-video">
        <source src="https://videos.pexels.com/video-files/6994416/6994416-uhd_2560_1440_30fps.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>

    <div class="topbar text-mid">
        Perbanyak Belanja dan Dapatkan Poin Serta Merchandise Menarik! 
        <a href="#" class="text-white text-decoration-underline">Belanja</a>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">ReUseMart</a>
            <form class="d-flex ms-auto me-3">
                <input class="form-control me-2" type="search" placeholder="Apa yang anda butuhkan?">
            </form>
        </div>
    </nav>

    <div class="main-content">
        <div class="change-password-card">
            <h3 class="text-center">Ganti Password</h3>

            @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3"> {{-- Added padding-left for list --}}
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('changePasswordSubmit') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="email@gmail.com" required>
                </div>
                <div class="mb-4">
                    <label for="role" class="form-label">Pilih Role Anda</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="owner">Owner</option>
                        <option value="admin">Admin</option>
                        <option value="cs">CS</option>
                        <option value="gudang">Gudang</option>
                        <option value="pembeli">Pembeli</option>
                    </select>
                </div>
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-submit">Lanjut Ganti Password</button>
                </div>
                <p class="text-center register-link">
                    Ingat password Anda? <a href="{{ route('loginPage') }}">Login di sini</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>