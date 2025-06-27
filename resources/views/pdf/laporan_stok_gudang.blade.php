<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Stok Gudang</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', 'Roboto', sans-serif; /* Menggunakan font dari Poppins/Roboto */
            font-size: 10px; /* Slightly smaller base font for more content */
            color: #333; /* Softer black */
            margin: 20px; /* Add some margin around the entire page */
        }
        h4, h5 {
            margin: 0;
            color: #0056b3; /* A nice blue for headings */
        }
        h4 {
            font-size: 18px;
            font-weight: 600; /* Bolder for main titles */
            margin-bottom: 5px;
        }
        h5 {
            font-size: 14px;
            font-weight: 400;
            text-decoration: none; /* Remove underline, it can look dated */
            margin-top: 10px;
            color: #555; /* Softer color for subtitles */
        }
        .header-section {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 2px solid #007bff; /* A prominent border for header */
        }
        .header-section div {
            font-size: 11px;
            color: #666;
            margin-top: 2px;
        }
        .report-title {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 15px;
        }
        .report-title h4 {
            color: #007bff;
            font-size: 22px;
            font-weight: 700;
        }
        .report-meta {
            text-align: right;
            font-size: 10px;
            color: #777;
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05); /* Subtle shadow for depth */
        }
        th, td {
            border: 1px solid #ddd; /* Lighter border color */
            padding: 8px 12px; /* More padding for better readability */
            text-align: left;
            vertical-align: top; /* Align content to the top */
        }
        th {
            background-color: #e9f5ff; /* Light blue background for headers */
            color: #0056b3; /* Darker blue text for headers */
            font-weight: 600; /* Bolder headers */
            text-transform: uppercase; /* Uppercase for a clean look */
            font-size: 10px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9; /* Zebra striping for readability */
        }
        tr:hover {
            background-color: #f0f8ff; /* Highlight on hover (though less relevant for PDF, good practice) */
        }
        td {
            font-size: 9.5px;
            line-height: 1.4; /* Better line spacing */
        }
        .price {
            text-align: right; /* Align price to the right */
            font-weight: 500; /* Slightly bolder for prices */
            color: #28a745; /* Green color for prices */
        }
        .no-data-message {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            border: 1px dashed #ccc;
            background-color: #fdfdfd;
            color: #555;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header-section">
        <h4>{{ $companyName ?? 'ReUseMart' }}</h4>
        <div>{{ $companyAddress ?? 'Jl. Green Eco Park No. 456 Yogyakarta' }}</div>
    </div>

    <div class="report-title">
        <h4>Laporan Stok Gudang</h4>
    </div>
    <div class="report-meta">
        Tanggal Cetak : {{ $cetakDate ?? \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}
    </div>

    @if(isset($stokGudangList) && $stokGudangList->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th>ID Penitip</th>
                    <th>Nama Penitip</th>
                    <th>Tanggal Masuk</th>
                    <th>Perpanjangan</th>
                    <th>ID Hunter</th>
                    <th>Nama Hunter</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stokGudangList as $barang)
                    <tr>
                        <td>{{ $barang->id_barang ?? '-' }}</td>
                        <td>{{ $barang->nama_barang ?? '-' }}</td>
                        <td>{{ $barang->penitipan->penitip->id_penitip ?? '-' }}</td>
                        <td>{{ $barang->penitipan->penitip->nama_penitip ?? '-' }}</td>
                        <td>{{ $barang->tanggal_masuk ? \Carbon\Carbon::parse($barang->tanggal_masuk)->format('d M Y') : '-' }}</td>
                        <td>{{ $barang->status_perpanjangan ? 'Ya' : 'Tidak' }}</td>
                        <td>{{ $barang->penitipan->id_hunter ?? '-' }}</td>
                        <td>{{ $barang->penitipan->hunter->nama_pegawai ?? '-' }}</td>
                        <td class="price">Rp {{ number_format($barang->harga_barang ?? 0, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="no-data-message">Tidak ada data stok barang di gudang untuk ditampilkan saat ini.</p>
    @endif
</body>
</html>