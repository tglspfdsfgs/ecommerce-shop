<?php

namespace App\Models\PizzaIngredients;

use App\Models\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ingredient extends Model
{
    use Sluggable;

    protected $fillable = ['category_id', 'name', 'slug', 'image_path'];
    protected $hidden = ['category_id'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(IngredientsCategory::class);
    }

    public function prices()
    {
        return $this->hasMany(IngredientsPrice::class);
    }
}
