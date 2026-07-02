<?php

namespace App\Pizza\Rules;

class IngredientRules
{
    public const int MAX_TOTAL = 14;

    public const int FREE_CATEGORY_REPLACEMENT = 2;

    public static function toArray(): array
    {
        return [
            'max_total' => self::MAX_TOTAL,
            'free_category_replacement' => self::FREE_CATEGORY_REPLACEMENT,
        ];
    }
}
