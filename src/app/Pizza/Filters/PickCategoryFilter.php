<?php

namespace App\Pizza\Filters;

use App\Pizza\Models\PizzaCategory;
use App\Shared\Filters\Filter;
use App\Shared\Filters\FilterInputType;

class PickCategoryFilter extends Filter
{
    public static string $key = 'category';

    public static function getSchemas(): array
    {
        return [
            static::schema(
                label: 'Categories',
                values: PizzaCategory::query()->pluck('title', 'slug')->all(),
                input: FilterInputType::Select,
            ),
        ];
    }

    public static function handle(array &$catalog, mixed $categorySlug): void
    {
        $catalog = array_filter($catalog, fn ($item) => $item['slug'] === $categorySlug);
    }
}
