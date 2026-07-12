<?php

namespace App\Pizza\Transformers;

use App\Pizza\Registries\OptionsRegistry;

readonly class PizzaTransformer
{
    public function __construct(
        private OptionsRegistry $optionsRegistry,
    ) {
    }

    public function transform(array $pizza): array
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
