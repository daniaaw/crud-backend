<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Data produk
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <a href="{{ route('staff.produk.create') }}" class="btn btn-primary mb-3">Tambah Produk</a>
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Diskon (%)</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produk as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->nama }}</td>
                            <td>Rp {{ number_format($p->harga,0,',','.') }}</td>
                            <td>{{ $p->diskon }}%</td>
                            <td>
                                @if($p->gambar)
                                <img src="{{ asset('img/'.$p->gambar) }}" width="80">
                                @else
                                <em>Tidak ada</em>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('staff.produk.edit', $p->id_produk) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('staff.produk.delete', $p->id_produk) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus produk ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>