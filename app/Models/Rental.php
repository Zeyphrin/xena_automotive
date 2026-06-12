<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $fillable = [
    'car_id', 'user_id', 'full_name', 'email', 'phone',
    'pickup_date', 'return_date', 'status'
];

public function car() {
    return $this->belongsTo(Car::class);
}

}
