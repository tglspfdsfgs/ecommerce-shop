<?php

namespace App\Registries\Pizza;

use App\Models\Products\Pizza\Options\OptionCrust;
use App\Models\Products\Pizza\Options\OptionDough;
use App\Models\Products\Pizza\Options\OptionSize;

class OptionsRegistry
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
