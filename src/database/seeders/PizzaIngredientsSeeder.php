<?php

namespace Database\Seeders;

use App\Models\PizzaIngredients\Ingredient;
use App\Models\PizzaIngredients\IngredientsCategory;
use App\Models\PizzaIngredients\IngredientsPrice;
use App\Models\PizzaOptions\OptionSize;
use Illuminate\Database\Seeder;

class PizzaIngredientsSeeder extends Seeder
{
    private array $configuration = [
        'Cheese' => [
            'Mozarella' => 'storage/composition/cheese/mozzarella.png',
        ],
        'Meat' => [
            'Peperoni' => 'storage/composition/meat/pepp.png',
        ],
        'Sauces' => [
            'BBQ sauce' => 'storage/composition/sauses/sous-bbk.png',
        ],
        'Vegetables' => [
            'Tomatoes' => 'storage/composition/vegetables/tomato.png',
        ],
    ];
    private array $categoryIds = [];
    private array $ingredientIds = [];

    public function run(): void
    {
        $this->seedCategories();
        $this->seedIngredients();
        $this->seedPrices();
    }

    private function seedCategories(): void
    {
        $categories = array_keys($this->configuration);

        foreach ($categories as $category) {
            $model = IngredientsCategory::create([
                'name' => $category,
            ]);

            $this->categoryIds[$category] = $model->id;
        }
    }

    private function seedIngredients(): void
    {
        foreach ($this->configuration as $category => $ingredients) {
            foreach ($ingredients as $ingredient => $imagePath) {
                $model = Ingredient::create([
                    'name' => $ingredient,
                    'category_id' => $this->categoryIds[$category],
                    'image_path' => $imagePath,
                ]);
                $this->ingredientIds[$ingredient] = $model->id;
            }
        }
    }

    private function seedPrices(): void
    {
        $sizes = OptionSize::orderBy('sort_order')->get();

        foreach ($this->ingredientIds as $ingredientId) {
            $price = 29;

            foreach ($sizes as $size) {
                IngredientsPrice::create([
                    'ingredient_id' => $ingredientId,
                    'option_size_id' => $size->id,
                    'price' => $price,
                ]);
                $price += 10;
            }
        }
    }
}
