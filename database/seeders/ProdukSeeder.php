<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $produkTypes = ['Pro Series', 'Ultra', 'Lite', 'Max Edition', 'Gen 5', 'X200', 'Smart+', 'Edge', 'Flex', 'Prime'];
        $foto_produk = [
            'produk1.jpg',
            'produk2.jpg',
            'produk3.jpg',
            'produk4.jpg',
            'produk5.jpg',
        ];
        $hargaRanges = [
            [100000, 500000, 750000, 900000, 1200000],
            [1300000, 1500000, 1750000, 2000000, 2500000],
            [2600000, 3000000, 3500000, 4000000, 4500000],
            [4600000, 5000000, 6000000, 7000000, 8000000],
            [8500000, 9000000, 10000000, 12000000, 15000000],
        ];
        $diskonRanges = [
            [10, 15, 20, 40, 35],
        ];
        $stockRanges = [
            [0, 5, 10, 15, 20, 25, 30],
        ];
        for ($i = 1; $i <= 100; $i++) {
            $nama_produk = ucwords($faker->word()) . ' ' . fake()->randomElement($produkTypes);
            DB::table('produks')->insert([
                'nama' => $nama_produk,
                'harga' => $faker->randomElement($hargaRanges[array_rand($hargaRanges)]),
                'diskon' => $faker->randomElement($diskonRanges[array_rand($diskonRanges)]),
                'gambar' => $faker->randomElement($foto_produk),
                'stock' => $faker->randomElement($stockRanges[array_rand($stockRanges)]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
