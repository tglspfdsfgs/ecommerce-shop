<?php

namespace Database\Seeders;

use Database\Seeders\PizzaSeeders\IngredientsSeeder;
use Database\Seeders\PizzaSeeders\OptionsSeeder;
use Database\Seeders\PizzaSeeders\PizzaSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            OptionsSeeder::class,
            IngredientsSeeder::class,
            PizzaSeeder::class,
        ]);
    }
}
