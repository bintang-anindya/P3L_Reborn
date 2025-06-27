<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ReUseMart - Dashboard Penitip</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
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

        /* Ensure content pushes footer down */
        .container-fluid {
            flex-grow: 1;
        }

        .sidebar {
            background-color: var(--card-bg);
            border-right: 1px solid var(--border-color);
            padding: 1.5rem;
            margin-top: 25px; /* Align with hero section */
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            height: fit-content; /* Adjust height to content */
        }
        .sidebar a {
            display: block;
            padding: 10px 0;
            color: var(--text-color);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .sidebar a:hover {
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .flash-sale {
            background-color: var(--light-bg);
            padding: 2.5rem 2rem;
            border-radius: 15px;
            margin-top: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        .flash-sale h2 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }
        .flash-sale h5 {
            color: var(--primary-color);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 1rem;
        }

        .product-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.07);
            height: 100%; /* Ensure cards in a row have same height */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
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

        /* Specific styles for the dashboard table */
        .card {
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-top: 25px;
        }

        .table thead th {
            background-color: var(--light-bg);
            color: var(--dark-color);
            font-weight: 600;
        }

        .table tbody tr:hover {
            background-color: #f5f5f5;
        }

        .table .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
            border-radius: 20px;
        }

        .badge.bg-secondary {
            background-color: #6c757d !important;
            color: #fff;
            padding: 0.4em 0.8em;
            border-radius: 0.25rem;
        }

        .expired-badge {
            background-color: var(--primary-color);
            color: #fff;
            padding: 0.4em 0.8em;
            border-radius: 0.25rem;
            font-weight: 600;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                border-right: none;
                border-bottom: 1px solid var(--border-color);
                margin-bottom: 25px;
                padding-bottom: 0;
            }
            .sidebar a {
                display: inline-block;
                margin-right: 15px;
            }
            .navbar .form-control {
                width: auto;
                flex-grow: 1;
            }
        }

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
            .sidebar {
                padding: 1rem;
                text-align: center;
            }
            .sidebar a {
                margin-right: 10px;
                font-size: 0.9rem;
                padding: 8px 0;
            }
            .flash-sale h2 {
                font-size: 2rem;
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
            <a class="navbar-brand" href="#">ReUseMart</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <form class="d-flex ms-lg-auto me-lg-3 my-2 my-lg-0">
                    <input class="form-control" type="search" id="searchInput" placeholder="Apa yang anda butuhkan?" aria-label="Search">
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

    <div class="container-fluid py-4 px-lg-5">
        <div class="row">
            <aside class="col-md-3 col-lg-2">
                <div class="sidebar">
                    <h6 class="fw-bold mb-3 text-uppercase text-dark">Kategori</h6>
                    <a href="#">Fashion Wanita</a>
                    <a href="#">Fashion Pria</a>
                    <a href="#">Elektronik</a>
                    <a href="#">Gaya Hidup dan Perabot</a>
                    <a href="#">Olahraga</a>
                    <a href="#">Keperluan Bayi</a>
                    <a href="#">Hewan Peliharaan</a>
                    <a href="#">Kecantikan</a>
                </div>
            </aside>
            <main class="col-md-9 col-lg-10">
                <section class="flash-sale">
                    <h5 class="text-danger">Barang yang Anda Titipkan</h5>
                    <h2 class="fw-bold">Daftar Produk</h2>
                    @if (isset($barangTitipan) && !$barangTitipan->isEmpty())
                    <div class="card shadow rounded-4 mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-center">📦 Barang Titipan Anda</h5>
                            <div class="table-responsive">
                                <table class="table table-striped align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th>Kategori</th>
                                            <th>Harga</th>
                                            <th>Status</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Tenggat Waktu</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($barangTitipan as $barang)
                                        @php
                                            $tenggatWaktu = optional($barang->penitipan)->tenggat_waktu;
                                            $isLewatTenggat = $tenggatWaktu && $tenggatWaktu->lt(now());
                                            $statusPerpanjangan = $barang->penitipan->status_perpanjangan ?? false;
                                        @endphp
                                        <tr class="{{ $isLewatTenggat ? 'table-warning' : '' }}">
                                            <td>{{ $barang->nama_barang }}</td>
                                            <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                                            <td>Rp {{ number_format($barang->harga_barang, 0, ',', '.') }}</td>
                                            <td>
                                                @if($barang->status_barang === 'diambil penitip')
                                                    <span class="badge bg-secondary">Diambil</span>
                                                @elseif($isLewatTenggat)
                                                    <span class="expired-badge">Kadaluarsa</span>
                                                @else
                                                    {{ ucfirst($barang->status_barang) }}
                                                @endif
                                            </td>
                                            <td>
                                                {{ optional(optional($barang->penitipan)->tanggal_masuk)->format('d M Y') ?? '-' }}
                                            </td>
                                            <td>
                                                {{ optional($tenggatWaktu)->format('d M Y') ?? '-' }}
                                            </td>
                                            <td>
                                                @if($isLewatTenggat && $barang->status_barang !== 'diambil penitip')
                                                    <div class="action-buttons d-grid gap-2">
                                                        <form action="{{ route('barang.ambil', $barang->id_barang) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-primary btn-sm w-100"
                                                                onclick="return confirm('Anda yakin ingin mengambil barang?')">
                                                                Ambil
                                                            </button>
                                                        </form>
                                                        @if(!$barang->status_perpanjangan)
                                                            <form action="{{ route('barang.perpanjang', $barang->id_barang) }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="hari_perpanjangan" value="30">
                                                                <button type="submit" class="btn btn-warning btn-sm w-100"
                                                                    onclick="return confirm('Anda yakin ingin memperpanjang 30 hari dari hari ini?')">
                                                                    Perpanjang
                                                                </button>
                                                            </form>
                                                        @else
                                                            <button class="btn btn-secondary btn-sm w-100" disabled>Sudah Diperpanjang</button>
                                                        @endif
                                                    </div>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @else
                        <p class="text-muted text-center mt-5">Tidak ada barang titipan saat ini.</p>
                    @endif
                </section>
            </main>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 ReUseMart. All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const rows = document.querySelectorAll('tbody tr');

            searchInput.addEventListener('input', function () {
                const searchValue = this.value.toLowerCase();
                let hasMatch = false;

                rows.forEach(row => {
                    const rowText = row.textContent.toLowerCase();
                    const match = rowText.includes(searchValue);
                    row.style.display = match ? '' : 'none';
                    if (match) hasMatch = true;
                });

                let noResultRow = document.getElementById('noResultRow');
                if (!hasMatch) {
                    if (!noResultRow) {
                        noResultRow = document.createElement('tr');
                        noResultRow.id = 'noResultRow';
                        noResultRow.innerHTML = `<td colspan="7" class="text-center text-muted">Tidak ada barang yang cocok.</td>`;
                        document.querySelector('tbody').appendChild(noResultRow);
                    } else {
                        noResultRow.style.display = '';
                    }
                } else if (noResultRow) {
                    noResultRow.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>