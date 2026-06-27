<?php

namespace App\Pizza\Rules;

class IngredientRules
{
    public const int MAX_TOTAL = 14;

    public static function toArray(): array
    {
        return [
            'max_total' => self::MAX_TOTAL,
        ];
    }
}
