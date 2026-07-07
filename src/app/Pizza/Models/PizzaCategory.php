<?php

namespace App\Pizza\Models;

use App\Shared\Models\Sluggable;
use Illuminate\Database\Eloquent\Model;

class PizzaCategory extends Model
{
    use Sluggable;

    protected $fillable = ['title', 'description', 'slug'];

    protected static function slugSourceField(): string
    {
        return 'title';
    }
}
