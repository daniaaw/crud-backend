@extends('layouts.main')
@section('title', 'produk')
@section('content')

{{-- Featured Products --}}
<h2 class="mb-3">Featured Products</h2>
<div class="featured-products">
    <div class="row">
        <!-- Data item produk -->

        @foreach ($produk as $item)
        <div class="col-md-2 mb-3">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('img/' . $item['gambar']) }}" class="card-img-top" alt="{{ $item['nama'] }}">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $item['nama'] }}</h5>

                    @if ($item['harga'] > 5000000)
                        <span class="badge bg-dark text-light mb-2">Premium</span>
                    @elseif ($item['harga'] >= 2000000)
                        <span class="badge bg-info text-light mb-2">Menengah</span>
                    @else
                        <span class="badge bg-danger text-light mb-2">Ekonomis</span>
                    @endif

                    <p class="card-text text-primary font-weight-bold">
                        Rp {{ number_format($item['harga'], 0, ',', '.') }}
                    </p>

                    @if($item['diskon'] > 0)
                    <span class="badge bg-success text-light mb-2">
                        Harga Diskon: <br/>
                        Rp {{ ($item['harga']) - ($item['harga']) * ($item['diskon'] / 100) }} <br/>
                        ({{ ($item['diskon']) }} % off)
                    </span>
                    @endif

                    <a href="#" class="btn btn-primary mt-auto">View Details</a>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>
@endsection