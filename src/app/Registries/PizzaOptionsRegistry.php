<?php

namespace App\Registries;

use App\Models\PizzaOptions\OptionCrust;
use App\Models\PizzaOptions\OptionDough;
use App\Models\PizzaOptions\OptionSize;

class PizzaOptionsRegistry
{
    public static function all(): array
    {
        return [
            'sizes' => OptionSize::orderBy('sort_order')->get(['id', 'name', 'slug'])->toArray(),
            'doughs' => OptionDough::orderBy('sort_order')->get(['id', 'name', 'slug'])->toArray(),
            'crusts' => OptionCrust::orderBy('sort_order')->get(['id', 'name', 'slug'])->toArray(),
        ];
    }

    public static function pluck(string $value, string $key): array
    {
        $data = self::all();

        return collect($data)->map(function ($items) use ($key, $value) {
            return collect($items)
                ->pluck($value, $key)
                ->toArray();
        })->toArray();
    }
}
