<?php

namespace App\Pizza\Models;

use App\Pizza\Models\Ingredients\Ingredient;
use App\Shared\Models\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pizza extends Model
{
    use Sluggable;

    protected $fillable = ['slug', 'card_image_path', 'page_image_path', 'thumbnail_image_path', 'labels', 'pizza_category_id'];

    protected $casts = [
        'labels' => 'array',
    ];

    public function composition(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, PizzaComposition::class)
            ->withPivot('quantity');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(PizzaVariant::class);
    }

    public function category()
    {
        return $this->belongsTo(PizzaCategory::class, 'pizza_category_id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function slugSourceField(): string
    {
        return 'title';
    }

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
                'pizza_category_id',
            ])
            ->with([
                'composition:id,slug',
                'variants:pizza_id,option_size_id,option_dough_id,option_crust_id,price,weight',
            ]);
    }
}
