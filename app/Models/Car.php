<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
    'name', 'brand', 'year', 'type', 'engine', 'transmission',
    'fuel_type', 'seats', 'mileage', 'color', 'features',
    'price_per_day', 'image_url', 'available', 'featured', 'description'
];
}
