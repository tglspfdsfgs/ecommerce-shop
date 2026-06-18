<?php

namespace App\Registries;

use App\Models\PizzaIngredients\Ingredient;

class PizzaIngredientsRegistry
{
    public static function getAll(): array
    {
        return self::transformPrices(
            self::baseQuery()
        );
    }

    private static function transformPrices(array $ingredients): array
    {
        $sizes = PizzaOptionsRegistry::pluck('slug', 'id')['sizes'];

        foreach ($ingredients as &$ingredient) {
            $prices = [];

            foreach ($ingredient['prices'] as $price) {
                $prices[$sizes[$price['option_size_id']]] = $price['price'];
            }

            $ingredient['prices'] = $prices;
        }

        return $ingredients;
    }

    private static function baseQuery()
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
}
