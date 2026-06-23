<?php

namespace App\Shared\Models;

use Illuminate\Support\Str;

trait Sluggable
{
    protected static function bootSluggable(): void
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = static::generateUniqueSlug(
                    $model->{static::slugSourceField()}
                );
            }
        });

        static::updating(function ($model) {
            $field = static::slugSourceField();

            if ($model->isDirty($field)) {
                $model->slug = static::generateUniqueSlug(
                    $model->{$field}
                );
            }
        });
    }

    protected static function slugSourceField(): string
    {
        return 'name';
    }

    protected static function generateUniqueSlug(string $value): string
    {
        $slug = Str::slug($value);
        $original = $slug;
        $i = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $original.'-'.$i++;
        }

        return $slug;
    }
}
