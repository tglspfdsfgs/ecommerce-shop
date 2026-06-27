export class PizzaStateController {
    constructor(registries, variants) {
        this.registries = registries;
        this.variants = variants;
    }

    sizeChanged(newSize) {
        const dough = this.getFirstDough(newSize);
        const crust = this.getFirstCrust(newSize, dough);

        const price = this.countPrice(newSize, dough, crust);
        const weight = this.getWeight(newSize, dough, crust);

        return { dough, crust, price, weight };
    }

    doughChanged(size, newDough) {
        const crust = this.getFirstCrust(size, newDough);

        const price = this.countPrice(size, newDough, crust);
        const weight = this.getWeight(size, newDough, crust);

        return { crust, price, weight };
    }

    crustChanged(size, dough, newCrust) {
        const price = this.countPrice(size, dough, newCrust);
        const weight = this.getWeight(size, dough, newCrust);

        return { price, weight };
    }

    getFirstDough(size) {
        return this.registries.optionsOrder.doughs.find((d) => this.variants[size]?.[d]);
    }

    getFirstCrust(size, dough) {
        return this.registries.optionsOrder.crusts.find((c) => this.variants[size]?.[dough]?.[c]);
    }

    countPrice(size, dough, crust) {
        return this.variants[size][dough][crust][`price`] ?? 0;
    }

    getWeight(size, dough, crust) {
        return this.variants[size][dough][crust][`weight`] ?? 0;
    }
}

export class PizzaRegistries {
    static ingredients;
    static optionsOrder;

    static register(ingredients, optionsOrder) {
        this.ingredients = ingredients;
        this.optionsOrder = optionsOrder;
    }
}
