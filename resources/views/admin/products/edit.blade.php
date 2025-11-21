@extends('layouts.main')
@section('title', 'Edit Produk')
@section('content')

<div class="container mt-4 mb-5">
    <!-- Header -->
    <div class="mb-4">
        <h2 class="mb-1">
            <i class="fas fa-edit text-primary"></i> Edit Produk
        </h2>
        <p class="text-muted">Ubah informasi produk yang sudah ada</p>
    </div>

    <!-- Form Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.products.update', $produk->id_produk) }}" method="POST" enctype="multipart/form-data" id="productForm">
                @csrf
                @method('PUT')

                <!-- Nama Produk -->
                <div class="mb-3">
                    <label for="nama" class="form-label">
                        Nama Produk <span class="text-danger">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="nama" 
                        id="nama"
                        value="{{ old('nama', $produk->nama) }}"
                        class="form-control @error('nama') is-invalid @enderror"
                        placeholder="Masukkan nama produk"
                    >
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Gambar Produk -->
                <div class="mb-3">
                    <label for="gambar" class="form-label">
                        Gambar Produk
                        <small class="text-muted">(Opsional - Maks. 5MB - JPG, PNG, GIF)</small>
                    </label>
                    
                    @if($produk->gambar)
                    <div class="mb-3">
                        <p class="small text-muted mb-2">Gambar saat ini:</p>
                        <img src="{{ asset('img/'.$produk->gambar) }}" alt="{{ $produk->nama }}" class="img-thumbnail" style="max-height: 200px;">
                    </div>
                    @endif

                    <input 
                        type="file" 
                        name="gambar" 
                        id="gambar"
                        class="form-control @error('gambar') is-invalid @enderror"
                        accept="image/*"
                        onchange="previewImage(this)"
                    >
                    <div class="form-text">Upload gambar baru jika ingin mengubah gambar produk</div>
                    @error('gambar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div id="imagePreview" class="mt-3 d-none">
                        <p class="small text-muted mb-2">Preview gambar baru:</p>
                        <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-height: 200px;">
                    </div>
                </div>

                <!-- Harga -->
                <div class="mb-3">
                    <label for="harga" class="form-label">
                        Harga <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input 
                            type="number" 
                            name="harga" 
                            id="harga"
                            value="{{ old('harga', $produk->harga) }}"
                            min="1"
                            class="form-control @error('harga') is-invalid @enderror"
                            placeholder="0"
                        >
                        @error('harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Stock -->
                <div class="mb-3">
                    <label for="stock" class="form-label">
                        Stock <span class="text-danger">*</span>
                    </label>
                    <input 
                        type="number" 
                        name="stock" 
                        id="stock"
                        value="{{ old('stock', $produk->stock) }}"
                        min="0"
                        class="form-control @error('stock') is-invalid @enderror"
                        placeholder="0"
                    >
                    @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Diskon -->
                <div class="mb-4">
                    <label for="diskon" class="form-label">
                        Diskon (%)
                        <small class="text-muted">(Opsional)</small>
                    </label>
                    <input 
                        type="number" 
                        name="diskon" 
                        id="diskon"
                        value="{{ old('diskon', $produk->diskon ?? 0) }}"
                        min="0"
                        max="100"
                        class="form-control @error('diskon') is-invalid @enderror"
                        placeholder="0"
                    >
                    @error('diskon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Preview image before upload
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').classList.remove('d-none');
                document.getElementById('preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '{{ session('error') }}',
        showConfirmButton: true
    });
</script>
@endif

@if($errors->any())
<script>
    Swal.fire({
        icon: 'error',
        title: 'Validasi Gagal!',
        html: '<ul class="text-start">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
        showConfirmButton: true
    });
</script>
@endif

@endsection
