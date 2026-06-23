<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'model',
        'year',
        'price',
        'mileage',
        'fuel_type',
        'transmission',
        'color',
        'description',
        'images',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'price' => 'integer',
        'mileage' => 'integer',
        'year' => 'integer',
        'images' => 'array',
    ];
}
