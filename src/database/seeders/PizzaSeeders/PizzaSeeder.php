<?php

namespace Database\Seeders\PizzaSeeders;

use App\Pizza\Models\Pizza;
use App\Pizza\Models\PizzaVariant;
use App\Pizza\Registries\OptionsRegistry;
use Illuminate\Database\Seeder;

class PizzaSeeder extends Seeder
{
    private array $optionIDs;

    public function run(): void
    {
        $pizza = Pizza::create([
            'card_image_path' => 'storage/card/pepperony-y-tomaty.png',
            'page_image_path' => 'storage/product/pepperony-y-tomaty.png',
            'thumbnail_image_path' => 'storage/thumbnail/pepperony-y-tomaty.png',
            'title' => 'Pizza Pepperoni with tomatoes',
            'labels' => ['spicy', 'cheesy', 'vegetarian'],
        ]);

        $pizza->composition()->attach([
            1 => ['quantity' => 1],
            2 => ['quantity' => 1],
            3 => ['quantity' => 1],
            4 => ['quantity' => 1],
        ]);

        $variants = [
            'Standard size' => [
                'Dough Thick' => [
                    'Without bort' => [
                        'price' => 281,
                        'weight' => 539,
                    ],
                ],
                'Dough Thin' => [
                    'Without bort' => [
                        'price' => 281,
                        'weight' => 380,
                    ],
                    'Cheesy' => [
                        'price' => 330,
                        'weight' => 512,
                    ],
                    'Hot-Dog' => [
                        'price' => 368,
                        'weight' => 588,
                    ],
                ],
            ],
            'Large' => [
                'Dough Thick' => [
                    'Without bort' => [
                        'price' => 341,
                        'weight' => 755,
                    ],
                ],
                'Dough Thin' => [
                    'Without bort' => [
                        'price' => 341,
                        'weight' => 524,
                    ],
                    'Cheesy' => [
                        'price' => 389,
                        'weight' => 728,
                    ],
                    'Hot-Dog' => [
                        'price' => 419,
                        'weight' => 794,
                    ],
                ],
            ],
            'ExtraLarge' => [
                'Dough Thick' => [
                    'Without bort' => [
                        'price' => 395,
                        'weight' => 846,
                    ],
                ],
                'Dough Thin' => [
                    'Without bort' => [
                        'price' => 395,
                        'weight' => 597,
                    ],
                    'Cheesy' => [
                        'price' => 460,
                        'weight' => 836,
                    ],
                    'Hot-Dog' => [
                        'price' => 486,
                        'weight' => 912,
                    ],
                ],
            ],
            'XXLarge' => [
                'Dough Thin' => [
                    'Without bort' => [
                        'price' => 461,
                        'weight' => 922,
                    ],
                    'Cheesy' => [
                        'price' => 541,
                        'weight' => 1033,
                    ],
                    'Hot-Dog' => [
                        'price' => 566,
                        'weight' => 1098,
                    ],
                ],
            ],
        ];

        $this->optionIDs = app(OptionsRegistry::class)->pluck('id', 'name');

        foreach ($variants as $sizeName => $doughsData) {
            foreach ($doughsData as $doughName => $crustsData) {
                foreach ($crustsData as $crustName => $payload) {
                    PizzaVariant::create([
                        'pizza_id' => $pizza->id,

                        'option_size_id' => $this->optionIDs['sizes'][$sizeName],
                        'option_dough_id' => $this->optionIDs['doughs'][$doughName],
                        'option_crust_id' => $this->optionIDs['crusts'][$crustName],

                        'price' => $payload['price'],
                        'weight' => $payload['weight'],
                    ]);
                }
            }
        }
    }
}
