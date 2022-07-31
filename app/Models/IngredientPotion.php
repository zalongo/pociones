<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientPotion extends Model
{
    use HasFactory;

    protected $fillable = [
            'potion_id',
            'ingredient_id',
            'quantity',
        ];
}