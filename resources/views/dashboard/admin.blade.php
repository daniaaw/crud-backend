@extends('layouts.main')
@section('title', 'Dashboard Admin')
@section('content')

<div class="container mt-4">
    <!-- Welcome Card -->
    <div class="card border-0 shadow-lg mb-4" style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);">
        <div class="card-body text-white p-5">
            <h2 class="mb-3">
                <i class="fas fa-user-shield"></i> Selamat Datang, {{ auth()->user()->name }}! 👋
            </h2>
            <p class="lead mb-0">Anda memiliki hak penuh untuk mengelola sistem Toko-5129.</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <h3 class="mb-4">
        <i class="fas fa-bolt text-warning"></i> Quick Actions
    </h3>
    <div class="row g-4">
        <!-- Manage Products -->
        <div class="col-md-4">
            <a href="{{ route('admin.products.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-card" style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);">
                    <div class="card-body text-white p-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-boxes fa-2x me-3"></i>
                            <h4 class="mb-0">Kelola Produk</h4>
                        </div>
                        <p class="mb-0 opacity-75">Tambah, edit, atau hapus produk</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- View Products (User View) -->
        <div class="col-md-4">
            <a href="{{ route('products.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <div class="card-body text-white p-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-shopping-bag fa-2x me-3"></i>
                            <h4 class="mb-0">Lihat Produk</h4>
                        </div>
                        <p class="mb-0 opacity-75">Tampilan pelanggan</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Add New Product -->
        <div class="col-md-4">
            <a href="{{ route('admin.products.create') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-card" style="background: linear-gradient(135deg, #f59e0b 0%, #dc2626 100%);">
                    <div class="card-body text-white p-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-plus-circle fa-2x me-3"></i>
                            <h4 class="mb-0">Tambah Produk</h4>
                        </div>
                        <p class="mb-0 opacity-75">Buat produk baru</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Statistics Cards (Optional) -->
    <div class="row mt-5 g-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-box fa-3x text-primary mb-3"></i>
                    <h5 class="text-muted">Total Produk</h5>
                    <h2 class="mb-0">{{ \App\Models\Produk::count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                    <h5 class="text-muted">Stok Tersedia</h5>
                    <h2 class="mb-0">{{ \App\Models\Produk::where('stock', '>', 0)->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-times-circle fa-3x text-danger mb-3"></i>
                    <h5 class="text-muted">Stok Habis</h5>
                    <h2 class="mb-0">{{ \App\Models\Produk::where('stock', '=', 0)->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-3x text-info mb-3"></i>
                    <h5 class="text-muted">Total Users</h5>
                    <h2 class="mb-0">{{ \App\Models\User::count() }}</h2>
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