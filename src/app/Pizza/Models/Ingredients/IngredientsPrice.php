<?php

namespace App\Pizza\Models\Ingredients;

use Illuminate\Database\Eloquent\Model;

class IngredientsPrice extends Model
{
    protected $fillable = ['ingredient_id', 'option_size_id', 'price'];
    protected $hidden = ['ingredient_id'];
}
