<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ReUseMart - Dashboard Penitip</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
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
        }
        .navbar {
            background-color: #fff;
            border-bottom: 1px solid #ddd;
        }
        .navbar .nav-link {
            color: #000;
            font-weight: 500;
        }
        .navbar .nav-link:hover {
            color: #f44336;
        }
        .sidebar {
            border-right: 1px solid #ddd;
            padding: 1rem;
        }
        .sidebar a {
            display: block;
            padding: 8px 0;
            color: #000;
            text-decoration: none;
        }
        .sidebar a:hover {
            color: #f44336;
        }
        .footer {
            background-color: #111;
            color: #fff;
            text-align: center;
            padding: 1rem;
            position: fixed;
            bottom: 0;
            width: 100%;
            z-index: 100;
        }
    </style>
</head>
<body>
    <div class="topbar text-mid">
        Perbanyak Belanja dan Dapatkan Poin Serta Merchandise Menarik!
        <a href="#" class="text-white text-decoration-underline">Belanja</a>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">ReUseMart</a>
            <div class="search-box d-flex ms-auto me-3">
                <div class="input-group">
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari barang...">
                </div>
            </div>
            <div class="d-flex align-items-center gap-3">
                @auth('penitip')
                    <a href="{{ route('penitip.profil') }}" class="text-dark d-flex align-items-center">
                        <i class="fas fa-user me-1"></i>
                        <span>{{ auth('penitip')->user()->username }}</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-dark btn-sm">Logout</button>
                    </form>
                @else
                    <a href="{{ route('loginPage') }}" class="btn btn-outline-dark btn-sm">Login/Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <aside class="col-md-2 sidebar">
                <a href="#">Fashion Wanita</a>
                <a href="#">Fashion Pria</a>
                <a href="#">Elektronik</a>
                <a href="#">Gaya Hidup dan Perabot</a>
                <a href="#">Olahraga</a>
                <a href="#">Keperluan Bayi</a>
                <a href="#">Hewan Peliharaan</a>
                <a href="#">Kecantikan</a>
            </aside>
            <main class="col-md-10">
                <section class="mt-5">
                    <h5 class="text-primary">Barang yang Anda Titipkan</h5>
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
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($barangTitipan as $barang)
                                            <tr>
                                                <td>{{ $barang->nama_barang }}</td>
                                                <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                                                <td>Rp {{ number_format($barang->harga_barang, 0, ',', '.') }}</td>
                                                <td>{{ ucfirst($barang->status_barang) }}</td>
                                                <td>
                                                    {{ optional(optional($barang->penitipan)->tanggal_masuk)->format('d M Y') ?? '-' }}
                                                </td>
                                                <td>
                                                    {{ optional(optional($barang->penitipan)->tenggat_waktu)->format('d M Y') ?? '-' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </section>
            </main>
        </div>
    </div>

    <footer class="footer mt-auto">
        <p>&copy; 2025 ReUseMart. All Rights Reserved.</p>
    </footer>
</body>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const clearBtn = document.getElementById('clearSearch');
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

            // Optional: show a message if no matches
            let noResultRow = document.getElementById('noResultRow');
            if (!hasMatch) {
                if (!noResultRow) {
                    noResultRow = document.createElement('tr');
                    noResultRow.id = 'noResultRow';
                    noResultRow.innerHTML = `<td colspan="6" class="text-center text-muted">Tidak ada barang yang cocok.</td>`;
                    document.querySelector('tbody').appendChild(noResultRow);
                } else {
                    noResultRow.style.display = '';
                }
            } else if (noResultRow) {
                noResultRow.style.display = 'none';
            }
        });

        clearBtn.addEventListener('click', function () {
            searchInput.value = '';
            searchInput.dispatchEvent(new Event('input'));
        });
    });
</script>

</html>