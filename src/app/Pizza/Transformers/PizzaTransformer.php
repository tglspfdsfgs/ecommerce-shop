<?php

namespace App\Pizza\Transformers;

use App\Pizza\Registries\OptionsRegistry;

readonly class PizzaTransformer
{
    public function __construct(
        private OptionsRegistry $optionsRegistry,
    ) {
    }

    /**
     * @return array{
     *     id:int,
     *     title:string,
     *     slug:string,
     *     card_image_url:string,
     *     page_image_url:string,
     *     thumbnail_image_url:string,
     *     labels:list<string>,
     *     pizza_category_id:int,
     *     composition:array<string,int>,
     *     variants:array<string,mixed>,
     *     defaults:array{
     *         size:string,
     *         dough:string,
     *         crust:string,
     *         price:int,
     *         weight:int
     *     }
     * }
     */
    public function transform(array $pizza): array
    {
        $this->transformImageURLs($pizza);

        $this->transformComposition($pizza);

        $this->transformVariants($pizza);

        $this->appendDefaults($pizza);

        return $pizza;
    }

    private function transformImageURLs(array &$pizza): void
    {
        $pizza['page_image_url'] = asset($pizza['page_image_path']);
        $pizza['card_image_url'] = asset($pizza['card_image_path']);
        $pizza['thumbnail_image_url'] = asset($pizza['thumbnail_image_path']);

        unset($pizza['page_image_path'], $pizza['card_image_path'], $pizza['thumbnail_image_path']);
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
