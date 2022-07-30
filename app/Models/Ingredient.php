<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
    ];

    protected $appends = ['criticalStock'];

    public function getCriticalStockAttribute()
    {
        return $this->stock <= 10;
    }
}