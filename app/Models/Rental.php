<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    // Daftar kolom yang diizinkan untuk diisi secara massal
    protected $fillable = [
        'user_id',
        'car_id',
        'start_date',
        'end_date',
        'actual_return_date',
        'total_price',
        'fine_amount',
        'status',
    ];

    /**
     * Relasi ke tabel Users (Untuk memanggil nama Penyewa/Klien)
     * Inilah fungsi yang dicari oleh sistem dan menyebabkan error "undefined relationship [user]"
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke tabel Cars (Untuk memanggil merk dan plat nomor Mobil)
     */
    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }
}