<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'symbol', 'price', 'change', 'market_cap', 'updated_at'];
}
