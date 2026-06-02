<?php

namespace Database\Seeders;

use App\Models\Products\Pizza;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Pizza::create([
            'card_image_path' => 'storage/card/pepperony-y-tomaty.png',
            'page_image_path' => 'storage/product/pepperony-y-tomaty.png',
            'thumbnail_image_path' => 'storage/thumbnail/pepperony-y-tomaty.png',
            'title' => 'Pizza Pepperoni with tomatoes',
            'composition' => [
                [
                    'ingredient_id' => 1,
                    'quantity' => 1,
                ],
                [
                    'ingredient_id' => 2,
                    'quantity' => 1,
                ],
                [
                    'ingredient_id' => 3,
                    'quantity' => 1,
                ],
                [
                    'ingredient_id' => 4,
                    'quantity' => 1,
                ],
            ],
            'labels' => ['spicy', 'cheesy', 'vegetarian'],
            'values' => [
                'standard-size' => [
                    'dough-thick' => [
                        'without-bort' => [
                            'price' => 281,
                            'weight' => 539,
                        ],
                    ],
                    'dough-thin' => [
                        'without-bort' => [
                            'price' => 281,
                            'weight' => 380,
                        ],
                        'cheesy' => [
                            'price' => 330,
                            'weight' => 512,
                        ],
                        'hot-dog' => [
                            'price' => 368,
                            'weight' => 588,
                        ],
                    ],
                ],
                'large' => [
                    'dough-thick' => [
                        'without-bort' => [
                            'price' => 341,
                            'weight' => 755,
                        ],
                    ],
                    'dough-thin' => [
                        'without-bort' => [
                            'price' => 341,
                            'weight' => 524,
                        ],
                        'cheesy' => [
                            'price' => 389,
                            'weight' => 728,
                        ],
                        'hot-dog' => [
                            'price' => 419,
                            'weight' => 794,
                        ],
                    ],
                ],
                'extralarge' => [
                    'dough-thick' => [
                        'without-bort' => [
                            'price' => 395,
                            'weight' => 846,
                        ],
                    ],
                    'dough-thin' => [
                        'without-bort' => [
                            'price' => 395,
                            'weight' => 597,
                        ],
                        'cheesy' => [
                            'price' => 460,
                            'weight' => 836,
                        ],
                        'hot-dog' => [
                            'price' => 486,
                            'weight' => 912,
                        ],
                    ],
                ],
                'xxlarge' => [
                    'dough-thin' => [
                        'without-bort' => [
                            'price' => 461,
                            'weight' => 922,
                        ],
                        'cheesy' => [
                            'price' => 541,
                            'weight' => 1033,
                        ],
                        'hot-dog' => [
                            'price' => 566,
                            'weight' => 1098,
                        ],
                    ],
                ],
            ],
        ]);
    }
}
