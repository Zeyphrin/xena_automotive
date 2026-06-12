<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Car;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Data Akun Login
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@sewamobil.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '08111111111',
            'address' => 'Kantor Pusat'
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'client',
            'phone' => '08222222222',
            'address' => 'Jl. Melati Bandung'
        ]);

        // 2. Buat Data Mobil Dummy
        Car::create([
            'plate_number' => 'B 1234 ABC',
            'brand' => 'Toyota',
            'model' => 'Avanza',
            'year' => 2023,
            'type' => 'MPV',
            'transmission' => 'Automatic',
            'fuel_type' => 'Bensin',
            'seats' => 7,
            'price_per_day' => 350000.00,
            'image_url' => 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&q=80&w=800',
            'description' => 'Mobil keluarga yang nyaman dan irit BBM, cocok untuk perjalanan dalam dan luar kota.',
            'status' => 'available',
            'featured' => true
        ]);

        Car::create([
            'plate_number' => 'D 5678 DEF',
            'brand' => 'Honda',
            'model' => 'Brio',
            'year' => 2022,
            'type' => 'City Car',
            'transmission' => 'Automatic',
            'fuel_type' => 'Bensin',
            'seats' => 5,
            'price_per_day' => 300000.00,
            'image_url' => 'https://images.unsplash.com/photo-1619682817481-e994891cd1f5?auto=format&fit=crop&q=80&w=800',
            'description' => 'Mobil compact lincah dan hemat bahan bakar, sangat pas untuk mobilitas perkotaan.',
            'status' => 'available',
            'featured' => true
        ]);
        
        Car::create([
            'plate_number' => 'L 9012 GHI',
            'brand' => 'Mitsubishi',
            'model' => 'Pajero Sport',
            'year' => 2023,
            'type' => 'SUV',
            'transmission' => 'Automatic',
            'fuel_type' => 'Diesel',
            'seats' => 7,
            'price_per_day' => 900000.00,
            'image_url' => 'https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?auto=format&fit=crop&q=80&w=800',
            'description' => 'SUV tangguh untuk segala medan dengan fitur keamanan lengkap dan kabin mewah.',
            'status' => 'available',
            'featured' => false
        ]);
    }
}