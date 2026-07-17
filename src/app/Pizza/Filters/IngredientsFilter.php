<?php

namespace App\Pizza\Filters;

use App\Pizza\Registries\IngredientsRegistry;

class IngredientsFilter
{
    public static string $key = 'ingredients';

    public static function getSchemas(): array
    {
        $groupedIngredients = app(IngredientsRegistry::class)->grouped();

        $schemas = [];

        foreach ($groupedIngredients as $category) {
            $schemas[] = [
                'filter' => self::$key,
                'label' => $category['name'],
                'values' => array_column(
                    $category['ingredients'],
                    'name',
                    'slug'
                ),
                'component' => 'blocks.filter.inputs.multiselect',
            ];
        }

        return $schemas;
    }

    public static function handle(array &$catalog, array $selectedIngredients): void
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
