<?php

namespace Database\Seeders\PizzaSeeders;

use App\Pizza\Models\Ingredients\IngredientsCategory;
use App\Pizza\Models\Pizza;
use App\Pizza\Models\PizzaCategory;
use App\Pizza\Models\PizzaVariant;
use App\Pizza\Services\VariantsService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class PizzaSeeder extends Seeder
{
    private Collection $ingredientsCategories;

    private array $variants;

    public function run(): void
    {
        $this->seedCategories();

        $this->seedPizzas();
    }

    private function seedCategories(): void
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

    private function seedPizzas(): void
    {
        $this->ingredientsCategories = IngredientsCategory::with('ingredients:id,category_id')->get(['id', 'exclusive', 'max_per_ingredient']);

        $this->variants = VariantsService::getMatrix('id');

        foreach (PizzaCategory::all() as $category) {
            $pizzasInCategory = 6;

            for ($i = 1; $i <= $pizzasInCategory; ++$i) {
                $this->createPizza($category->id);
            }
        }
    }

    private function createPizza(int $categoryID): void
    {
        $pizza = Pizza::create([
            'title' => 'Pizza '.ucwords(implode(' ', fake()->words(random_int(1, 3)))),
            'card_image_path' => 'storage/card/pepperony-y-tomaty.png',
            'page_image_path' => 'storage/product/pepperony-y-tomaty.png',
            'thumbnail_image_path' => 'storage/thumbnail/pepperony-y-tomaty.png',
            'labels' => ['spicy', 'cheesy', 'vegetarian'],
            'pizza_category_id' => $categoryID,
        ]);

        $pizza->composition()->attach($this->randomComposition());

        $this->seedRandomVariants($pizza->id);
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

    private function seedRandomVariants(int $pizzaId): void
    {
        $baseSizePrice = random_int(330, 370);
        $baseSizeWeight = random_int(330, 430);

        foreach ($this->variants as $sizeID => $doughsList) {
            $sizePrice = $baseSizePrice;
            $sizeWeight = $baseSizeWeight;

            foreach ($doughsList as $doughID => $crustsList) {
                $crustPrice = $sizePrice;

                foreach ($crustsList as $crustID) {
                    PizzaVariant::create([
                        'pizza_id' => $pizzaId,

                        'option_size_id' => $sizeID,
                        'option_dough_id' => $doughID,
                        'option_crust_id' => $crustID,

                        'price' => round($crustPrice),
                        'weight' => round($sizeWeight),
                    ]);

                    $crustPrice *= 1.17;
                    $sizeWeight *= 1.2;
                }
            }

            $baseSizePrice *= 1.17;
            $baseSizeWeight *= 1.25;
        }
    }
}
