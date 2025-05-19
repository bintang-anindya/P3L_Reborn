@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- Sidebar --}}
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar shadow-sm vh-100">
            <div class="position-sticky pt-3">
                <h5 class="text-center mt-3">Dashboard CS</h5>
                <ul class="nav flex-column mt-4">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('cs/data-penitip') ? 'active' : '' }}" href="{{ route('cs.penitip.index') }}">
                            📋 Data Penitip
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('cs/verifikasi') ? 'active' : '' }}" href="/cs/verifikasi">
                            ✅ Verifikasi Pembayaran
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('cs/penukaranReward') ? 'active' : '' }}" href="/cs/penukaranReward">
                            🎁 Penukaran Reward
                        </a>
                    </li>
                </ul>
                <div class="mt-auto">
                    <form action="{{ route('logout') }}" method="POST" class="d-flex justify-content-start">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100 mt-4">
                            🚪 Log Out
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        {{-- Konten Utama --}}
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-4">
            @yield('cs-content')
        </main>
    </div>
</div>
@endsection