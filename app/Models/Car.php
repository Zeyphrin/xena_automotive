<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    // Daftar kolom yang diizinkan untuk diisi dari form
    protected $fillable = [
        'plate_number',
        'brand',
        'model',
        'year',
        'type',
        'transmission',
        'fuel_type',
        'seats',
        'price_per_day',
        'image_url',
        'description',
        'status'
    ];

    /**
     * Relasi ke tabel Rentals (Satu mobil bisa memiliki banyak riwayat sewa)
     */
    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}