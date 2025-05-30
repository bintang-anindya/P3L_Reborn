<!-- resources/views/changePassword.blade.php -->
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
        }

        .topbar {
            background-color: #000;
            color: #fff;
            padding: 5px 15px;
            font-size: 0.875rem;
            position: relative;
            z-index: 10;
        }

        .navbar {
            background-color: #fff;
            border-bottom: 1px solid #ddd;
            position: relative;
            z-index: 10;
        }

        .navbar .nav-link {
            color: #000;
            font-weight: 500;
        }

        .navbar .nav-link:hover {
            color: #f44336;
        }

        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .change-password-card {
            background-color: #fff;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 420px;
        }

        .change-password-card h3 {
            margin-bottom: 1.5rem;
            font-weight: bold;
            color: #333;
        }

        .form-control, .form-select {
            border-radius: 8px;
        }

        .btn-submit {
            border-radius: 8px;
            background-color: #000;
            color: #fff;
        }

        .btn-submit:hover {
            background-color: #333;
        }

        .register-link {
            font-size: 0.9rem;
        }

        video.bg-video {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            z-index: -1;
            object-fit: cover;
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

            <!-- Flash message -->
            @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <!-- Error messages -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
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
