<?php

namespace App\Registries\Pizza;

use App\Models\Products\Pizza\Ingredients\Ingredient;

class IngredientsRegistry
{
    public static function list(): array
    {
        return self::transformPrices(
            self::retrieveData()
        );
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
}
