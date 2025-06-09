<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Owner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .card-header {
            background-color: #000;
            color: #fff;
        }
        .btn-logout {
            background-color: #dc3545;
            color: #fff;
        }
        .btn-logout:hover {
            background-color: #c82333;
        }
        .btn-section {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-top: 50px;
        }
        .btn-section .btn {
            min-width: 250px;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Profil Owner</h4>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-logout btn-sm">Logout</button>
                </form>
            </div>
            <div class="card-body">
                @if(isset($owner))
                    <table class="table table-bordered">
                        <tr>
                            <th>Nama</th>
                            <td>{{ $owner->nama_pegawai }}</td>
                        </tr>
                        <tr>
                            <th>Username</th>
                            <td>{{ $owner->username_pegawai }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $owner->email_pegawai }}</td>
                        </tr>
                        <tr>
                            <th>No Telepon</th>
                            <td>{{ $owner->no_telp_pegawai }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Lahir</th>
                            <td>{{ $owner->tanggal_lahir }}</td>
                        </tr>
                    </table>
                @else
                    <p class="text-danger">Data owner tidak tersedia.</p>
                @endif
            </div>
        </div>

        <div class="btn-section">
            <a href="{{ route('owner.historyPage') }}" class="btn btn-dark">History Donasi</a>
            <a href="{{ route('owner.requestPage') }}" class="btn btn-dark">Request Donasi</a>
            <a href="{{ url('/owner/laporan') }}" class="btn btn-dark">Laporan</a>
            <a href="{{ route('laporan.penitip') }}" class="btn btn-dark">Laporan Transaksi</a>
        </div>
    </div>
</body>
</html>
