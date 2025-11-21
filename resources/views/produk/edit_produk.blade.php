<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Staff
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form action="{{ route('staff.produk.update', $produk->id_produk) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label>Nama Produk</label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama', $produk->nama) }}">
                    </div>
                    <div class="mb-3">
                        <label>Harga</label>
                        <input type="number" name="harga" class="form-control" value="{{ old('harga', $produk->harga) }}">
                    </div>
                    <div class="mb-3">
                        <label>Diskon (%)</label>
                        <input type="number" name="diskon" class="form-control" value="{{ old('diskon', $produk->diskon) }}">
                    </div>
                    <button class="btn btn-success">Perbarui</button>
                    <a href="{{ route('staff.produk') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>