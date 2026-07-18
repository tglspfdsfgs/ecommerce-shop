<?php

namespace App\Pizza\Filters;

use App\Shared\Filters\Filter;
use App\Shared\Filters\FilterInputType;

class SortPriceFilter extends Filter
{
    public static string $key = 'price-sort';

    public static function getSchemas(): array
    {
        return [
            static::schema(
                label: 'Sort',
                values: ['DESC' => 'Price high-low', 'ASC' => 'Price low-high'],
                input: FilterInputType::Select,
            ),
        ];
    }

    public static function handle(array &$catalog, mixed $order): void
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
