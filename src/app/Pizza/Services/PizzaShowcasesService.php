<?php

namespace App\Pizza\Services;

use App\Pizza\Filters\IngredientsFilter;
use App\Pizza\Filters\PickCategoryFilter;
use App\Pizza\Filters\SortPriceFilter;
use App\Pizza\Models\PizzaCategory;
use App\Pizza\Transformers\PizzaTransformer;
use App\Shared\Filters\FiltersAggregator;

class PizzaShowcasesService
{
    public const string PRODUCT_TYPE = 'pizza';

    private FiltersAggregator $filters;

    public function __construct()
    {
        $this->filters = new FiltersAggregator(
            [
                SortPriceFilter::class,
                PickCategoryFilter::class,
                IngredientsFilter::class,
            ]);
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
