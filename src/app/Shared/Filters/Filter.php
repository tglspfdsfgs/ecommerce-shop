<?php

namespace App\Shared\Filters;

abstract class Filter
{
    public static string $key;

    abstract public static function getSchemas(): array;

    abstract public static function handle(array &$catalog, mixed $value): void;

    protected static function schema(
        string $label,
        array $values,
        FilterInputType $input,
    ): array {
        return [
            'filter' => static::$key,
            'label' => $label,
            'values' => $values,
            'input' => $input,
        ];
    }
}
