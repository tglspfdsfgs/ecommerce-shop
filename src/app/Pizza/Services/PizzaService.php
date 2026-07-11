<?php

namespace App\Pizza\Services;

use App\Pizza\Models\Pizza;
use App\Pizza\Registries\OptionsRegistry;

class PizzaService
{
    public const string PRODUCT_TYPE = 'pizza';

    private ?OptionsRegistry $optionsRegistry;

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

    public function showcases(): array
    {
        $pizzas = $this->getAll();

        $result = [];

        foreach ($pizzas as $pizza) {
            $category = $pizza['category'];

            $slug = $category['slug'];

            if (! isset($result[$slug])) {
                $result[$slug] = [
                    'id' => $category['id'],
                    'title' => $category['title'],
                    'slug' => $category['slug'],
                    'description' => $category['description'],
                    'products' => [],
                ];
            }

            $result[$slug]['products'][] = $pizza;
        }

        return $result;
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
            'pizza_category_id',
        ])
            ->with([
                'category:id,title,description,slug',
                'composition:id,slug',
                'variants:pizza_id,option_size_id,option_dough_id,option_crust_id,price,weight',
            ]);
    }

    private function transform(array &$pizza): array
    {
        $this->optionsRegistry = app(OptionsRegistry::class);

        $this->transformComposition($pizza);

        $this->transformVariants($pizza);

        $this->appendDefaults($pizza);

        return $pizza;
    }

    private function transformComposition(array &$pizza): void
    {
        $composition = [];

        foreach ($pizza['composition'] as $ingredient) {
            $composition[$ingredient['slug']] = $ingredient['pivot']['quantity'];
        }

        $pizza['composition'] = $composition;
    }

    private function transformVariants(array &$pizza): void
    {
        $variants = [];

        $optionSlugs = $this->optionsRegistry->pluck('slug', 'id');

        foreach ($pizza['variants'] as $variant) {
            $size = $optionSlugs['sizes'][$variant['option_size_id']];
            $dough = $optionSlugs['doughs'][$variant['option_dough_id']];
            $crust = $optionSlugs['crusts'][$variant['option_crust_id']];

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

        $orderedOptions = $this->optionsRegistry->list();

        $size = $this->firstAvailableOption($orderedOptions['sizes'], $variants);

        $dough = $this->firstAvailableOption($orderedOptions['doughs'], $variants[$size]);

        $crust = $this->firstAvailableOption($orderedOptions['crusts'], $variants[$size][$dough]);

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
