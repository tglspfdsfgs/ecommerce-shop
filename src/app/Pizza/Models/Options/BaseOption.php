<?php

namespace App\Pizza\Models\Options;

trait BaseOption
{
    protected $fillable = ['name', 'slug', 'sort_order'];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (null === $model->sort_order) {
                $model->sort_order =
                    (static::max('sort_order') ?? 0) + 1;
            }
        });
    }
}
