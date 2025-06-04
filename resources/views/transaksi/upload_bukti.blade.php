@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h3 class="fw-bold">Upload Bukti Pembayaran</h3>
    <p>Silakan upload bukti pembayaran untuk transaksi #{{ $transaksi->id_transaksi }}</p>
    <div id="countdown" class="mb-3 text-danger fw-bold"></div>
    <form action="{{ route('transaksi.uploadBukti.store', $transaksi->id_transaksi) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="bukti_transaksi" class="form-label">Bukti Pembayaran (JPEG, PNG, max 2MB)</label>
            <input type="file" class="form-control" id="bukti_transaksi" name="bukti_transaksi" required>
            @error('bukti_transaksi')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Upload Bukti</button>
    </form>
</div>

<script>
    let countdown = 60;
    const countdownElement = document.getElementById('countdown');

    const timer = setInterval(() => {
        countdown--;
        countdownElement.textContent = `Sisa waktu: ${countdown} detik`; // gunakan backtick!
        console.log(`Countdown saat ini: ${countdown}`); // Debug: cek nilai countdown setiap detik

        if (countdown < 1) {
            console.log('Countdown selesai, akan clear interval dan redirect');
            clearInterval(timer);
            window.location.href = "{{ route('transaksi.cancelIfExpired', $transaksi->id_transaksi) }}";
        }
    }, 1000);
</script>


@endsection
