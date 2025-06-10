<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ReUseMart</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #fff;
            color: #000;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .login-card {
            background-color: #fff;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 420px;
            margin-top : 40px;
        }

        .login-card h3 {
            margin-bottom: 1.5rem;
            font-weight: bold;
            color: #333;
        }

        .form-control {
            border-radius: 8px;
        }

        .btn-login {
            border-radius: 8px;
            background-color: #000;
            color: #fff;
        }

        .btn-login:hover {
            background-color: #333;
        }

        .register-link {
            font-size: 0.9rem;
        }

        video.bg-video {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            z-index: -1;
            object-fit: cover;
        }

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
            position: relative;
            z-index: 10; /* <-- Tambah z-index */
        }

        .navbar {
            background-color: #fff;
            border-bottom: 1px solid #ddd;
            position: relative;
            z-index: 10; /* <-- Tambah z-index */
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
            padding: 2rem 0;
        }
    </style>
</head>
<body>
    <video autoplay muted loop class="bg-video">
        <source src="https://videos.pexels.com/video-files/6994416/6994416-uhd_2560_1440_30fps.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>

    <!-- Hanya bagian ini yang diflex dan di-center -->
    <div class="main-content d-flex align-items-center justify-content-center">
        <div class="login-card">
            <h3 class="text-center">Masuk ke ReUseMart</h3>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="email@gmail.com" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
                </div>
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
                <p class="text-center register-link">Belum punya akun? <a href="{{ route('registerPage') }}">Daftar di sini</a></p>

                <!-- <hr class="my-3" style="border-top: 1px solid #000; width: 80%; margin: 0 auto;"> -->

                <p class="text-center register-link">Lupa Password Anda? <a href="{{ route('changePasswordPage') }}">Pulihkan di sini</a></p>
            </form>
        </div>
    </div>
</body>        
</html>


