@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8"> {{-- Tailwind container for central alignment and padding --}}
    <div class="flex flex-wrap -mx-4"> {{-- Tailwind flex-wrap for responsive row layout --}}
        {{-- Sidebar --}}
        <nav class="w-full md:w-1/4 lg:w-1/5 px-4 mb-6 md:mb-0 bg-gray-100 shadow-lg md:h-screen sticky top-0 overflow-y-auto rounded-lg">
            {{--
                - w-full: Full width on small screens
                - md:w-1/4, lg:w-1/5: Responsive width for medium and large screens
                - px-4: Horizontal padding
                - mb-6 md:mb-0: Margin bottom for small screens, removed on medium
                - bg-gray-100: Light background
                - shadow-lg: Larger shadow for depth
                - md:h-screen: Occupy full viewport height on medium screens and up (vh-100 equivalent)
                - sticky top-0: Makes the sidebar sticky at the top
                - overflow-y-auto: Allows scrolling if content exceeds height
                - rounded-lg: Rounded corners for a softer look
            --}}
            <div class="py-6"> {{-- Padding top for sticky content --}}
                <h5 class="text-center text-xl font-bold mb-6 text-gray-800">Dashboard Gudang</h5> {{-- Larger, bolder heading --}}
                <ul class="flex flex-col space-y-3"> {{-- Flex column with space between items --}}
                    <li class="w-full"> {{-- Ensure list item takes full width --}}
                        <a class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-200 transition-colors duration-200
                           {{ request()->is('gudang/inputBarang') ? 'bg-red-600 text-white font-semibold' : '' }}" href="/gudang/inputBarang">
                            📦 Input Barang
                        </a>
                    </li>
                    <li class="w-full">
                        <a class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-200 transition-colors duration-200
                           {{ request()->is('gudang/ambilBarang') ? 'bg-red-600 text-white font-semibold' : '' }}" href="/gudang/ambilBarang">
                            🧾 Daftar Pengambilan
                        </a>
                    </li>
                    <li class="w-full">
                        <a class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-200 transition-colors duration-200
                           {{ request()->is('gudang/daftarTransaksi') ? 'bg-red-600 text-white font-semibold' : '' }}" href="/gudang/daftarTransaksi">
                            📄 Daftar Transaksi
                        </a>
                    </li>
                    <li class="w-full">
                        <a class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-200 transition-colors duration-200
                           {{ request()->is('gudang/cetak') ? 'bg-red-600 text-white font-semibold' : '' }}" href="/gudang/cetak">
                            🧾 Cetak PDF
                        </a>
                    </li>
                    <li class="w-full">
                        <a class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-200 transition-colors duration-200
                           {{ request()->is('gudang/konfirmasi') ? 'bg-red-600 text-white font-semibold' : '' }}" href="/gudang/konfirmasi">
                            ✅ Konfirmasi Pengambilan
                        </a>
                    </li>
                </ul>

                <div class="mt-8 pt-4 border-t border-gray-200"> {{-- Separator and space for logout button --}}
                    <form action="{{ route('logout') }}" method="POST" class="flex justify-start">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg w-full transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                            {{-- Button styling: red background, white text, bold, generous padding, rounded corners, full width, hover effect, focus ring --}}
                            🚪 Log Out
                        </button>
                    </form>
                </div>
            </div>
        </nav>
        
        {{-- Konten Utama --}}
        <main class="w-full md:w-3/4 lg:w-4/5 px-4 pt-4"> {{-- Main content takes remaining width --}}
            {{--
                - w-full: Full width on small screens
                - md:w-3/4, lg:w-4/5: Responsive width to fit next to sidebar
                - px-4: Horizontal padding
                - pt-4: Padding top
            --}}
            @yield('gudang-content')
        </main>
    </div>
</div>
@endsection