<?php

namespace App\Pizza\Registries;

use App\Pizza\Models\Ingredients\IngredientsCategory;
use Illuminate\Container\Attributes\Singleton;

#[Singleton]
class IngredientsRegistry
{
    public function grouped(): array
    {
        return $this->retrieveData()
            |> $this->slugifyKeys(...)
            |> $this->transformIngredients(...)
            |> $this->transformPrices(...);
    }

    public function list(): array
    {
        $result = [];

        foreach ($this->grouped() as $categoryData) {
            $ingredients = $categoryData['ingredients'];

            unset($categoryData['ingredients']);
            unset($categoryData['prices']);

            foreach ($ingredients as $ingredientSlug => $ingredientData) {
                $ingredientData['category'] = $categoryData;
                $result[$ingredientSlug] = $ingredientData;
            }
        }

        return $result;
    }

    private function retrieveData()
    {
        return IngredientsCategory::select(['id', 'name', 'slug', 'max_per_ingredient', 'exclusive'])
            ->with([
                'ingredients:category_id,id,name,slug,image_path',
                'prices:category_id,id,size_id,price',
            ])
            ->get()->toArray();
    }

    private function transformIngredients(array $list): array
    {
        foreach ($list as $categorySlug => $categoryData) {
            $list[$categorySlug]['ingredients'] = $this->slugifyKeys($categoryData['ingredients']);

            foreach ($list[$categorySlug]['ingredients'] as $ingredientSlug => $ingredientData) {
                $ingredientData['image_url'] = asset($ingredientData['image_path']);
                unset($ingredientData['image_path']);

                unset($ingredientData['category_id']);

                $list[$categorySlug]['ingredients'][$ingredientSlug] = $ingredientData;
            }
        }

        return $list;
    }

    private function transformPrices(array $list): array
    {
        $sizes = app(OptionsRegistry::class)->pluck('slug', 'id')['sizes'];

        foreach ($list as $categorySlug => $categoryData) {
            $transformedPrices = [];

            foreach ($categoryData['prices'] as $priceData) {
                $sizeSlug = $sizes[$priceData['size_id']];

                $transformedPrices[$sizeSlug] = $priceData['price'];
            }

            $list[$categorySlug]['prices'] = $transformedPrices;
        }

        return $list;
    }

    private function slugifyKeys(array $list): array
    {
        return array_column($list, null, 'slug');
    }
}
