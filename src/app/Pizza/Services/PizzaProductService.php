<?php

namespace App\Pizza\Services;

use App\Pizza\Models\Pizza;
use App\Pizza\Transformers\PizzaTransformer;

class PizzaProductService
{
    public function getBySlug(string $slug): array
    {
        /* TODO: add cache
         * return Cache::remember(
         *      "pizza.$slug",
         *          now()->addHour(),
         *          fn () => $this->buildPizza($slug)
         * );
         */

        return $this->buildProduct($slug);
    }

    private function buildProduct(string $slug): array
    {
        $transformer = app(PizzaTransformer::class);

        $pizza = $this->baseQuery()
            ->whereSlug($slug)
            ->firstOrFail()
            ->toArray();

        return $transformer->transform($pizza);
    }

    private function baseQuery()
    {
        return Pizza::query()->detailed();
    }
}
