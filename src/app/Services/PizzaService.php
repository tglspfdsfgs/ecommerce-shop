<?php

namespace App\Services;

use App\Models\Products\Pizza;
use App\Registries\PizzaOptionsRegistry;

class PizzaService
{
    private array $optionSlugs;
    private array $orderedOptions;

    public function __construct()
    {
        $this->optionSlugs = PizzaOptionsRegistry::pluck('slug', 'id');
        $this->orderedOptions = PizzaOptionsRegistry::list();
    }

    public function getBySlug(string $slug): array
    {
        $pizza = $this->baseQuery()
            ->where('slug', $slug)
            ->firstOrFail()
            ->toArray();

        return $this->transform($pizza);
    }

    public function getAll(): array
    {
        $pizzas = $this->baseQuery()->get()->toArray();

        return array_map(
            fn ($pizza) => $this->transform($pizza),
            $pizzas
        );
    }

    private function baseQuery()
    {
        return Pizza::select([
            'id',
            'title',
            'slug',
            'card_image_path',
            'page_image_path',
            'thumbnail_image_path',
            'labels',
        ])
            ->with([
                'composition:id,name,slug',
                'variants:pizza_id,option_size_id,option_dough_id,option_crust_id,price,weight',
            ]);
    }

    private function transform(array &$pizza): array
    {
        $this->transformComposition($pizza);

        $this->transformVariants($pizza);

        $this->appendDefaults($pizza);

        return $pizza;
    }

    private function transformComposition(array &$pizza): void
    {
        $composition = [];

        foreach ($pizza['composition'] as $ingredient) {
            $composition[] = [
                'id' => $ingredient['id'],
                'name' => $ingredient['name'],
                'slug' => $ingredient['slug'],
                'quantity' => $ingredient['pivot']['quantity'],
            ];
        }

        $pizza['composition'] = $composition;
    }

    private function transformVariants(array &$pizza): void
    {
        $variants = [];

        foreach ($pizza['variants'] as $variant) {
            $size = $this->optionSlugs['sizes'][$variant['option_size_id']];
            $dough = $this->optionSlugs['doughs'][$variant['option_dough_id']];
            $crust = $this->optionSlugs['crusts'][$variant['option_crust_id']];

            $variants[$size][$dough][$crust] = [
                'price' => $variant['price'],
                'weight' => $variant['weight'],
            ];
        }

        $pizza['variants'] = $variants;
    }

    private function appendDefaults(array &$pizza): void
    {
        $variants = $pizza['variants'];

        $size = $this->firstAvailableOption($this->orderedOptions['sizes'], $variants);

        $dough = $this->firstAvailableOption($this->orderedOptions['doughs'], $variants[$size]);

        $crust = $this->firstAvailableOption($this->orderedOptions['crusts'], $variants[$size][$dough]);

        $pizza['defaults'] = [
            'size' => $size,
            'dough' => $dough,
            'crust' => $crust,
            'price' => $variants[$size][$dough][$crust]['price'],
            'weight' => $variants[$size][$dough][$crust]['weight'],
        ];
    }

    private function firstAvailableOption(array $ordered, $data): string
    {
        foreach ($ordered as $option) {
            if (isset($data[$option['slug']])) {
                return $option['slug'];
            }
        }

        throw new \RuntimeException('No available option');
    }
}
