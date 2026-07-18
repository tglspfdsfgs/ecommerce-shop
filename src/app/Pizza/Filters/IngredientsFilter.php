<?php

namespace App\Pizza\Filters;

use App\Pizza\Registries\IngredientsRegistry;
use App\Shared\Filters\Filter;
use App\Shared\Filters\FilterInputType;

class IngredientsFilter extends Filter
{
    public static string $key = 'ingredients';

    public static function getSchemas(): array
    {
        $groupedIngredients = app(IngredientsRegistry::class)->grouped();

        $schemas = [];

        foreach ($groupedIngredients as $category) {
            $schemas[] = static::schema(
                label: $category['name'],
                values: array_column($category['ingredients'], 'name', 'slug'),
                input: FilterInputType::MultiSelect,
            );
        }

        return $schemas;
    }

    public static function handle(array &$catalog, mixed $selectedIngredients): void
    {
        if (empty($selectedIngredients)) {
            return;
        }

        foreach ($catalog as &$category) {
            $category['products'] = array_filter(
                $category['products'],
                function ($product) use ($selectedIngredients) {
                    return empty(
                        array_diff(
                            $selectedIngredients,
                            array_keys($product['composition'])
                        )
                    );
                }
            );
        }

        $catalog = array_filter(
            $catalog,
            fn ($category) => ! empty($category['products'])
        );
    }
}
