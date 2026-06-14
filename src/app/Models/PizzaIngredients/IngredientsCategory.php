<?php

namespace App\Models\PizzaIngredients;

use App\Models\Sluggable;
use Illuminate\Database\Eloquent\Model;

class IngredientsCategory extends Model
{
    use Sluggable;

    protected $fillable = ['name', 'slug'];
}
