<?php

namespace App\Pizza\Filters;

use App\Pizza\Models\PizzaCategory;

class PickCategoryFilter
{
    public static string $key = 'category';

    public static function getSchemas(): array
    {
        return [[
            'label' => 'Categories',
            'filter' => self::$key,
            'values' => PizzaCategory::query()
                ->pluck('title', 'slug')
                ->all(),
            'component' => 'blocks.filter.inputs.select',
        ]];
    }

    public static function handle(array &$catalog, string $categorySlug): void
    {
        $catalog = array_filter($catalog, fn ($item) => $item['slug'] === $categorySlug);
    }
}
