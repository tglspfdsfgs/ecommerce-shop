<?php

namespace App\Registries;

use App\Models\PizzaOptions\OptionCrust;
use App\Models\PizzaOptions\OptionDough;
use App\Models\PizzaOptions\OptionSize;

class PizzaOptionsRegistry
{
    public static function list(): array
    {
        return [
            'sizes' => OptionSize::orderBy('sort_order')->get(['id', 'name', 'slug'])->toArray(),
            'doughs' => OptionDough::orderBy('sort_order')->get(['id', 'name', 'slug'])->toArray(),
            'crusts' => OptionCrust::orderBy('sort_order')->get(['id', 'name', 'slug'])->toArray(),
        ];
    }

    public static function pluck(string $value, string $key): array
    {
        return array_map(
            fn ($items) => array_column($items, $value, $key),
            self::list()
        );
    }
}
