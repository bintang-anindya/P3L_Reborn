@props(['item'])

<a href="{{ route('detailBarangPembeli', $item->id_barang) }}" class="text-decoration-none text-dark">
    <div class="product-card">
        <div class="image-wrapper">
            <img src="{{ asset('storage/' . $item->gambar_barang) }}" width="100" class="img-thumbnail" alt="Gambar {{ $item->nama_barang }}">
            <div class="overlay">
                <span>Lihat Barang</span>
            </div>
        </div>

        <p class="mt-2 fw-bold text-truncate">{{ $item->nama_barang }}</p>
        <div>
            <span class="product-price">Rp{{ number_format($item->harga_barang, 0, ',', '.') }}</span>
        </div>
    </div>
</a>

<style>
    .product-card {
        background: #f9f9f9;
        border-radius: 10px;
        padding: 10px;
        transition: transform 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;        
        min-height: 250px;
        max-height: 280px;
    }

    .product-card:hover {
        transform: translateY(-5px);
    }

    .image-wrapper {
        position: relative;
        width: 100%;
        height: 150px;
        overflow: hidden;
        border-radius: 10px;
    }

    .image-wrapper img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background: rgba(0, 0, 0, 0.5);
        color: white;
        font-weight: bold;
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        border-radius: 10px;
    }

    .image-wrapper:hover .overlay {
        opacity: 1;
    }

    .product-price {
        color: #d9534f;
    }
</style>