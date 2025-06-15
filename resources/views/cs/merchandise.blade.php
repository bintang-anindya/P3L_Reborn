<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Klaim Merchandise</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Gaya Hitam Putih Minimalis */
        body {
            padding: 20px;
            background-color: #f8f9fa; /* Latar belakang sangat terang, mendekati putih */
            color: #343a40; /* Warna teks standar (abu-abu gelap) */
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 900px;
            background-color: #ffffff; /* Latar belakang kontainer putih bersih */
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05); /* Sedikit bayangan lembut */
        }
        h1 {
            color: #000000; /* Judul hitam pekat */
            border-bottom: 1px solid #dee2e6; /* Garis bawah abu-abu terang */
            padding-bottom: 15px;
            margin-bottom: 25px;
            font-weight: 600;
        }

        /* Tombol "Back to Dashboard" */
        .btn-back-dashboard {
            background-color: #ffffff;
            color: #343a40;
            border: 1px solid #adb5bd; /* Border abu-abu sedang */
            transition: all 0.2s ease-in-out;
            font-size: 0.9rem;
            padding: 8px 15px;
            margin-bottom: 20px; /* Jarak bawah */
        }
        .btn-back-dashboard:hover {
            background-color: #e9ecef; /* Abu-abu terang saat hover */
            color: #212529; /* Teks lebih gelap saat hover */
            border-color: #6c757d; /* Border lebih gelap saat hover */
        }
        .btn-back-dashboard .bi {
            color: #6c757d; /* Warna ikon standar */
            vertical-align: middle;
            margin-right: 5px;
        }
        .btn-back-dashboard:hover .bi {
            color: #495057; /* Warna ikon lebih gelap saat hover */
        }

        /* Alerts (Pesan Sukses/Error) */
        .alert {
            border-radius: 3px;
            margin-bottom: 20px;
            font-size: 0.95rem;
        }
        .alert-success {
            background-color: #e9ecef; /* Latar belakang abu-abu terang */
            border-color: #ced4da; /* Border abu-abu */
            color: #28a745; /* Teks hijau untuk kontras */
        }
        .alert-danger {
            background-color: #e9ecef; /* Latar belakang abu-abu terang */
            border-color: #ced4da; /* Border abu-abu */
            color: #dc3545; /* Teks merah untuk kontras */
        }

        /* Tabel */
        .table {
            border-collapse: collapse; /* Untuk tampilan border yang rapi */
        }
        .table thead th {
            background-color: #343a40; /* Header hitam gelap */
            color: #ffffff; /* Teks header putih */
            border: 1px solid #343a40; /* Border header sesuai warna background */
            padding: 12px 15px;
            vertical-align: middle;
        }
        .table tbody tr {
            background-color: #ffffff; /* Latar belakang baris putih */
        }
        .table tbody tr:nth-of-type(even) {
            background-color: #f2f2f2; /* Latar belakang baris genap abu-abu sangat terang */
        }
        .table tbody td {
            border: 1px solid #e0e0e0; /* Border sel abu-abu sangat terang */
            padding: 10px 15px;
            vertical-align: middle;
        }
        .table tbody tr:hover {
            background-color: #e9ecef; /* Abu-abu terang saat hover pada baris */
        }

        /* Tombol Aksi di Tabel */
        .btn-sm.btn-primary {
            background-color: #000000; /* Hitam pekat */
            border-color: #000000;
            color: #ffffff;
            padding: 6px 12px;
            font-size: 0.85rem;
            border-radius: 3px;
            transition: background-color 0.2s ease-in-out;
        }
        .btn-sm.btn-primary:hover {
            background-color: #343a40; /* Abu-abu gelap saat hover */
            border-color: #343a40;
        }
        .badge.bg-success {
            background-color: #e0e0e0 !important; /* Latar belakang badge abu-abu */
            color: #343a40 !important; /* Teks badge abu-abu gelap */
            padding: 6px 10px;
            border-radius: 3px;
            font-weight: normal;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Daftar Klaim Merchandise Pembeli</h1>

        <form action="{{ route('dashboard.cs') }}" method="GET">
            <button class="btn btn-back-dashboard">
                <svg class="bi bi-house-door me-1" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5V10.3a1.5 1.5 0 0 1 3 0v4.2a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L8.354 1.146zM11.5 7.5v7h-3V10.3a.5.5 0 0 0-.5-.5H6a.5.5 0 0 0-.5.5v4.2h-3v-7l5.657-5.657L11.5 7.5z"/>
                </svg>
                Back to Dashboard
            </button>
        </form>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <th>Nama Pembeli</th>
                    <th>Nama Merchandise</th>
                    <th>Tanggal Ambil</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($klaimMerchandise as $klaim)
                    <tr>
                        <td>{{ $klaim->pembeli->nama_pembeli ?? 'N/A' }}</td>
                        <td>{{ $klaim->merchandise->nama_merchandise ?? 'N/A' }}</td>
                        <td>
                            @if ($klaim->tanggal_ambil_merchandise)
                                {{ \Carbon\Carbon::parse($klaim->tanggal_ambil_merchandise)->format('d M Y') }}
                            @else
                                Belum Ada
                            @endif
                        </td>
                        <td>{{ $klaim->status_merchandise }}</td>
                        <td>
                            @if (!$klaim->tanggal_ambil_merchandise)
                                <form action="{{ route('cs.merchandise.update', $klaim->id_pembeli_merchandise) }}" method="POST" onsubmit="return confirm('Yakin ingin mengisi tanggal pengambilan?')">
                                    @csrf
                                    {{-- Menggunakan Carbon::now()->toDateString() untuk format YYYY-MM-DD --}}
                                    <input type="hidden" name="tanggal_ambil" value="{{ \Carbon\Carbon::now()->toDateString() }}">
                                    <button type="submit" class="btn btn-sm btn-primary">Isi Tanggal Ambil</button>
                                </form>
                            @else
                                <span class="badge bg-success">Sudah Diambil</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data klaim merchandise.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>