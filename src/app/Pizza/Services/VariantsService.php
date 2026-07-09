<?php

namespace App\Pizza\Services;

use App\Pizza\Models\Options\OptionCrust;
use App\Pizza\Models\Options\OptionDough;
use App\Pizza\Models\Options\OptionSize;

class VariantsService
{
    /**
     * Returns a matrix of all valid pizza option combinations.
     *
     * Structure: [ size => [ dough => [ crust, crust, ... ] ] ]
     *
     * @param string $optionField Option model field to use as matrix keys (e.g. slug, id, name).
     *
     * @return array<string, array<string, list<string>>>
     */
    public static function getMatrix(string $optionField = 'slug'): array
    {
        $sizes = OptionSize::with('restrictions')->orderBy('sort_order')->get();
        $doughs = OptionDough::with('restrictions')->orderBy('sort_order')->get();
        $crusts = OptionCrust::orderBy('sort_order')->get();

        $matrix = [];

        foreach ($sizes as $size) {
            $blockedDoughIds = $size->restrictions
                ->pluck('child_id');

            foreach ($doughs as $dough) {
                if ($blockedDoughIds->contains($dough->id)) {
                    continue;
                }

                $blockedCrustIds = $dough->restrictions
                    ->pluck('child_id');

                foreach ($crusts as $crust) {
                    if ($blockedCrustIds->contains($crust->id)) {
                        continue;
                    }

                    $matrix[$size[$optionField]][$dough[$optionField]][] = $crust[$optionField];
                }
            }
        }

        return $matrix;
    }
}
