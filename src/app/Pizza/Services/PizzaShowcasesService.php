<?php

namespace App\Pizza\Services;

use App\Pizza\Filters\PizzaFiltersAggregator;
use App\Pizza\Models\PizzaCategory;
use App\Pizza\Transformers\PizzaTransformer;

class PizzaShowcasesService
{
    public const string PRODUCT_TYPE = 'pizza';

    public function __construct(public PizzaFiltersAggregator $filters)
    {
    }

    public function get(array $filters = []): array
    {
        $catalog = $this->catalog();

        $this->filters->applyFilters($catalog, $filters);

        return $catalog;
    }

    public function filterSchemes(): array
    {
        return $this->filters->getSchemas();
    }

    private function catalog(): array
    {
        /* TODO: add cache
         * return Cache::remember(
         *      'pizza.catalog',
         *          now()->addHour(),
         *          fn () => $this->buildCatalog()
         * );
         */

        return $this->buildCatalog();
    }

    private function buildCatalog(): array
    {
        $categories = $this->baseQuery()->get()->toArray();

        $transformer = app(PizzaTransformer::class);

        foreach ($categories as &$category) {
            $category['products'] = array_map(
                fn ($pizza) => $transformer->transform($pizza),
                $category['products']
            );
        }

        return $categories;
    }

    private function baseQuery()
    {
        return PizzaCategory::select([
            'id',
            'title',
            'description',
            'slug',
        ])
            ->with([
                'products' => fn ($query) => $query->detailed(),
            ]);
    }
}
