@extends('layouts.main')
@section('title', 'Home')
@section('content')

<div class="container mt-4">
    {{-- Banner --}}
    <div class="banner mb-5">
        <div class="position-relative">
            @if(file_exists(public_path('img/banner.webp')))
                <img src="{{ asset('img/banner.webp') }}" alt="Banner" class="img-fluid rounded shadow-lg w-100" style="max-height: 400px; object-fit: cover;">
            @else
                <div class="bg-gradient-primary text-white rounded shadow-lg p-5 text-center" style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);">
                    <h1 class="display-4 fw-bold mb-3">
                        <i class="fas fa-store"></i> Selamat Datang di Toko-5129
                    </h1>
                    <p class="lead">Temukan produk berkualitas dengan harga terbaik</p>
                    <a href="{{ route('products.index') }}" class="btn btn-light btn-lg mt-3">
                        <i class="fas fa-shopping-cart"></i> Belanja Sekarang
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- Featured Products --}}
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h2 class="mb-0">
                <i class="fas fa-star text-warning"></i> Produk Unggulan
            </h2>
            <p class="text-muted">Pilihan terbaik untuk Anda</p>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
            Lihat Semua <i class="fas fa-arrow-right"></i>
        </a>
    </div>

    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
        @forelse ($produk->take(8) as $item)
        <div class="col">
            <div class="card h-100 shadow-sm hover-card">
                @if($item->gambar)
                    <img src="{{ asset('img/' . $item->gambar) }}" class="card-img-top" alt="{{ $item->nama }}" style="height: 200px; object-fit: cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-center" style="height: 200px;">
                        <span class="text-muted">No Image</span>
                    </div>
                @endif
                
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-truncate" title="{{ $item->nama }}">{{ $item->nama }}</h5>

                    <!-- Category Badge -->
                    @if ($item->harga > 5000000)
                        <span class="badge bg-dark mb-2">
                            <i class="fas fa-crown"></i> Premium
                        </span>
                    @elseif ($item->harga >= 2000000)
                        <span class="badge bg-info mb-2">
                            <i class="fas fa-star"></i> Menengah
                        </span>
                    @else
                        <span class="badge bg-success mb-2">
                            <i class="fas fa-tag"></i> Ekonomis
                        </span>
                    @endif

                    <!-- Price -->
                    <div class="mb-2">
                        @if($item->diskon > 0)
                            <p class="mb-1">
                                <span class="text-decoration-line-through text-muted small">
                                    Rp {{ number_format($item->harga, 0, ',', '.') }}
                                </span>
                                <span class="badge bg-danger ms-2">-{{ $item->diskon }}%</span>
                            </p>
                            <p class="text-primary fw-bold fs-5 mb-0">
                                Rp {{ number_format($item->harga - ($item->harga * $item->diskon / 100), 0, ',', '.') }}
                            </p>
                        @else
                            <p class="text-primary fw-bold fs-5 mb-0">
                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </p>
                        @endif
                    </div>

                    <!-- Stock -->
                    @if($item->stock > 0)
                        <span class="badge bg-success mb-3">
                            <i class="fas fa-check-circle"></i> Stok: {{ $item->stock }}
                        </span>
                    @else
                        <span class="badge bg-danger mb-3">
                            <i class="fas fa-times-circle"></i> Stok Habis
                        </span>
                    @endif

                    <a href="#" class="btn btn-primary btn-sm mt-auto {{ $item->stock == 0 ? 'disabled' : '' }}">
                        <i class="fas fa-shopping-cart"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> Belum ada produk yang tersedia.
            </div>
        </div>
        @endforelse
    </div>

    <!-- Info Section -->
    <div class="row mt-5 mb-4">
        <div class="col-md-4 mb-3">
            <div class="card text-center h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-shipping-fast fa-3x text-primary"></i>
                    </div>
                    <h5>Pengiriman Cepat</h5>
                    <p class="text-muted">Gratis ongkir untuk pembelian tertentu</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-shield-alt fa-3x text-success"></i>
                    </div>
                    <h5>Pembayaran Aman</h5>
                    <p class="text-muted">Transaksi terjamin 100% aman</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-headset fa-3x text-info"></i>
                    </div>
                    <h5>Customer Support</h5>
                    <p class="text-muted">Siap melayani 24/7</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.2) !important;
    }
</style>

@endsection