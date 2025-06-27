<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ReUseMart - Dashboard Penitip</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        /* CSS Variables for consistent theming */
        :root {
            --primary-color: #f44336; /* Red accent */
            --dark-color: #000;
            --light-bg: #f8f9fa; /* Lighter background for main sections */
            --body-bg: #ffffff; /* White background for body */
            --text-color: #333; /* Darker text for readability */
            --border-color: #eee;
            --card-bg: #fff;
        }

        body {
            font-family: 'Poppins', 'Roboto', sans-serif;
            background-color: var(--body-bg);
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-image: url('data:image/svg+xml;utf8,<svg width="100%" height="100%" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="p" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="1" cy="1" r="0.5" fill="%23f0f0f0"/></pattern></defs><rect width="100%" height="100%" fill="url(%23p)"/></svg>');
            background-size: 20px 20px;
        }

        .topbar {
            background-color: var(--dark-color);
            color: #fff;
            padding: 8px 15px;
            font-size: 0.85rem;
            text-align: center;
        }
        .topbar a {
            color: #fff;
            text-decoration: underline;
            font-weight: 600;
        }

        .navbar {
            background-color: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
        .navbar .navbar-brand {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark-color);
        }
        .navbar .form-control {
            border-radius: 25px;
            padding: 0.75rem 1.25rem;
            border-color: #ddd;
        }
        .navbar .btn-outline-dark {
            border-radius: 25px;
            font-weight: 600;
            padding: 0.5rem 1.2rem;
            transition: all 0.3s ease;
        }
        .navbar .btn-outline-dark:hover {
            background-color: var(--dark-color);
            color: #fff;
        }
        .navbar .fas {
            font-size: 1.25rem;
            margin-right: 15px;
            color: var(--text-color);
            cursor: pointer;
            transition: color 0.3s ease;
        }
        .navbar .fas:hover {
            color: var(--primary-color);
        }

        /* Main content styling */
        .container-main-content {
            background-color: var(--light-bg);
            padding: 2.5rem 2rem;
            border-radius: 15px;
            margin-top: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            flex-grow: 1; /* Allow main content to grow and push footer down */
        }

        /* Card styling */
        .card {
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem; /* Consistent spacing */
            border: 1px solid var(--border-color);
        }

        .card-title {
            color: var(--dark-color);
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .list-group-item {
            border-color: var(--border-color);
            background-color: var(--card-bg);
            color: var(--text-color);
        }

        /* Button styling */
        .btn-outline-secondary {
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: var(--text-color);
            border-color: #ccc;
        }
        .btn-outline-secondary:hover {
            background-color: #e0e0e0;
            border-color: #e0e0e0;
            color: var(--dark-color);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #fff;
            padding: 0.8rem 2rem;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(244, 67, 54, 0.3);
        }
        .btn-primary:hover {
            background-color: #e53935;
            border-color: #e53935;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(244, 67, 54, 0.4);
        }
        
        .footer {
            background-color: var(--dark-color);
            color: #f0f0f0;
            text-align: center;
            padding: 1.5rem;
            margin-top: auto; /* Push footer to bottom */
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        }
        .footer p {
            margin-bottom: 0;
            font-size: 0.9rem;
        }

        /* Responsive adjustments */
        @media (max-width: 767.98px) {
            .navbar .d-flex {
                width: 100%;
                margin-top: 10px;
                margin-right: 0 !important;
                margin-left: 0 !important;
            }
            .navbar .d-flex input {
                width: 100%;
            }
            .navbar div:last-child {
                width: 100%;
                text-align: center;
                margin-top: 10px;
            }
            .navbar .fas {
                margin: 0 10px;
            }
            .container-main-content {
                padding: 1.5rem;
            }
            .card-title {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="topbar">
        Perbanyak Belanja dan Dapatkan Poin Serta Merchandise Menarik! <a href="#" class="text-white text-decoration-underline">Belanja</a>
    </div>

    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">ReUseMart</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <form class="d-flex ms-lg-auto me-lg-3 my-2 my-lg-0">
                    <input class="form-control" type="search" placeholder="Apa yang anda butuhkan?" aria-label="Search">
                </form>
                <div class="d-flex align-items-center">
                    @auth('penitip')
                        <a href="{{ route('penitip.profil') }}" class="text-dark d-flex align-items-center me-3" style="text-decoration: none;">
                            <i class="fas fa-user me-1"></i>
                            <span>{{ auth('penitip')->user()->username }}</span>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-dark">Logout</button>
                        </form>
                    @else
                        <i class="fas fa-user me-3"></i>
                        <i class="fas fa-heart me-3"></i>
                        <i class="fas fa-shopping-cart me-3"></i>
                        <a href="{{ route('loginPage') }}" class="btn btn-outline-dark">Login/Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-4 px-lg-5 container-main-content">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <!-- Back Button -->
                <div class="mb-4">
                    <a href="{{ route('dashboard.penitip') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>

                <h2 class="text-center mb-4 text-dark fw-bold">Profil Anda</h2>

                <!-- Profile Card -->
                <div class="card shadow rounded-4 mb-4">
                    <div class="card-body text-center p-4">
                        <h4 class="card-title mb-4">👤 {{ $user->nama_penitip }}</h4>
                        <p class="lead mb-2"><i class="fas fa-user-tag me-2 text-primary"></i><strong>Username:</strong> {{ $user->username_penitip }}</p>
                        <p class="lead mb-2"><i class="fas fa-envelope me-2 text-primary"></i><strong>Email:</strong> {{ $user->email_penitip }}</p>
                        <p class="lead mb-4"><i class="fas fa-phone-alt me-2 text-primary"></i><strong>Telepon:</strong> {{ $user->no_telp_penitip }}</p>
                        <p class="lead mb-2"><i class="fas fa-wallet me-2 text-primary"></i><strong>Saldo Penitip:</strong> Rp. {{ number_format($user->saldo_penitip, 0, ',', '.') }}</p>
                        <p class="lead mb-4"><i class="fas fa-trophy me-2 text-primary"></i><strong>Poin Penitip:</strong> {{ $user->poin_penitip }}</p>
                        <a href="{{ route('penitip.penarikan') }}" class="btn btn-primary mt-3">Tarik Saldo</a>
                    </div>
                </div>

                <!-- Transaction History -->
                @if (session('guard') == 'penitip')
                    <div class="card shadow rounded-4 mb-4">
                        <div class="card-body p-4">
                            <h5 class="card-title text-center mb-4">📜 Riwayat Transaksi Penitipan</h5>
                            @if ($riwayatTransaksi->isEmpty())
                                <p class="text-center text-muted">Belum ada transaksi penitipan.</p>
                            @else
                                <ul class="list-group list-group-flush rounded-3">
                                    @foreach ($riwayatTransaksi as $transaksi)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>Tanggal:</strong> {{ optional($transaksi->tanggal_masuk)->format('d M Y') ?? '-' }} <br>
                                                <strong>Pesan:</strong> {{ $transaksi->pesan ?? '-' }}
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 ReUseMart. All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>