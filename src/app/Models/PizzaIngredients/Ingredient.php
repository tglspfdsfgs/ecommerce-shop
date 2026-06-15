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

    public function scopeDetailed($query)
    {
        return $query
            ->select([
                'id',
                'name',
                'slug',
                'image_path',
                'category_id',
            ])
            ->with([
                'category:id,name,slug',
                'prices:ingredient_id,option_size_id,price',
            ]);
    }
}
