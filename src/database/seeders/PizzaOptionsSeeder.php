<?php

namespace Database\Seeders;

use App\Models\PizzaOptions\OptionCrust;
use App\Models\PizzaOptions\OptionDough;
use App\Models\PizzaOptions\OptionSize;
use Illuminate\Database\Seeder;

class PizzaOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedSizes();
        $this->seedDoughs();
        $this->seedCrusts();
    }

    private function seedSizes(): void
    {
        $sizes = [
            'Standard size',
            'Large',
            'ExtraLarge',
            'XXLarge',
        ];

        foreach ($sizes as $size) {
            OptionSize::create(['name' => $size]);
        }
    }

    private function seedDoughs(): void
    {
        $doughs = [
            'Dough Thick',
            'Dough Thin',
        ];

        foreach ($doughs as $dough) {
            OptionDough::create(['name' => $dough]);
        }
    }

    private function seedCrusts(): void
    {
        $crusts = [
            'Without bort',
            'Cheesy',
            'Hot-Dog',
        ];

        foreach ($crusts as $crust) {
            OptionCrust::create(['name' => $crust]);
        }
    }
}
