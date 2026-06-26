<?php

namespace App\Pizza\Models\Ingredients;

use App\Shared\Models\Sluggable;
use Illuminate\Database\Eloquent\Model;

class IngredientsCategory extends Model
{
    use Sluggable;

    protected $fillable = ['name', 'slug', 'exclusive', 'max_per_ingredient'];

    protected $casts = ['exclusive' => 'boolean'];
}
