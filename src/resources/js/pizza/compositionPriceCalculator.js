/**
 * @typedef {Object} CategoryChange
 * @property {number} [added]
 * @property {number} [removed]
 * @property {number} [replacement]
 * @property {number} categoryPrice
 * @property {boolean} [free]
 * @property {number} [paid]
 */

/**
 * Composition ingredients price calculator.
 *
 * IMPORTANT!
 * This algorithm must have an identical implementation in
 * App\Pizza\Services\PriceCalculator.
 * Keep both implementations synchronized.
 *
 */
export default class CompositionPriceCalculator {
    /**
     * @param {Object.<string, Object>} ingredients
     * @param {Object.<string, Object>} groupedIngrediends
     * @param {Object.<string, any>} ingredientRules
     */
    constructor(ingredients, groupedIngrediends, ingredientRules) {
        this.ingredients = ingredients;
        this.groupedIngrediends = groupedIngrediends;
        this.ingredientRules = ingredientRules;
    }

    /**
     * Calculates the final composition price based on ingredient changes.
     *
     * @param {Object.<string, number>} defaultComposition
     * @param {Object.<string, number>} currComposition
     * @param {string} size
     *
     * @returns {number}
     */
    calculate(defaultComposition, currComposition, size) {
        return pipe(this.compositionChanges(defaultComposition, currComposition), [
            (_) => this.groupChanges(_),
            (_) => this.calculateReplacements(_),
            (_) => this.populateCategoryPrices(_, size),
            (_) => this.applyFreeCategoryReplacements(_),
            (_) => this.calculatePaid(_),
            (_) => this.sumPrice(_),
        ]);
    }

    /**
     * @param {Object.<string, number>} defaultComposition
     * @param {Object.<string, number>} currComposition
     *
     * @returns {{
     *   added: Object.<string, number>,
     *   removed: Object.<string, number>
     * }}
     */
    compositionChanges(defaultComposition, currComposition) {
        const changes = { added: {}, removed: {} };

        for (const slug in defaultComposition) {
            if (currComposition[slug] === undefined) {
                changes.removed[slug] = defaultComposition[slug];
                continue;
            }

            if (currComposition[slug] > defaultComposition[slug]) {
                changes.added[slug] = currComposition[slug] - defaultComposition[slug];
            }

            if (currComposition[slug] < defaultComposition[slug]) {
                changes.removed[slug] = defaultComposition[slug] - currComposition[slug];
            }
        }

        for (const slug in currComposition) {
            if (defaultComposition[slug] === undefined) {
                changes.added[slug] = currComposition[slug];
            }
        }

        return changes;
    }

    /**
     * @param {{
     *   added: Object.<string, number>,
     *   removed: Object.<string, number>
     * }} ingredientChanges
     *
     * @returns {Object.<string, CategoryChange>}
     */
    groupChanges(ingredientChanges) {
        const categoryChanges = {};

        for (const ingredientSlug in ingredientChanges.removed) {
            const categorySlug = this.ingredients[ingredientSlug].category.slug;

            if (categoryChanges[categorySlug] === undefined) {
                categoryChanges[categorySlug] = {};
            }

            if (categoryChanges[categorySlug].removed === undefined) {
                categoryChanges[categorySlug].removed = ingredientChanges.removed[ingredientSlug];
            } else {
                categoryChanges[categorySlug].removed += ingredientChanges.removed[ingredientSlug];
            }
        }

        for (const ingredientSlug in ingredientChanges.added) {
            const categorySlug = this.ingredients[ingredientSlug].category.slug;

            if (categoryChanges[categorySlug] === undefined) {
                categoryChanges[categorySlug] = {};
            }

            if (categoryChanges[categorySlug].added === undefined) {
                categoryChanges[categorySlug].added = ingredientChanges.added[ingredientSlug];
            } else {
                categoryChanges[categorySlug].added += ingredientChanges.added[ingredientSlug];
            }
        }

        return categoryChanges;
    }

    /**
     * @param {Object.<string, CategoryChange>} categoryChanges
     * @param {string} size
     * @returns {Object.<string, CategoryChange>}
     */
    populateCategoryPrices(categoryChanges, size) {
        for (const categorySlug in categoryChanges) {
            categoryChanges[categorySlug].categoryPrice = this.groupedIngrediends[categorySlug].prices[size];
        }

        return categoryChanges;
    }

    /**
     * @param {Object.<string, CategoryChange>} categoryChanges
     * @returns {Object.<string, CategoryChange>}
     */
    calculateReplacements(categoryChanges) {
        for (const category of Object.values(categoryChanges)) {
            category.replacement = Math.min(category.added ?? 0, category.removed ?? 0);
        }

        return categoryChanges;
    }

    /**
     * @param {Object.<string, CategoryChange>} categoryChanges
     * @returns {Object.<string, CategoryChange>}
     */
    applyFreeCategoryReplacements(categoryChanges) {
        const freeCategories = this.ingredientRules.free_category_replacement;

        Object.values(categoryChanges)
            .filter((category) => category.replacement > 0)
            .sort((a, b) => b.categoryPrice - a.categoryPrice)
            .slice(0, freeCategories)
            .forEach((category) => {
                category.free = true;
            });

        return categoryChanges;
    }

    /**
     * @param {Object.<string, CategoryChange>} categoryChanges
     * @returns {Object.<string, CategoryChange>}
     */
    calculatePaid(categoryChanges) {
        for (const category of Object.values(categoryChanges)) {
            category.paid = category.added ?? 0;

            if (category.free) {
                category.paid -= category.replacement;
            }
        }

        return categoryChanges;
    }

    /**
     * @param {Object.<string, CategoryChange>} categoryChanges
     * @returns {number}
     */
    sumPrice(categoryChanges) {
        return Object.values(categoryChanges).reduce((acc, item) => acc + item.paid * item.categoryPrice, 0);
    }
}

function pipe(value, fns) {
    return fns.reduce((_, fn) => fn(_), value);
}
