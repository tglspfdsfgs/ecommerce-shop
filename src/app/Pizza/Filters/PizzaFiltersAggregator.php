<?php

namespace App\Pizza\Filters;

class PizzaFiltersAggregator
{
    private array $filters;

    public function __construct()
    {
        $this->addFilters([
            SortPriceFilter::class,
            PickCategoryFilter::class,
            IngredientsFilter::class,
        ]);
    }

    private function addFilters(array $filterClasses): void
    {
        foreach ($filterClasses as $filterClass) {
            $this->filters[$filterClass::$key] = $filterClass;
        }
    }

    public function getSchemas(): array
    {
        $schemas = [];

        foreach ($this->filters as $filter) {
            $schemas = array_merge($schemas, $filter::getSchemas());
        }

        return $schemas;
    }

    public function applyFilters(array &$catalog, array $filters): void
    {
        foreach ($filters as $filterKey => $filterValue) {
            $this->filters[$filterKey]::handle($catalog, $filterValue);
        }
    }
}
