<?php

namespace App\Pizza\Registries;

use App\Pizza\Models\Ingredients\Ingredient;

class IngredientsRegistry
{
    public static function list(): array
    {
        return self::retrieveData()
                |> self::transformPrices(...)
                |> self::generateImageURLs(...);
    }

    public static function bySlug(): array
    {
        return array_column(
            self::list(),
            null,
            'slug'
        );
    }

    public static function grouped(): array
    {
        $result = [];

        foreach (self::bySlug() as $slug => $ingredient) {
            $categorySlug = $ingredient['category']['slug'];

            if (! isset($result[$categorySlug])) {
                $result[$categorySlug] = [
                    'id' => $ingredient['category']['id'],
                    'name' => $ingredient['category']['name'],
                    'slug' => $categorySlug,
                    'ingredients' => [],
                ];
            }
            unset($ingredient['category']);

            $result[$categorySlug]['ingredients'][$slug] = $ingredient;
        }

        return $result;
    }

    private static function retrieveData(): array
    {
        return Ingredient::select([
            'id',
            'name',
            'slug',
            'image_path',
            'category_id',
        ])
            ->with([
                'category:id,name,slug',
                'prices:ingredient_id,option_size_id,price',
            ])->get()->toArray();
    }

    private static function transformPrices(array $ingredients): array
    {
        $sizes = OptionsRegistry::pluck('slug', 'id')['sizes'];

        foreach ($ingredients as &$ingredient) {
            $prices = [];

            foreach ($ingredient['prices'] as $price) {
                $prices[$sizes[$price['option_size_id']]] = $price['price'];
            }

            $ingredient['prices'] = $prices;
        }

        return $ingredients;
    }

    private static function generateImageURLs(array $ingredients): array
    {
        foreach ($ingredients as &$ingredient) {
            $ingredient['image_url'] = asset($ingredient['image_path']);
            unset($ingredient['image_path']);
        }

        return $ingredients;
    }
}
