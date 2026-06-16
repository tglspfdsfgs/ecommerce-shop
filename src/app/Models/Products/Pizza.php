<?php

namespace App\Models\Products;

use App\Models\PizzaIngredients\Ingredient;
use App\Models\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pizza extends Model
{
    use Sluggable;

    protected $fillable = ['slug', 'card_image_path', 'page_image_path', 'thumbnail_image_path', 'labels', 'values'];

    protected $casts = [
        'labels' => 'array',
        'values' => 'array',
    ];

    public function scopeDetailed($query)
    {
        return $query
            ->select([
                'id',
                'title',
                'slug',
                'card_image_path',
                'page_image_path',
                'thumbnail_image_path',
                'labels',
                'values',
            ])
            ->with([
                'composition:id,name,slug',
            ]);
    }

    public function composition(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'compositions')
            ->withPivot('quantity');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function slugSourceField(): string
    {
        return 'title';
    }
}
