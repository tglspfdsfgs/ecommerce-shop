export class PizzaConfig {
    static initialize({ ingredients, groupedIngrediends, ingredientRules, optionsOrder }) {
        Object.assign(this, {
            ingredients,
            groupedIngrediends,
            ingredientRules,
            optionsOrder,
        });
    }
}
