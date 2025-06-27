<!DOCTYPE html>
<html lang="id"> {{-- Mengubah lang ke id untuk konsistensi --}}
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Owner - ReUseMart</title> {{-- Menambahkan ReUseMart ke judul --}}
    
    {{-- Hapus Bootstrap CSS --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    
    {{-- Load Font Roboto dan Tailwind CSS --}}
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Font Awesome untuk ikon, jika diperlukan (seperti icon print) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Poppins', 'Roboto', sans-serif; /* Menggunakan font dari Poppins/Roboto */
            background-color: #f8f9fa; /* Warna latar belakang umum ReUseMart */
            /* Hapus background-image kustom untuk konsistensi */
        }
        /* Penyesuaian khusus untuk beberapa elemen yang mungkin sulit diatur langsung di Tailwind class */
        /* Contoh: jika ingin menargetkan profil-picture-container dengan ukuran fixed */
        .profile-picture-container {
            width: 120px;
            height: 120px;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900"> {{-- bg-f0f2f5, text-gray-900 (default) --}}
    <div class="container mx-auto px-4 py-8 max-w-3xl"> {{-- container my-5, max-width: 960px menjadi max-w-3xl (768px) atau max-w-4xl (896px) --}}
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden mb-8"> {{-- card shadow menjadi shadow-lg rounded-2xl --}}
            <div class="bg-gray-900 text-white px-8 py-6 flex justify-between items-center text-xl font-semibold md:flex-row flex-col text-center md:text-left gap-4"> {{-- card-header bg-dark, padding, flex justify-between, font-weight, font-size, responsive --}}
                <h4>Profil Owner</h4>
                <form action="{{ route('logout') }}" method="POST" class="inline-block"> {{-- d-inline --}}
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-5 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">Logout</button> {{-- btn btn-logout --}}
                </form>
            </div>
            <div class="p-8 flex flex-col items-center"> {{-- card-body --}}
                <div class="profile-picture-container rounded-full overflow-hidden mb-6 shadow-xl"> {{-- profile-picture-container, box-shadow --}}
                    <img src="{{ asset('assets/images/komeng.jpeg') }}" alt="Profile Picture" class="w-full h-full object-cover"> {{-- profile-picture --}}
                </div>
                @if(isset($owner))
                    <div class="w-full overflow-x-auto"> {{-- Tambahkan div untuk responsivitas tabel --}}
                        <table class="min-w-full divide-y divide-gray-200 border border-gray-300 rounded-md"> {{-- table table-bordered --}}
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 bg-gray-50 w-1/3">Nama</th> {{-- table th --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $owner->nama_pegawai }}</td>
                                </tr>
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 bg-gray-50 w-1/3">Username</th>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $owner->username_pegawai }}</td>
                                </tr>
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 bg-gray-50 w-1/3">Email</th>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $owner->email_pegawai }}</td>
                                </tr>
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 bg-gray-50 w-1/3">No Telepon</th>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $owner->no_telp_pegawai }}</td>
                                </tr>
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 bg-gray-50 w-1/3">Tanggal Lahir</th>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $owner->tanggal_lahir }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-red-600 text-center font-medium">Data owner tidak tersedia.</p> {{-- text-danger text-center --}}
                @endif
            </div>
        </div>

        <div class="flex flex-wrap justify-center gap-6 mt-10 md:flex-row flex-col items-center"> {{-- btn-section, responsive --}}
            <a href="{{ route('owner.historyPage') }}" class="inline-block min-w-56 px-6 py-4 bg-gray-900 text-white font-semibold rounded-xl shadow-md hover:bg-gray-800 transition-all duration-300 transform hover:-translate-y-1">History Donasi</a> {{-- btn btn-dark --}}
            <a href="{{ route('owner.requestPage') }}" class="inline-block min-w-56 px-6 py-4 bg-gray-900 text-white font-semibold rounded-xl shadow-md hover:bg-gray-800 transition-all duration-300 transform hover:-translate-y-1">Request Donasi</a>
            <a href="{{ url('/owner/laporan') }}" class="inline-block min-w-56 px-6 py-4 bg-gray-900 text-white font-semibold rounded-xl shadow-md hover:bg-gray-800 transition-all duration-300 transform hover:-translate-y-1">Laporan</a>
            </div>
    </div>
</body>
</html>