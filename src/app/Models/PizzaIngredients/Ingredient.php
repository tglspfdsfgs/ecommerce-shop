<?php

namespace App\Models\PizzaIngredients;

use App\Models\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use Sluggable;

    protected $fillable = ['category_id', 'name', 'slug'];
}
