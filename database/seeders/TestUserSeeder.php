<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin Toko',
            'email' => 'admin@toko.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Regular User
        User::create([
            'name' => 'User Biasa',
            'email' => 'user@toko.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        echo "\n✅ User Seeder berhasil!\n";
        echo "📧 Admin: admin@toko.com | Password: password\n";
        echo "📧 User: user@toko.com | Password: password\n\n";
    }
}
