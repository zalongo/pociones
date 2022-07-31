<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Potion extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];


    /**
     * The ingredients that belong to the Potion
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'ingredient_potions')->withPivot('quantity')->where('active', 1);
    }
}