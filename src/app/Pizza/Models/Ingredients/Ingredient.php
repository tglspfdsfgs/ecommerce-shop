<?php

namespace App\Pizza\Models\Ingredients;

use App\Shared\Models\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use Sluggable;

    protected $fillable = ['category_id', 'name', 'slug', 'image_path'];
}
