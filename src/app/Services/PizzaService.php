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
            ->firstOrFail();

        return $this->transform($pizza)->toArray();
    }

    public function getAll(): array
    {
        return $this->baseQuery()
            ->get()
            ->map(fn ($pizza) => $this->transform($pizza))
            ->toArray();
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

    private function transform(Pizza $pizza): Pizza
    {
        $this->transformComposition($pizza);

        $this->transformVariants($pizza);

        $this->appendDefaults($pizza);

        return $pizza;
    }

    private function transformComposition(Pizza $pizza): void
    {
        $pizza->setRelation(
            'composition',
            $pizza->composition->map(fn ($i) => [
                'id' => $i->id,
                'name' => $i->name,
                'slug' => $i->slug,
                'quantity' => $i->pivot->quantity,
            ])->values()
        );
    }

    public function transformVariants(Pizza $pizza): void
    {
        $pizza->setRelation(
            'variants',
            $pizza->variants
                ->groupBy(fn ($v) => $this->optionSlugs['sizes'][$v->option_size_id])
                ->map(fn ($sizeGroup) => $sizeGroup
                    ->groupBy(fn ($v) => $this->optionSlugs['doughs'][$v->option_dough_id])
                    ->map(fn ($doughGroup) => $doughGroup
                        ->mapWithKeys(fn ($v) => [
                            $this->optionSlugs['crusts'][$v->option_crust_id] => [
                                'price' => $v->price,
                                'weight' => $v->weight,
                            ],
                        ])
                    )
                )
        );
    }

    private function appendDefaults(Pizza $pizza): void
    {
        $variants = $pizza->variants;

        $size = $this->firstAvailableOption($this->orderedOptions['sizes'], $variants);

        $dough = $this->firstAvailableOption($this->orderedOptions['doughs'], $variants[$size]);

        $crust = $this->firstAvailableOption($this->orderedOptions['crusts'], $variants[$size][$dough]);

        $pizza->setAttribute('defaults', [
            'size' => $size,
            'dough' => $dough,
            'crust' => $crust,
            'price' => $variants[$size][$dough][$crust]['price'],
            'weight' => $variants[$size][$dough][$crust]['weight'],
        ]);
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
