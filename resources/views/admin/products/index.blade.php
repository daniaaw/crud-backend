@extends('layouts.main')
@section('title', 'Manajemen Produk')
@section('content')

<div class="container mt-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">
                <i class="fas fa-boxes text-primary"></i> Manajemen Produk
            </h2>
            <p class="text-muted mb-0">Kelola semua produk Anda di sini</p>
        </div>
        <div>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>
                Tambah Produk
            </a>
        </div>
    </div>

    <!-- Products Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 50px;">No</th>
                            <th style="width: 100px;">Gambar</th>
                            <th>Nama Produk</th>
                            <th style="width: 150px;">Harga</th>
                            <th class="text-center" style="width: 100px;">Stock</th>
                            <th class="text-center" style="width: 100px;">Diskon</th>
                            <th class="text-center" style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produk as $p)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>
                                @if($p->gambar)
                                    <img src="{{ asset('img/'.$p->gambar) }}" alt="{{ $p->nama }}" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $p->nama }}</strong>
                            </td>
                            <td>
                                <strong class="text-primary">Rp {{ number_format($p->harga, 0, ',', '.') }}</strong>
                            </td>
                            <td class="text-center">
                                @if($p->stock > 10)
                                    <span class="badge bg-success">{{ $p->stock }}</span>
                                @elseif($p->stock > 0)
                                    <span class="badge bg-warning">{{ $p->stock }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $p->stock }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($p->diskon > 0)
                                    <span class="badge bg-info">{{ $p->diskon }}%</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.products.edit', $p->id_produk) }}" class="btn btn-sm btn-warning me-1" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $p->id_produk) }}" method="POST" class="d-inline delete-form">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete(this)" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada produk. <a href="{{ route('admin.products.create') }}">Tambah produk pertama</a></p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000,
            toast: true,
            position: 'top-end'
        });
    </script>
    @endif

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

    <script>

        // Confirm delete
        function confirmDelete(button) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data produk akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        }
    </script>

@endsection
