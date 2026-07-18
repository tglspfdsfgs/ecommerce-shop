<?php

namespace App\Shared\Filters;

class FiltersAggregator
{
    private array $filters;

    /**
     * @param array<class-string<Filter>> $filterClasses
     */
    public function __construct(array $filterClasses)
    {
        foreach ($filterClasses as $filterClass) {
            if (! is_subclass_of($filterClass, Filter::class)) {
                throw new \TypeError("Filter class $filterClass must implement ".Filter::class);
            }
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
            if (! isset($this->filters[$filterKey])) {
                continue;
            }
            $this->filters[$filterKey]::handle($catalog, $filterValue);
        }
    }
}
