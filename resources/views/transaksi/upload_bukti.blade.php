@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <h3 class="fw-bold mb-3 text-dark">Upload Bukti Pembayaran</h3>
    <p class="mb-4">Silakan upload bukti pembayaran untuk transaksi <span class="text-black fw-semibold">{{ $transaksi->nomor_transaksi }}</span></p>

    <div id="custom-countdown" class="mb-4 text-danger fw-bold fs-5" style="letter-spacing: 1px; font-family: 'Courier New', Courier, monospace;">
        Sisa waktu: <span id="custom-countdown-timer">60</span> detik
    </div>

    <form action="{{ route('transaksi.uploadBukti.store', $transaksi->id_transaksi) }}" method="POST" enctype="multipart/form-data" class="border rounded p-4 shadow-sm bg-light">
        @csrf
        <div class="mb-4">
            <label for="bukti_transaksi" class="form-label fw-semibold">Bukti Pembayaran (JPEG, PNG, max 2MB)</label>
            <input type="file" class="form-control @error('bukti_transaksi') is-invalid @enderror" id="bukti_transaksi" name="bukti_transaksi" required>
            @error('bukti_transaksi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-dark w-100 fw-semibold">Upload Bukti</button>
    </form>
</div>

<!-- Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="successModalLabel">Sukses</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Transaksi berhasil dilakukan, menunggu validasi admin.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>


<script>
    const countdownTimer = document.getElementById('custom-countdown-timer');

    let countdown = 60;

    const timer = setInterval(() => {
        countdown--;
        countdownTimer.textContent = countdown;

        countdownTimer.style.transition = 'transform 0.2s ease';
        countdownTimer.style.transform = 'scale(1.3)';
        setTimeout(() => {
            countdownTimer.style.transform = 'scale(1)';
        }, 200);

        if (countdown < 1) {
            clearInterval(timer);
            window.location.href = "{{ route('transaksi.cancelIfExpired', $transaksi->id_transaksi) }}";
        }
    }, 1000);

    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        e.preventDefault(); 
        const myModal = new bootstrap.Modal(document.getElementById('successModal'));
        myModal.show();

        const closeBtn = document.querySelector('#successModal .btn-dark');
        closeBtn.addEventListener('click', function() {
            form.submit();
        }, { once: true });
    });

</script>
@endsection
