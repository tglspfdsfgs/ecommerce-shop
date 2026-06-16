<?php

namespace App\Services;

use App\Models\Products\Pizza;

class PizzaService
{
    public function getBySlug(string $slug): array
    {
        $pizza = Pizza::where('slug', $slug)
            ->detailed()
            ->firstOrFail();

        $pizza->setRelation(
            'composition',
            $pizza->composition->map(fn ($i) => [
                'id' => $i->id,
                'name' => $i->name,
                'slug' => $i->slug,
                'quantity' => $i->pivot->quantity,
            ])->values()
        );

        return $pizza->toArray();
    }
}
