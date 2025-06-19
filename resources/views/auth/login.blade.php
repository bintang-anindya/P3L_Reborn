<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - ReUseMart</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> <style>
        :root {
            --primary-dark: #1a1a1a;
            --secondary-dark: #333333;
            --light-text: #f0f0f0;
            --card-bg: #ffffff;
            --border-color: #e0e0e0;
            --red-alert: #dc3545;
            --green-success: #28a745;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5; /* A light background as a fallback */
            color: var(--primary-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center; /* Center content vertically */
            align-items: center; /* Center content horizontally */
            position: relative; /* Needed for video overlay */
            overflow: hidden; /* Hide potential video scrollbars */
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
            z-index: -2; /* Below the overlay */
            object-fit: cover;
            filter: grayscale(80%) brightness(50%); /* Darken and desaturate video */
        }

        /* Video overlay */
        .video-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4); /* Dark semi-transparent overlay */
            z-index: -1; /* Above video, below content */
        }

        .main-content {
            flex: 1; /* Allows it to take available space */
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
            position: relative; /* Ensure it stays above the video */
            z-index: 1;
        }

        .login-card {
            background-color: var(--card-bg);
            border-radius: 20px; /* More rounded corners */
            padding: 3rem; /* Increased padding */
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15); /* Stronger, softer shadow */
            width: 100%;
            max-width: 450px; /* Slightly wider card */
            transform: translateY(0); /* Ensure no initial transform */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative; /* Needed for absolute positioning of back button */
        }

        .login-card:hover {
            transform: translateY(-5px); /* Subtle lift effect */
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
        }

        .login-card h3 {
            margin-bottom: 2rem; /* More space below heading */
            font-weight: 700; /* Bolder heading */
            color: var(--primary-dark);
            font-size: 1.8rem;
        }

        .form-label {
            font-weight: 500;
            color: var(--secondary-dark);
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 10px; /* More rounded input fields */
            padding: 0.75rem 1.25rem;
            border: 1px solid var(--border-color);
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-dark);
            box-shadow: 0 0 0 0.25rem rgba(0, 0, 0, 0.1); /* Subtle focus glow */
            outline: none;
        }

        .btn-primary {
            border-radius: 10px;
            background: linear-gradient(to right, #000000, #434343); /* Gradient black */
            color: #fff;
            padding: 0.8rem 1.5rem;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #434343, #000000); /* Invert gradient on hover */
            transform: translateY(-2px); /* Slight lift */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .register-link {
            font-size: 0.95rem;
            color: var(--secondary-dark);
        }

        .register-link a {
            color: var(--primary-dark);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .register-link a:hover {
            color: #f44336; /* Using the existing red accent color */
            text-decoration: underline;
        }

        .alert {
            border-radius: 10px;
            padding: 0.75rem 1.25rem;
            margin-bottom: 1rem;
            font-size: 0.95rem;
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
        }
        .alert li {
            list-style-type: disc;
        }

        /* Remove any topbar/navbar styles that were previously present but not needed for this single page context */
        .topbar, .navbar {
            display: none; /* Hide if this is a standalone login page */
        }

        /* New style for the back button */
        .btn-back-to-dashboard {
            position: absolute;
            top: 20px; /* Adjust as needed */
            left: 20px; /* Adjust as needed */
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white */
            border: 1px solid var(--border-color);
            border-radius: 50%; /* Make it round */
            width: 40px; /* Set a fixed width */
            height: 40px; /* Set a fixed height */
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: var(--primary-dark);
            font-size: 1.2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .btn-back-to-dashboard:hover {
            background-color: var(--primary-dark);
            color: #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <video autoplay muted loop class="bg-video">
        <source src="https://videos.pexels.com/video-files/6994416/6994416-uhd_2560_1440_30fps.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>
    <div class="video-overlay"></div> 
    
    <div class="main-content">
        <div class="login-card">
            <a href="{{ route('home') }}" class="btn-back-to-dashboard" title="Kembali ke Dashboard">
                <i class="fas fa-arrow-left"></i>
            </a>
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
                <div class="mb-4"> 
                    <label for="email" class="form-label">Alamat Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="contoh@email.com" required autocomplete="email">
                </div>
                <div class="mb-4"> 
                    <label for="password" class="form-label">Kata Sandi</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required autocomplete="current-password">
                </div>
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
                <p class="text-center register-link mb-2">Belum punya akun? <a href="{{ route('registerPage') }}">Daftar di sini</a></p>
                <p class="text-center register-link">Lupa Kata Sandi Anda? <a href="{{ route('changePasswordPage') }}">Pulihkan di sini</a></p>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>