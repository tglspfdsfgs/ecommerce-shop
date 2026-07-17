<?php

namespace App\Pizza\Filters;

class SortPriceFilter
{
    public static string $key = 'price-sort';

    public static function getSchemas(): array
    {
        return [[
            'label' => 'Sort',
            'filter' => self::$key,
            'values' => ['DESC' => 'Price high-low', 'ASC' => 'Price low-high'],
            'component' => 'blocks.filter.inputs.select',
        ]];
    }

    public static function handle(array &$catalog, string $order): void
    {
        $direction = 'ASC' === $order ? 1 : -1;

        foreach ($catalog as &$category) {
            usort(
                $category['products'],
                static fn (array $a, array $b): int => ($a['defaults']['price'] <=> $b['defaults']['price']) * $direction
            );
        }
    }
}
