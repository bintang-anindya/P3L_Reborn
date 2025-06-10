<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ReUseMart - E-Commerce</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      font-family: 'Roboto', sans-serif;
    }
  </style>
</head>
<body class="bg-white text-black">

  <!-- Topbar -->
  <div class="bg-black text-white text-sm py-2 px-4 text-center">
    Perbanyak Belanja dan Dapatkan Poin Serta Merchandise Menarik! 
    <a href="{{ route('dashboard.pembeli') }}" class="underline ml-2">Belanja</a>
  </div>
  
  <!-- Navbar -->
  <nav class="bg-white border-b border-gray-300">
    <div class="container mx-auto flex justify-between items-center py-3 px-4">
      <a href="{{ route('dashboard.pembeli') }}" class="font-bold text-xl">ReUseMart</a>
      <form class="flex-1 max-w-sm mx-4">
        <input type="search" placeholder="Apa yang anda butuhkan?" class="w-full border border-gray-300 rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
      </form>
      <div class="flex items-center space-x-3">
        <a href="{{ route('diskusi.index') }}" class="border border-black rounded-full px-3 py-1 text-sm hover:bg-black hover:text-white transition">Diskusi</a>
        <a href="{{ route('alamat.manager') }}" class="border border-black rounded-full px-3 py-1 text-sm hover:bg-black hover:text-white transition">Kelola Alamat</a>
        <a href="{{ route('dashboard.pembeli') }}" class="text-black">
          <i class="fas fa-user-circle text-lg border border-black rounded p-1"></i>
        </a>
        <a href="#" class="text-black">
          <i class="fas fa-heart text-lg"></i>
        </a>
        <a href="{{ route('keranjang.index') }}" class="text-black">
          <i class="fas fa-shopping-cart text-lg"></i>
        </a>
      </div>
    </div>
  </nav>

  <main class="container mx-auto mt-8 pb-20 px-4">
    @if(Auth::check())
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
      <!-- Card Header -->
      <div class="bg-black text-white flex justify-between items-center px-4 py-3">
        <h4 class="text-lg font-bold">Profil Pembeli</h4>
        <div class="flex items-center space-x-2">
          <a href="{{ route('dashboard.pembeli') }}" class="bg-white text-black rounded-full px-3 py-1 text-sm hover:bg-gray-200 transition">← Dashboard</a>
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-600 text-white rounded-full px-3 py-1 text-sm hover:bg-red-700 transition">Logout</button>
          </form>
        </div>
      </div>

      <!-- Card Body -->
      <div class="px-4 py-4">
        <table class="w-full border text-sm">
          <tbody>
            <tr class="border-b">
              <th class="text-left font-medium px-2 py-2 bg-gray-100">Nama</th>
              <td class="px-2 py-2">{{ $pembeli->nama_pembeli }}</td>
            </tr>
            <tr class="border-b">
              <th class="text-left font-medium px-2 py-2 bg-gray-100">Username</th>
              <td class="px-2 py-2">{{ $pembeli->username_pembeli }}</td>
            </tr>
            <tr class="border-b">
              <th class="text-left font-medium px-2 py-2 bg-gray-100">Email</th>
              <td class="px-2 py-2">{{ $pembeli->email_pembeli }}</td>
            </tr>
            <tr class="border-b">
              <th class="text-left font-medium px-2 py-2 bg-gray-100">No Telepon</th>
              <td class="px-2 py-2">{{ $pembeli->no_telp_pembeli }}</td>
            </tr>
            <tr class="border-b">
              <th class="text-left font-medium px-2 py-2 bg-gray-100">Poin</th>
              <td class="px-2 py-2">{{ $pembeli->poin_pembeli }}</td>
            </tr>
            <tr>
              <th class="text-left font-medium px-2 py-2 bg-gray-100">Alamat</th>
              <td class="px-2 py-2">
                @if($pembeli->id_alamat_utama && $pembeli->alamats->where('id_alamat', $pembeli->id_alamat_utama)->first())
                  {{ $pembeli->alamats->where('id_alamat', $pembeli->id_alamat_utama)->first()->detail }}
                @else
                  Belum diatur
                @endif
              </td>
            </tr>
          </tbody>
        </table>

        @if($pembeli->transaksi && $pembeli->transaksi->isNotEmpty())
        <div class="mt-6">
          <div class="bg-black text-white px-4 py-2 rounded-t">
            <h5 class="font-bold">Riwayat Pembelian</h5>
          </div>
          <div class="overflow-x-auto">
            <table class="w-full text-sm border">
              <thead class="bg-green-100 text-black">
                <tr>
                  <th class="px-3 py-2 text-left">NO</th>
                  <th class="px-3 py-2 text-left">Tanggal Transaksi</th>
                  <th class="px-3 py-2 text-left">Status</th>
                  <th class="px-3 py-2 text-left">Barang</th>
                  <th class="px-3 py-2 text-left">Total Harga</th>
                  <th class="px-3 py-2 text-left">Pegawai Verifikasi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($pembeli->transaksi as $index => $transaksi)
                <tr class="border-b hover:bg-gray-50">
                  <td class="px-3 py-2">{{ $index + 1 }}</td>
                  <td class="px-3 py-2">{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d M Y') }}</td>
                  <td class="px-3 py-2 capitalize">{{ $transaksi->status_transaksi }}</td>
                  <td class="px-3 py-2">
                    <ul class="list-disc pl-4">
                      @foreach($transaksi->barangs as $barang)
                        <li>{{ $barang->nama_barang }}</li>
                      @endforeach
                    </ul>
                  </td>
                  <td class="px-3 py-2">Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                  <td class="px-3 py-2">
                    {{ ($transaksi->pegawai && $transaksi->pegawai->nama_pegawai !== 'DUMMY') ? $transaksi->pegawai->nama_pegawai : '-' }}
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        @else
        <div class="mt-6 p-4 bg-blue-100 border-l-4 border-blue-500 text-blue-700 rounded">
          Belum ada riwayat pembelian.
        </div>
        @endif
      </div>
    </div>
    @endif
  </main>

  <!-- Footer -->
  <footer class="bg-black text-white text-center py-3 fixed bottom-0 w-full">
    &copy; 2025 ReUseMart
  </footer>

  <!-- Font Awesome -->
  <script src="https://kit.fontawesome.com/yourkit.js" crossorigin="anonymous"></script>

</body>
</html>