<?php

namespace Database\Seeders\PizzaSeeders;

use App\Pizza\Models\Ingredients\Ingredient;
use App\Pizza\Models\Ingredients\IngredientsCategory;
use App\Pizza\Models\Ingredients\IngredientsPrice;
use App\Pizza\Models\Options\OptionSize;
use Illuminate\Database\Seeder;

class IngredientsSeeder extends Seeder
{
    private array $configuration = [
        'Cheese' => [
            'Mozarella' => 'storage/ingredients/cheese/Mozzarella.png',
            'Feta' => 'storage/ingredients/cheese/Feta.png',
            'Bergader Blue' => 'storage/ingredients/cheese/Bergader-Blue.png',
            'Cheddar' => 'storage/ingredients/cheese/Cheddar.png',
            'Parmezan' => 'storage/ingredients/cheese/Parmezan.png',
        ],
        'Meat' => [
            'Peperoni' => 'storage/ingredients/meat/Peperoni.png',
            'White sausages' => 'storage/ingredients/meat/White-sausages.png',
            'Veal' => 'storage/ingredients/meat/Veal.png',
            'Chorizo' => 'storage/ingredients/meat/Chorizo.png',
            'Meatballs' => 'storage/ingredients/meat/Meatballs.png',
            'Ham' => 'storage/ingredients/meat/Ham.png',
            'Bavarian sausages' => 'storage/ingredients/meat/Bavarian-sausages.png',
            'Chicken' => 'storage/ingredients/meat/Chicken.png',
            'Salami' => 'storage/ingredients/meat/Salami.png',
            'Sous-vide turkey' => 'storage/ingredients/meat/Sous-vide-turkey.png',
            'Bacon' => 'storage/ingredients/meat/Bacon.png',
        ],
        'Sauces' => [
            'BBQ sauce' => 'storage/ingredients/sauses/BBQ-sauce.png',
            'Al\'fredo sauce' => 'storage/ingredients/sauses/Alfredo-sauce.png',
            'Garlic-sauce' => 'storage/ingredients/sauses/Garlic-sauce.png',
            'PizzaDash\'s sauce' => 'storage/ingredients/sauses/PizzaDashs-sauce.png',
        ],
        'Vegetables' => [
            'Tomatoes' => 'storage/ingredients/vegetables/Tomato.png',
            'Corn' => 'storage/ingredients/vegetables/Corn.png',
            'Crispy onion' => 'storage/ingredients/vegetables/Crispy-onion.png',
            'Dried tomatoes' => 'storage/ingredients/vegetables/Dried-tomatoes.png',
            'Jalapeno' => 'storage/ingredients/vegetables/Jalapeno.png',
            'Cherry tomatoes' => 'storage/ingredients/vegetables/Cherry-tomatoes.png',
            'Mushrooms' => 'storage/ingredients/vegetables/Mushrooms.png',
            'Mustard' => 'storage/ingredients/vegetables/Mustard.png',
            'Olives' => 'storage/ingredients/vegetables/Olives.png',
            'Onion' => 'storage/ingredients/vegetables/Onion.png',
            'Pear' => 'storage/ingredients/vegetables/Pear.png',
            'Pickled cucumbers' => 'storage/ingredients/vegetables/Pickled-cucumbers.png',
            'Pineapple' => 'storage/ingredients/vegetables/Pineapple.png',
            'Spinach' => 'storage/ingredients/vegetables/Spinach.png',
            'Sweet pepper' => 'storage/ingredients/vegetables/Sweet-pepper.png',
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

        IngredientsCategory::where('name', 'Sauces')
            ->firstOrFail()
            ->update([
                'exclusive' => true,
                'max_per_ingredient' => 2,
            ]);
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
