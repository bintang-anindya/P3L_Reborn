<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ReUseMart - E-Commerce</title>
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
            padding-bottom: 120px;
        }
        .navbar .fa-shopping-cart.active {
            border: 2px solid #000;
            border-radius: 5px;
            padding: 4px;
        }
        .product-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }
    </style>
</head>
<body>

    @php
    $totalHarga = 0;
    foreach ($items as $item) {
        $totalHarga += $item->barang->harga_barang;
    }

    // Poin tukar dan diskon dihitung di backend, tetap seperti semula
    $poinTukar = session('poin_tukar', 0);
    if ($poinTukar > $pembeli->poin_pembeli) {
        $poinTukar = 0;
    }

    $faktorDiskon = ($totalHarga > 500000) ? 1 : 1;
    $nilaiDiskon = $poinTukar * 100 * $faktorDiskon;
    // Ongkir default di backend, tapi nanti di JS akan diupdate otomatis
    $ongkirDefault = ($totalHarga >= 1500000) ? 0 : 100000;
    $nilaiDiskon = min($nilaiDiskon, $totalHarga + $ongkirDefault);
    $totalPembayaranDefault = $totalHarga + $ongkirDefault - $nilaiDiskon;
    if ($totalPembayaranDefault < 0) {
        $totalPembayaranDefault = 0;
        $poinTukar = 0;
        session()->forget('poin_tukar');
    }
    $maxPoinTukar = floor(($totalHarga + $ongkirDefault) / 100 / $faktorDiskon);
    if ($maxPoinTukar > $pembeli->poin_pembeli) {
        $maxPoinTukar = $pembeli->poin_pembeli;
    }
    @endphp

    <!-- Topbar -->
    <div class="topbar text-mid">
        Perbanyak Belanja dan Dapatkan Poin Serta Merchandise Menarik!
        <a href="#" class="text-white text-decoration-underline">Belanja</a>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">ReUseMart</a>
            <form class="d-flex ms-auto me-3">
                <input class="form-control me-2" type="search" placeholder="Apa yang anda butuhkan?" />
            </form>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('diskusi.index') }}" class="btn btn-outline-dark btn-sm">Diskusi</a>
                <a href="{{ route('alamat.manager') }}" class="btn btn-outline-dark btn-sm">Kelola Alamat</a>
                <a href="{{ route('profilPembeli') }}" class="me-3"><i class="fas fa-user-circle fa-lg"></i></a>
                <a href="#" class="text-dark"><i class="fas fa-heart"></i></a>
                <a href="{{ route('dashboard.pembeli') }}" class="text-dark"><i class="fas fa-shopping-cart active"></i></a>
            </div>
        </div>
    </nav>

    <!-- Konten -->
    <div class="container mt-4" 
         data-totalharga="{{ $totalHarga }}" 
         data-nilaidiskon="{{ $nilaiDiskon }}"
         data-pointukar="{{ $poinTukar }}"
         data-faktordiskon="{{ $faktorDiskon }}">
        <h2 class= "form-label fw-bold">Keranjang Belanja</h2>
        @if($items->isEmpty())
            <p>Belum ada barang yang Anda pilih. <a href="{{ route('dashboard.pembeli') }}" class="btn btn-primary btn-sm ms-2">Belanja Sekarang</a></p>
        @else
            <div class="row">
                @foreach($items as $item)
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <img src="{{ asset('storage/' . $item->barang->gambar_barang) }}" class="product-img" alt="{{ $item->barang->nama_barang }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->barang->nama_barang }}</h5>
                            <p class="card-text text-danger fw-bold">
                                Rp {{ number_format($item->barang->harga_barang, 0, ',', '.') }}
                            </p>
                            <button type="button" class="btn btn-danger btn-sm btnHapus" data-id="{{ $item->id_barang }}">Hapus</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <form id="checkoutForm" action="{{ route('transaksi.checkout') }}" method="POST" class="mt-4">
                @csrf

                <!-- Alamat -->
                <div class="mb-3">
                    <label for="alamat_pembeli" class="form-label fw-bold">Pilih Alamat Pengiriman:</label>
                    <select name="alamat_pembeli" id="alamat_pembeli" class="form-select" required>
                    @if ($alamatUtama)
                        <option value="{{ $alamatUtama->id_alamat }}">
                        [Utama] {{ $alamatUtama->detail }}
                        </option>
                    @endif
                    @foreach($alamatPembeli as $alamat)
                        @if (!$alamatUtama || $alamat->id_alamat !== $alamatUtama->id_alamat)
                        <option value="{{ $alamat->id_alamat }}">
                            {{ $alamat->detail }}
                        </option>
                        @endif
                    @endforeach
                    </select>
                </div>

                <!-- Metode -->
                <div class="mb-3">
                    <label for="metode_pengiriman" class="form-label fw-bold">Pilih Metode Pengiriman:</label>
                    <select name="metode_pengiriman" id="metode_pengiriman" class="form-select" required>
                        <option value="" disabled selected>-- Pilih Metode Pengiriman --</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Poin Anda:</label>
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <i class="fas fa-coins me-2"></i>
                        <div>
                            <strong id="poinPembeli">{{ $pembeli->poin_pembeli }}</strong> poin tersedia
                        </div>
                    </div>
                </div>

                <!-- Poin Tukar -->
                <div class="mb-3">
                    <label for="poin_tukar" class="form-label fw-bold">Tukar Poin :</label>
                    <input type="number" id="poin_tukar" name="poin_tukar" class="form-control" min="0" max="{{ $maxPoinTukar }}" value="0" step="1" />
                </div>

                <!-- Ringkasan -->
                <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-3">
                    <div>
                    <h5 class="mb-1">Subtotal: <span class="text-danger" id="subtotalDisplay">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span></h5>
                    <h5 class="mb-1">Ongkir: <span class="text-danger" id="ongkirDisplay">Rp {{ number_format($ongkirDefault, 0, ',', '.') }}</span></h5>
                    <h5 class="mb-1">Diskon dari Poin: <span class="text-success" id="diskonDisplay">- Rp {{ number_format($nilaiDiskon, 0, ',', '.') }}</span></h5>
                    <h4 class="mb-0">Total: <span class="text-danger fw-bold" id="totalDisplay">Rp {{ number_format($totalPembayaranDefault, 0, ',', '.') }}</span></h4>
                    </div>
                    <button type="submit" class="btn btn-success">Checkout</button>
                </div>
            </form>
        @endif
    </div>

    <!-- Footer -->
    <footer class="footer mt-auto">
        <p>&copy; 2025 ReUseMart. All Rights Reserved.</p>
    </footer>

    <!-- Modals -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formDelete" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus barang ini dari keranjang?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Informasi -->
    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoModalLabel">Informasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body" id="infoModalBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Inisialisasi modal Bootstrap
        const confirmDeleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        const infoModal = new bootstrap.Modal(document.getElementById('infoModal'));

        // Event listener untuk tombol hapus
        document.querySelectorAll('.btnHapus').forEach(btn => {
            btn.addEventListener('click', function () {
                let idBarang = this.dataset.id;
                let form = document.getElementById('formDelete');
                form.action = '/keranjang/hapus/' + idBarang;
                confirmDeleteModal.show();
            });
        });

        // Jika ada session error_poin_tukar, tampilkan modal info
        @if(session('error_poin_tukar'))
            window.addEventListener('DOMContentLoaded', () => {
                document.getElementById('infoModalBody').textContent = "{{ session('error_poin_tukar') }}";
                infoModal.show();

                const inputPoin = document.getElementById('poin_tukar');
                if (inputPoin) {
                    inputPoin.value = 0;
                }
            });
        @endif
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const alamatSelect = document.getElementById('alamat_pembeli');
            const metodeSelect = document.getElementById('metode_pengiriman');
            const poinTukarInput = document.getElementById('poin_tukar');

            // Mapping alamat id ke detail alamat
            const alamatMap = {
                @if ($alamatUtama)
                    "{{ $alamatUtama->id_alamat }}": `{{ strtolower($alamatUtama->detail) }}`,
                @endif
                @foreach ($alamatPembeli as $alamat)
                    "{{ $alamat->id_alamat }}": `{{ strtolower($alamat->detail) }}`,
                @endforeach
            };

            const subtotalDisplay = document.getElementById('subtotalDisplay');
            const ongkirDisplay = document.getElementById('ongkirDisplay');
            const diskonDisplay = document.getElementById('diskonDisplay');
            const totalDisplay = document.getElementById('totalDisplay');

            const totalHarga = parseInt(document.querySelector('.container.mt-4').dataset.totalharga);
            const faktorDiskon = parseFloat(document.querySelector('.container.mt-4').dataset.faktordiskon);

            function updateMetodePengiriman() {
                const selectedAlamatId = alamatSelect.value;
                const alamatDetail = alamatMap[selectedAlamatId] || "";

                metodeSelect.innerHTML = '<option value="" disabled selected>-- Pilih Metode Pengiriman --</option>';

                if (alamatDetail.includes('yogyakarta')) {
                    const optionKurir = document.createElement('option');
                    optionKurir.value = 'kurir';
                    optionKurir.textContent = 'Kurir';

                    const optionAmbil = document.createElement('option');
                    optionAmbil.value = 'ambil_sendiri';
                    optionAmbil.textContent = 'Ambil Sendiri';

                    metodeSelect.appendChild(optionKurir);
                    metodeSelect.appendChild(optionAmbil);

                    metodeSelect.disabled = false;
                } else if (alamatDetail.trim() !== '') {
                    const optionAmbil = document.createElement('option');
                    optionAmbil.value = 'ambil_sendiri';
                    optionAmbil.textContent = 'Ambil Sendiri';

                    metodeSelect.appendChild(optionAmbil);

                    metodeSelect.disabled = false;
                } else {
                    metodeSelect.disabled = true;
                }

                metodeSelect.value = "";
                updateHarga();
            }


            function formatRupiah(angka) {
                return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            function updateHarga() {
                let ongkir = 0;
                const metode = metodeSelect.value;

                if (metode === 'kurir') {
                    ongkir = totalHarga < 1500000 ? 100000 : 0;
                } else if (metode === 'ambil_sendiri') {
                    ongkir = 0;
                }

                let poinTukar = parseInt(poinTukarInput.value) || 0;
                let diskon = poinTukar * 100 * faktorDiskon;
                const totalMaksimal = totalHarga + ongkir;

                // Validasi supaya diskon tidak lebih dari totalMaksimal
                if (diskon > totalMaksimal) {
                    // Sesuaikan poinTukar agar diskon = totalMaksimal
                    poinTukar = Math.floor(totalMaksimal / (10000 * faktorDiskon));
                    diskon = poinTukar * 10000 * faktorDiskon;
                    poinTukarInput.value = poinTukar; // update input poin
                }

                let totalPembayaran = totalHarga + ongkir - diskon;
                if (totalPembayaran < 0) totalPembayaran = 0;

                subtotalDisplay.textContent = 'Rp ' + formatRupiah(totalHarga);
                ongkirDisplay.textContent = 'Rp ' + formatRupiah(ongkir);
                diskonDisplay.textContent = '- Rp ' + formatRupiah(diskon);
                totalDisplay.textContent = 'Rp ' + formatRupiah(totalPembayaran);
            }

            alamatSelect.addEventListener('change', updateMetodePengiriman);
            metodeSelect.addEventListener('change', updateHarga);

            // Tambahkan ini supaya diskon update saat poin tukar diubah
            poinTukarInput.addEventListener('input', updateHarga);

            // Inisialisasi
            updateMetodePengiriman();
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkoutForm = document.getElementById('checkoutForm');
            const metodeSelect = document.getElementById('metode_pengiriman');
            const metodeHidden = document.getElementById('metode_pengiriman_hidden');

            checkoutForm.addEventListener('submit', function (e) {
                console.log('Submit triggered');
                const metode = metodeSelect.value;
                console.log('Selected metode:', metode);
                if (!metode) {
                    e.preventDefault();
                    alert('Silakan pilih metode pengiriman terlebih dahulu.');
                    metodeSelect.focus();
                }
            });

        });
    </script>

</body>
</html>
