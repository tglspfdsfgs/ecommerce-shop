<?php

namespace App\Pizza\Providers;

use App\Pizza\Models\Options\OptionCrust;
use App\Pizza\Models\Options\OptionDough;
use App\Pizza\Models\Options\OptionSize;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class PizzaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Relation::enforceMorphMap([
            'size' => OptionSize::class,
            'dough' => OptionDough::class,
            'crust' => OptionCrust::class,
        ]);
    }
}
