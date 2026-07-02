<?php

namespace App\Pizza\Models\Ingredients;

use Illuminate\Database\Eloquent\Model;

class IngredientCategoryPrices extends Model
{
    protected $fillable = ['category_id', 'size_id', 'price'];
}
