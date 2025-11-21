@extends('layouts.main')
@section('title', 'Produk')
@section('content')

<div class="container mt-4">
    <!-- Search Form -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
        <h4 class="mb-3 text-gray-700">
            <i class="fas fa-search"></i> Cari Produk
        </h4>
        <form method="GET" action="{{ route('products.index') }}" class="row g-3">
            <div class="col-md-4">
                <input 
                    type="text" 
                    name="nama" 
                    class="form-control" 
                    placeholder="Nama produk..." 
                    value="{{ $nama ?? '' }}"
                >
            </div>
            <div class="col-md-3">
                <input 
                    type="number" 
                    name="min" 
                    class="form-control" 
                    placeholder="Harga minimum" 
                    value="{{ $harga_min ?? '' }}"
                >
            </div>
            <div class="col-md-3">
                <input 
                    type="number" 
                    name="max" 
                    class="form-control" 
                    placeholder="Harga maksimum" 
                    value="{{ $harga_max ?? '' }}"
                >
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>
        </form>
        @if($nama || $harga_min || $harga_max)
        <div class="mt-3">
            <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-times"></i> Reset Filter
            </a>
        </div>
        @endif
    </div>

    <!-- Products Grid -->
    <div class="mb-3">
        <h3 class="text-gray-800">
            <i class="fas fa-box-open"></i> Daftar Produk
            <span class="badge bg-primary">{{ $produk->count() }}</span>
        </h3>
    </div>

    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
        @forelse($produk as $item)
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

                    <!-- Stock Badge -->
                    <div class="mb-3">
                        @if($item->stock > 10)
                            <span class="badge bg-success">
                                <i class="fas fa-check-circle"></i> Stok: {{ $item->stock }}
                            </span>
                        @elseif($item->stock > 0)
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-exclamation-circle"></i> Stok: {{ $item->stock }}
                            </span>
                        @else
                            <span class="badge bg-danger">
                                <i class="fas fa-times-circle"></i> Stok Habis
                            </span>
                        @endif
                    </div>

                    <!-- Action Button -->
                    <a href="#" class="btn btn-primary btn-sm mt-auto {{ $item->stock == 0 ? 'disabled' : '' }}">
                        <i class="fas fa-shopping-cart"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> Tidak ada produk yang ditemukan.
            </div>
        </div>
        @endforelse
    </div>
</div>

<!-- Add Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.2) !important;
    }
    .card-title {
        color: #2d3748;
        font-weight: 600;
    }
</style>

@endsection
