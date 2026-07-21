import CompositionPriceCalculator from "./compositionPriceCalculator.js";

export default function createPizzaState(defaults, variants, composition, pizzaConfig) {
    return {
        size: defaults.size,
        dough: defaults.dough,
        crust: defaults.crust,
        price: defaults.price,
        weight: defaults.weight,
        composition,

        get selectDoughAndCrust() {
            return `${this.dough}|${this.crust}`;
        },
        set selectDoughAndCrust(val) {
            const [dough, crust] = val.split(`|`);
            this.dough = dough;
            this.crust = crust;
        },

        init() {
            const controller = new StateController(pizzaConfig, variants, composition);

            this.$watch("size", (newSize) => {
                Object.assign(this, controller.sizeChanged(newSize, this.composition));
            });

            this.$watch("dough", (newDough) => {
                Object.assign(this, controller.doughChanged(this.size, newDough, this.composition));
            });

            this.$watch("crust", (newCrust) => {
                Object.assign(this, controller.crustChanged(this.size, this.dough, newCrust, this.composition));
            });

            this.$watch("composition", (newComposition) => {
                this.price = controller.countPrice(this.size, this.dough, this.crust, newComposition);
            });
        },
    };
}

class StateController {
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
