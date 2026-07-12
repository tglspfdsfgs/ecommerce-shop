<?php

namespace App\Pizza\Models;

use App\Shared\Models\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PizzaCategory extends Model
{
    use Sluggable;

    protected $fillable = ['title', 'description', 'slug'];

    protected static function slugSourceField(): string
    {
        return 'title';
    }

    public function products(): HasMany
    {
        return $this->hasMany(Pizza::class);
    }
}
