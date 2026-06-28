<?php

namespace App\Pizza\Registries;

use App\Pizza\Models\Ingredients\Ingredient;
use Illuminate\Container\Attributes\Singleton;

#[Singleton]
class IngredientsRegistry
{
    private array $cache = [];

    public function list(): array
    {
        return $this->cache['list'] ??= $this->generateList();
    }

    public function bySlug(): array
    {
        return $this->cache['bySlug'] ??= array_column(
            $this->list(),
            null,
            'slug'
        );
    }

    public function grouped(): array
    {
        if (isset($this->cache['grouped'])) {
            return $this->cache['grouped'];
        }

        $result = [];

        foreach ($this->bySlug() as $slug => $ingredient) {
            $categorySlug = $ingredient['category']['slug'];

            if (! isset($result[$categorySlug])) {
                $result[$categorySlug] = [
                    'id' => $ingredient['category']['id'],
                    'name' => $ingredient['category']['name'],
                    'slug' => $categorySlug,
                    'exclusive' => $ingredient['category']['exclusive'],
                    'max_per_ingredient' => $ingredient['category']['max_per_ingredient'],
                    'ingredients' => [],
                ];
            }
            unset($ingredient['category']);

            $result[$categorySlug]['ingredients'][$slug] = $ingredient;
        }

        return $this->cache['grouped'] = $result;
    }

    private function generateList(): array
    {
        return $this->retrieveData()
                |> $this->transformPrices(...)
                |> $this->generateImageURLs(...);
    }

    private function retrieveData(): array
    {
        return Ingredient::select([
            'id',
            'name',
            'slug',
            'image_path',
            'category_id',
        ])
            ->with([
                'category:id,name,slug,exclusive,max_per_ingredient',
                'prices:ingredient_id,option_size_id,price',
            ])->get()->toArray();
    }

    private function transformPrices(array $ingredients): array
    {
        $optionsRegistry = app(OptionsRegistry::class);

        $sizes = $optionsRegistry->pluck('slug', 'id')['sizes'];

        foreach ($ingredients as &$ingredient) {
            $prices = [];

            foreach ($ingredient['prices'] as $price) {
                $prices[$sizes[$price['option_size_id']]] = $price['price'];
            }

            $ingredient['prices'] = $prices;
        }

        return $ingredients;
    }

    private function generateImageURLs(array $ingredients): array
    {
        foreach ($ingredients as &$ingredient) {
            $ingredient['image_url'] = asset($ingredient['image_path']);
            unset($ingredient['image_path']);
        }

        return $ingredients;
    }
}
