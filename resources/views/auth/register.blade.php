<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - ReUseMart</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #0072ff;
            --secondary-blue: #00c6ff;
            --dark-text: #2c3e50; /* Darker text for better contrast */
            --light-gray: #e9ecef;
            --card-bg: #ffffff;
            --border-color: #ced4da;
            --red-alert: #dc3545;
            --green-success: #28a745;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-gray);
            color: var(--dark-text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
            margin-bottom : 20px;
        }

        video.bg-video {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: 0;
            object-fit: cover;
            filter: brightness(60%) contrast(110%); /* Adjusted for a richer background */
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4); /* Slightly less dark */
            z-index: 1;
        }

        .register-container {
            z-index: 2;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem; /* Adjusted padding */
            min-height: 100vh;
            width: 100%; /* Ensure container takes full width */
        }

        .register-card {
            background-color: var(--card-bg);
            border-radius: 20px; /* More rounded corners */
            padding: 2.5rem; /* Increased padding */
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2); /* Stronger, softer shadow */
            width: 100%;
            max-width: 550px; /* Slightly wider card */
            animation: fadeIn 0.8s ease-out forwards; /* Using forwards to keep final state */
            position: relative; /* For back button positioning */
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h3 {
            font-weight: 700;
            color: var(--dark-text);
            margin-bottom: 2rem; /* More space below heading */
            font-size: 1.8rem;
        }

        .form-label {
            font-weight: 500;
            color: var(--dark-text);
            margin-bottom: 0.4rem; /* Slightly less space */
            font-size: 0.95rem;
        }

        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid var(--border-color);
            padding: 0.75rem 1rem; /* Consistent padding */
            transition: all 0.3s ease;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.06); /* Subtle inner shadow */
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.25rem rgba(0, 114, 255, 0.2); /* Softer focus glow */
            outline: none;
            background-color: #f8fafd; /* Light background on focus */
        }

        .btn-register {
            border-radius: 10px;
            background: linear-gradient(to right, var(--primary-blue), var(--secondary-blue));
            color: white;
            font-weight: 600; /* Medium bold */
            padding: 0.9rem 1.5rem; /* Larger padding */
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 8px 20px rgba(0, 114, 255, 0.3); /* More pronounced shadow */
            font-size: 1.1rem;
        }

        .btn-register:hover {
            background: linear-gradient(to right, var(--secondary-blue), var(--primary-blue)); /* Inverted gradient on hover */
            transform: translateY(-3px); /* Subtle lift */
            box-shadow: 0 12px 25px rgba(0, 114, 255, 0.4);
        }

        .login-link {
            text-align: center;
            font-size: 0.95rem;
            color: #555;
            margin-top: 1.5rem;
        }

        .login-link a {
            color: var(--primary-blue);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            color: #f44336; /* Reusing the red accent for consistency */
            text-decoration: underline;
        }

        textarea.form-control {
            resize: vertical; /* Allow vertical resizing */
            min-height: 80px; /* Minimum height for address */
        }

        .alert {
            border-radius: 10px;
            padding: 0.75rem 1.25rem;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            line-height: 1.4;
        }
        .alert-success {
            background-color: #d4edda;
            color: var(--green-success);
            border-color: #c3e6cb;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: var(--red-alert);
            border-color: #f5c6cb;
        }
        .alert ul {
            margin-bottom: 0;
            padding-left: 20px;
            list-style-type: none; /* Remove default bullet */
        }
        .alert li::before { /* Custom bullet point */
            content: "\2022"; /* Unicode for bullet */
            color: var(--red-alert);
            font-weight: bold;
            display: inline-block;
            width: 1em;
            margin-left: -1em;
        }

        /* Back button styling */
        .btn-back {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border: 1px solid var(--border-color);
            border-radius: 50%;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark-text);
            font-size: 1.3rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-back:hover {
            background-color: var(--primary-blue);
            color: #fff;
            box-shadow: 0 6px 15px rgba(0, 114, 255, 0.3);
            transform: translateY(-2px);
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
            <a href="{{ route('home') }}" class="btn-back" title="Kembali ke Beranda">
                <i class="fas fa-arrow-left"></i>
            </a>

            <h3 class="text-center">Daftar ke ReUseMart</h3>

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <p class="mb-1 fw-bold">Terjadi Kesalahan:</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Contoh: Budi Santoso" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" placeholder="Contoh: budi_reuse" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Nomor Telepon</label>
                    <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Contoh: 081234567890" minlength="10" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="2" placeholder="Contoh: Jl. Merdeka No. 10, Jakarta Pusat" required>{{ old('alamat') }}</textarea>
                </div>
                <div class="mb-4">
                    <label for="role" class="form-label">Daftar sebagai</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="">-- Pilih Peran --</option>
                        <option value="pembeli" {{ old('role') == 'pembeli' ? 'selected' : '' }}>Pembeli</option>
                        <option value="organisasi" {{ old('role') == 'organisasi' ? 'selected' : '' }}>Organisasi</option>
                    </select>
                </div>
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-register">Daftar</button>
                </div>
                <p class="login-link">Sudah punya akun? <a href="{{ route('loginPage') }}">Login di sini</a></p>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>