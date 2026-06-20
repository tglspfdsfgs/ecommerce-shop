<?php

namespace App\Models\Products\Pizza\Ingredients;

use App\Models\Sluggable;
use Illuminate\Database\Eloquent\Model;

class IngredientsCategory extends Model
{
    use Sluggable;

    protected $fillable = ['name', 'slug'];
}
