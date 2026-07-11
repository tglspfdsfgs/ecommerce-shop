<span wire:ignore
    x-data='{
    init() {
        PizzaConfig.initialize({
                ingredients: @json(app(App\Pizza\Registries\IngredientsRegistry::class)->list()),
                groupedIngrediends: @json(app(App\Pizza\Registries\IngredientsRegistry::class)->grouped()),
                ingredientRules: @json(App\Pizza\Rules\IngredientRules::toArray()),
                optionsOrder: @json(app(App\Pizza\Registries\OptionsRegistry::class)->only("slug")),
        });
    }
}'></span>
