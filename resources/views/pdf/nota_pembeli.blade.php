<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nota Penjualan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .box { border: 1px solid #000; padding: 10px; width: 300px; }
        .text-bold { font-weight: bold; }
        .mt-2 { margin-top: 10px; }
        .mb-0 { margin-bottom: 0; }
        ul { list-style-type: none; padding: 0; margin: 0; }
        .right { float: right; }
        .clear { clear: both; }
    </style>
</head>
<body>
    <h3>Nota Penjualan (diambil oleh pembeli)</h3>
    <div class="box">
        <p class="text-bold mb-0">ReUse Mart</p>
        <p>Jl. Green Eco Park No. 456 Yogyakarta</p>

        <p>
            No Nota&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ now()->format('y.m.') . $transaksi->id_transaksi }}<br>
            Tanggal pesan : {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d/m/Y H:i') }}<br>
            Lunas pada&nbsp;&nbsp;&nbsp;&nbsp;: {{ \Carbon\Carbon::parse($transaksi->updated_at)->format('d/m/Y H:i') }}<br>
            Tanggal ambil : {{ \Carbon\Carbon::parse($transaksi->tanggal_pengiriman)->format('d/m/Y') }}
        </p>

        <p>
            <span class="text-bold">Pembeli&nbsp;&nbsp;:</span> {{ $transaksi->pembeli->email }} / {{ $transaksi->pembeli->nama_pembeli }}<br>
            {{ $transaksi->pembeli->alamatPembeli->alamat ?? '-' }}
        </p>

        <p><span class="text-bold">Delivery:</span> diambil sendiri</p>
        <ul>
            @foreach ($transaksi->barangs as $barang)
                <li>
                    {{ $barang->nama_barang ?? '-' }}
                    <span class="right">{{ number_format($barang->harga_barang ?? 0, 0, ',', '.') }}</span>
                </li>
            @endforeach
        </ul>
        <div class="clear"></div>

        <p class="mt-2 mb-0">Total<span class="right">{{ number_format($transaksi->jumlah_transaksi, 0, ',', '.') }}</span></p>
        <p class="mb-0">Ongkos Kirim<span class="right">{{ number_format($transaksi->ongkos_pengiriman, 0, ',', '.') }}</span></p>
        <p class="mb-0">Total<span class="right">{{ number_format($transaksi->jumlah_transaksi + $transaksi->ongkos_pengiriman, 0, ',', '.') }}</span></p>
        <p class="mb-0">Potongan 0 </p>

        <p class="mt-2">
            <span class="text-bold">Poin dari pesanan ini: 0 </span><br>
            <span class="text-bold">Total poin customer:</span> {{ $transaksi->pembeli->poin_reward }}
        </p>

        <p class="mt-2">QC oleh: {{ $transaksi->pegawai->nama_pegawai ?? '-' }} (P{{ $transaksi->pegawai->id_pegawai ?? '-' }})</p>

        <p class="mt-2">Diambil oleh:</p>
        <p>(......................................................)<br>
        Tanggal: ...............................</p>
    </div>
</body>
</html>