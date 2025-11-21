<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class HomeController extends Controller
{
    public function index()
    {
        $produk = [
            ['nama' => 'Mie Sehat Lemonilo', 'harga' => 7500000, 'gambar' => 'produk1.jpg'],
            ['nama' => 'Headset GA1 Series', 'harga' => 4800000, 'gambar' => 'produk2.jpg'],
            ['nama' => 'Indomie Goreng', 'harga' => 5200000, 'gambar' => 'produk3.jpg'],
            ['nama' => 'Headset G3 Series', 'harga' => 150000, 'gambar' => 'produk4.jpg'],
        ];

        return view('front.home', compact('produk'));
    }

    public function home()
    {
        $produk = Produk::orderBy('id_produk', 'desc')->get();
        return view('front.home', compact('produk'));
    }


    public function about($nama)
    {
        return 'Saya adalah ' . $nama;
    }
}
