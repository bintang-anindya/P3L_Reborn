<!-- register.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ReUseMart</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            overflow: auto;
        }

        video.bg-video {
            position: fixed;
            top: 0;
            left: 0;
            min-width: 100%;
            min-height: 100%;
            object-fit: cover;
            z-index: 0;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.55);
            z-index: 1;
        }

        .register-container {
            z-index: 2;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            min-height: 100vh;
        }

        .register-card {
            background-color: rgba(255, 255, 255, 0.97);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
            animation: fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h3 {
            font-weight: 700;
            color: #333;
        }

        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid #ccc;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #0072ff;
            box-shadow: 0 0 0 0.2rem rgba(0,114,255,0.25);
        }

        .btn-register {
            border-radius: 10px;
            background: linear-gradient(to right, #00c6ff, #0072ff);
            color: white;
            font-weight: bold;
            padding: 0.75rem;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-register:hover {
            background: linear-gradient(to right, #0072ff, #00c6ff);
        }

        .login-link {
            text-align: center;
            font-size: 0.9rem;
        }

        textarea.form-control {
            resize: none;
        }
    </style>
</head>
<body>
    <video autoplay muted loop class="bg-video">
        <source src="{{ asset('assets/videos/5585939-hd_1920_1080_25fps.mp4') }}" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>
    <div class="overlay"></div>

    <div class="register-container">
        <div class="register-card">
            <h3 class="text-center mb-4">Daftar ke ReUseMart</h3>

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Nomor Telepon</label>
                    <input type="tel" class="form-control" id="phone" name="phone" minlength="10" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="2" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="role" class="form-label">Daftar sebagai</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="">-- Pilih Peran --</option>
                        <option value="pembeli">Pembeli</option>
                        <option value="organisasi">Organisasi</option>
                    </select>
                </div>
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-register">Daftar</button>
                </div>
                <p class="login-link">Sudah punya akun? <a href="{{ route('loginPage') }}">Login di sini</a></p>
            </form>
        </div>
    </div>
</body>
</html>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

