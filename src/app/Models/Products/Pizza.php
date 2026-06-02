<?php

namespace App\Models\Products;

use App\Models\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    use Sluggable;

    protected $fillable = ['slug', 'card_image_path', 'page_image_path', 'thumbnail_image_path', 'composition', 'labels', 'values'];

    protected $casts = [
        'composition' => 'array',
        'labels' => 'array',
        'values' => 'array',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function slugSourceField(): string
    {
        return 'title';
    }
}
