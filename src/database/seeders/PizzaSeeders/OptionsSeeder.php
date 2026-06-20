<?php

namespace Database\Seeders\PizzaSeeders;

use App\Models\Products\Pizza\Options\OptionCrust;
use App\Models\Products\Pizza\Options\OptionDough;
use App\Models\Products\Pizza\Options\OptionSize;
use Illuminate\Database\Seeder;

class OptionsSeeder extends Seeder
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
