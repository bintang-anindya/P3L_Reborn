<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReUseMart - Live Code Pembeli</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #fff;
            color: #000;
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
        .container.mt-4 {
            padding-bottom: 80px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard.pembeli') }}">ReUseMart</a>
            <form class="d-flex ms-auto me-3">
                <input class="form-control me-2" type="search" placeholder="Apa yang anda butuhkan?">
            </form>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('diskusi.index') }}" class="btn btn-outline-dark btn-sm">Diskusi</a>
                <a href="{{ route('alamat.manager') }}" class="btn btn-outline-dark btn-sm">Kelola Alamat</a>
                <a href="{{ route('dashboard.pembeli') }}" class="text-dark">
                    <i class="fas fa-user-circle active"></i>
                </a>
                <a href="#" class="text-dark"><i class="fas fa-heart"></i></a>
                <a href="{{ route('keranjang.index') }}" class="text-dark">
                    <i class="fas fa-shopping-cart"></i>
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card shadow-sm rounded">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">Pembatalan Transaksi Valid</h4>
            </div>
            <div class="card-body p-0">
                @if($Transaksis->count() > 0)
                    <table class="table table-striped mb-0">
                        <thead class="table-success">
                            <tr>
                                <th>NO</th>
                                <th>Nomor Transaksi</th>
                                <th>Tanggal Transaksi</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                                <th>Batal</th>     
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($Transaksis as $index => $transaksi)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ ucfirst($transaksi->nomor_transaksi) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d M Y') }}</td>
                                    <td>Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                                    <td>{{ ucfirst($transaksi->status_transaksi) }}</td>
                                    <td>
                                        @if($transaksi->status_transaksi === 'disiapkan')
                                            <button 
                                                type="button" 
                                                class="btn btn-danger btn-sm btnHapus" 
                                                data-id="{{ $transaksi->id_transaksi }}" 
                                                data-total="{{ $transaksi->total_harga }}">
                                                Batalkan
                                            </button>
                                        @endif
                                    </td>                             
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info m-3">
                        Belum ada transaksi yang dibatalkan.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="footer">
        &copy; 2025 ReUseMart. All rights reserved.
    </div>

    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formDelete" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Batal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div id="konfirmasiTeks" style="line-height: 1.6; font-size: 1rem;">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-danger">Ya, Batalkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const confirmDeleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));

        document.querySelectorAll('.btnHapus').forEach(btn => {
            btn.addEventListener('click', function () {
                let id_transaksi = this.dataset.id;
                let total_harga = parseInt(this.dataset.total);

                let formatRupiah = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(total_harga);

                let poin = Math.floor(total_harga / 10000);

                let form = document.getElementById('formDelete');
                form.action = '/transaksi/cancelByPembeli/' + id_transaksi;

                document.getElementById('konfirmasiTeks').innerHTML = `
                    <p>Apakah Anda yakin ingin <strong>membatalkan transaksi</strong> berikut?</p>
                    <ul class="mb-2">
                        <li>Total Transaksi: <strong>${formatRupiah}</strong></li>
                        <li>Poin Reward: <strong>${poin} poin</strong></li>
                    </ul>
                    <p class="text-danger">Tindakan ini tidak dapat dibatalkan.</p>
                `;

                confirmDeleteModal.show();
            });
        });
    });
    </script>

</body>
</html>
