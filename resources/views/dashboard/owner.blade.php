<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Owner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5; /* Light gray background */
            font-family: 'Poppins', sans-serif;
            /* Subtle pattern for background */
            background-image: url('data:image/svg+xml;utf8,<svg width="100%" height="100%" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="p" width="10" height="10" patternUnits="userSpaceOnUse"><circle cx="1" cy="1" r="1" fill="%23e0e0e0"/></pattern></defs><rect width="100%" height="100%" fill="url(%23p)"/></svg>');
            background-size: 20px 20px;
        }
        .container {
            max-width: 960px;
        }
        .card {
            border-radius: 15px; /* Softer rounded corners */
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); /* Enhanced shadow */
            border: none; /* Remove default border */
        }
        .card-header {
            background-color: #212529; /* Darker header */
            color: #fff;
            padding: 1.5rem 2rem;
            border-bottom: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
            font-size: 1.25rem;
        }
        .card-body {
            padding: 2rem;
            background-color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center; /* Center content in the body */
        }
        /* Style for profile picture */
        .profile-picture-container {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        .profile-picture {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .table {
            margin-bottom: 0;
            width: 100%; /* Ensure table takes full width */
        }
        .table th, .table td {
            padding: 1rem;
            vertical-align: middle;
            border-top: 1px solid #e9ecef; /* Lighter border for table rows */
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #495057;
            width: 30%; /* Adjust width for better alignment */
        }
        .table tr:first-child th, .table tr:first-child td {
            border-top: none;
        }
        .btn-logout {
            background-color: #dc3545;
            color: #fff;
            border-radius: 8px; /* Slightly rounded buttons */
            padding: 0.5rem 1.25rem;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.2); /* Subtle shadow on logout */
        }
        .btn-logout:hover {
            background-color: #c82333;
            transform: translateY(-2px); /* Lift effect on hover */
            box-shadow: 0 6px 15px rgba(220, 53, 69, 0.3);
        }
        .btn-section {
            display: flex;
            flex-wrap: wrap; /* Allow wrapping for smaller screens */
            justify-content: center;
            gap: 25px; /* Reduced gap for better fit */
            margin-top: 40px; /* Slightly reduced margin */
        }
        .btn-section .btn {
            min-width: 220px; /* Slightly reduced min-width */
            padding: 1rem 1.5rem;
            border-radius: 10px; /* More rounded buttons */
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); /* Shadow for main buttons */
            background-color: #343a40; /* Darker shade for consistency */
            color: #fff;
        }
        .btn-section .btn:hover {
            background-color: #495057; /* Lighter on hover */
            transform: translateY(-3px); /* More pronounced lift */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        .text-danger {
            font-weight: 500;
            color: #dc3545 !important;
        }

        @media (max-width: 768px) {
            .btn-section {
                flex-direction: column;
                align-items: center;
            }
            .btn-section .btn {
                min-width: 80%; /* Full width on small screens */
            }
            .card-header {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="card shadow">
            <div class="card-header">
                <h4>Profil Owner</h4>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-logout">Logout</button>
                </form>
            </div>
            <div class="card-body">
                <div class="profile-picture-container">
                    <img src="{{ asset('assets/images/komeng.jpeg') }}" alt="Profile Picture" class="profile-picture">
                </div>
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
                    <p class="text-danger text-center">Data owner tidak tersedia.</p>
                @endif
            </div>
        </div>

        <div class="btn-section">
            <a href="{{ route('owner.historyPage') }}" class="btn btn-dark">History Donasi</a>
            <a href="{{ route('owner.requestPage') }}" class="btn btn-dark">Request Donasi</a>
            <a href="{{ url('/owner/laporan') }}" class="btn btn-dark">Laporan</a>
            <a href="{{ route('laporan.liveCode') }}" class="btn btn-dark">Laporan Donasi Elektronik</a>

        </div>
    </div>
</body>
</html>