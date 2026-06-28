<?php

namespace App\Pizza\Registries;

use App\Pizza\Models\Options\OptionCrust;
use App\Pizza\Models\Options\OptionDough;
use App\Pizza\Models\Options\OptionSize;
use Illuminate\Container\Attributes\Singleton;

#[Singleton]
class OptionsRegistry
{
    private array $cache = [];

    public function list(): array
    {
        return $this->cache['list'] ??= $this->generateList();
    }

    public function pluck(string $value, string $key): array
    {
        return $this->cache['pluck'.$value.$key] ??= array_map(
            fn ($items) => array_column($items, $value, $key),
            $this->list()
        );
    }

    public function only(string $field): array
    {
        return $this->cache['only'.$field] ??= array_map(
            fn (array $items) => array_column($items, $field),
            $this->list()
        );
    }

    private function generateList(): array
    {
        return [
            'sizes' => OptionSize::orderBy('sort_order')->get(['id', 'name', 'slug'])->toArray(),
            'doughs' => OptionDough::orderBy('sort_order')->get(['id', 'name', 'slug'])->toArray(),
            'crusts' => OptionCrust::orderBy('sort_order')->get(['id', 'name', 'slug'])->toArray(),
        ];
    }
}
