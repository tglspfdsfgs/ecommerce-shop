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

    protected $fillable = ['slug', 'card_image_path', 'page_image_path', 'thumbnail_image_path', 'labels'];

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

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function slugSourceField(): string
    {
        return 'title';
    }
}
