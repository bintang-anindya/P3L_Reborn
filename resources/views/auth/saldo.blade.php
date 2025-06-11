@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Penitip Saldo</h1>
    @if($penitips->isEmpty())
        <p>Tidak ada data penitp.</p>
    @else
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="py-2 px-4 border-b">Nama Penitip</th>
                    <th class="py-2 px-4 border-b">Username</th>
                    <th class="py-2 px-4 border-b">Saldo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penitips as $penitip)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $penitip->nama_penitip }}</td>
                        <td class="py-2 px-4 border-b">{{ $penitip->username_penitip }}</td>
                        <td class="py-2 px-4 border-b">Rp {{ number_format($penitip->saldo_penitip, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection


