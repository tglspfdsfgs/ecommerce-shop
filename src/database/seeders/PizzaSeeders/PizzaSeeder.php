<?php

namespace Database\Seeders\PizzaSeeders;

use App\Pizza\Models\Ingredients\IngredientsCategory;
use App\Pizza\Models\Pizza;
use App\Pizza\Models\PizzaCategory;
use App\Pizza\Models\PizzaVariant;
use App\Pizza\Registries\OptionsRegistry;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class PizzaSeeder extends Seeder
{
    private array $optionIDs;
    private Collection $ingredientsCategories;

    private array $variantsExample = [
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

    public function run(): void
    {
        $this->seedCategories();

        $this->seedPizzas();
    }

    private function seedCategories()
    {
        $categories = [
            ['title' => 'Bestsellers and novelties', 'description' => 'Novelties worth tasting'],
            ['title' => 'Best price', 'description' => 'Here are the most affordable pizzas'],
            ['title' => 'Heroes', 'description' => 'Classic flavor combinations and some of the most popular pizzas are collected here.'],
            ['title' => 'Wonder', 'description' => 'Pizzas in which you can find interesting combinations of flavors, but veeery tasty. For those who are tired of classic flavors.'],
            ['title' => 'Finest', 'description' => 'Here the pizzas are the richest in terms of ingredients, and somebody says they are also the most beautiful :)'],
            ['title' => 'Gourmet', 'description' => 'Pizzas for the most demanding gourmets with outstanding whims :)'],
            ['title' => 'The taste of summer'],
        ];

        foreach ($categories as $category) {
            PizzaCategory::create($category);
        }
    }

    private function seedPizzas()
    {
        $this->ingredientsCategories = IngredientsCategory::with('ingredients:id,category_id')->get(['id', 'exclusive', 'max_per_ingredient']);

        $this->optionIDs = app(OptionsRegistry::class)->pluck('id', 'name');

        $counter = 1;

        foreach (PizzaCategory::all() as $category) {
            $pizzasInCategory = 15;

            for ($i = 1; $i <= $pizzasInCategory; ++$i) {
                $this->createPizza("Pizza #{$counter}", $category->id);
                ++$counter;
            }
        }
    }

    private function createPizza(string $title, int $categoryID): void
    {
        $pizza = Pizza::create([
            'card_image_path' => 'storage/card/pepperony-y-tomaty.png',
            'page_image_path' => 'storage/product/pepperony-y-tomaty.png',
            'thumbnail_image_path' => 'storage/thumbnail/pepperony-y-tomaty.png',
            'title' => $title,
            'labels' => ['spicy', 'cheesy', 'vegetarian'],
            'pizza_category_id' => $categoryID,
        ]);

        $pizza->composition()->attach($this->randomComposition());

        foreach ($this->variantsExample as $sizeName => $doughsData) {
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

    private function randomComposition(): array
    {
        $result = [];

        foreach ($this->ingredientsCategories as $category) {
            if ($category->ingredients->isEmpty()) {
                continue;
            }

            $ingredient = $category->ingredients->random();

            $result[$ingredient->id] = [
                'quantity' => random_int(1, $category->max_per_ingredient),
            ];
        }

        return $result;
    }
}
