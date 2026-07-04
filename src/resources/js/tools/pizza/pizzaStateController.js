import CompositionPriceCalculator from "./compositionPriceCalculator.js";

export default class PizzaStateController {
    constructor(config, variants, defaultComposition) {
        this.optionsOrder = config.optionsOrder;
        this.variants = variants;
        this.defaultComposition = defaultComposition;

        this.compositionPriceCalculator = new CompositionPriceCalculator(config.ingredients, config.groupedIngrediends, config.ingredientRules);
    }

    sizeChanged(newSize, composition) {
        const dough = this.getFirstDough(newSize);
        const crust = this.getFirstCrust(newSize, dough);

        const price = this.countPrice(newSize, dough, crust, composition);
        const weight = this.getWeight(newSize, dough, crust);

        return { dough, crust, price, weight };
    }

    doughChanged(size, newDough, composition) {
        const crust = this.getFirstCrust(size, newDough);

        const price = this.countPrice(size, newDough, crust, composition);
        const weight = this.getWeight(size, newDough, crust);

        return { crust, price, weight };
    }

    crustChanged(size, dough, newCrust, composition) {
        const price = this.countPrice(size, dough, newCrust, composition);
        const weight = this.getWeight(size, dough, newCrust);

        return { price, weight };
    }

    getFirstDough(size) {
        return this.optionsOrder.doughs.find((d) => this.variants[size]?.[d]);
    }

    getFirstCrust(size, dough) {
        return this.optionsOrder.crusts.find((c) => this.variants[size]?.[dough]?.[c]);
    }

    countPrice(size, dough, crust, currComposition) {
        const basePrice = this.variants[size][dough][crust][`price`];

        const ingredientsPrice = this.compositionPriceCalculator.calculate(this.defaultComposition, currComposition, size);

        return basePrice + ingredientsPrice;
    }

    getWeight(size, dough, crust) {
        return this.variants[size][dough][crust][`weight`];
    }
}
