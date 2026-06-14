<?php

namespace App\Models\PizzaIngredients;

use Illuminate\Database\Eloquent\Model;

class IngredientsPrice extends Model
{
    protected $fillable = ['ingredient_id', 'option_size_id', 'price'];
}
