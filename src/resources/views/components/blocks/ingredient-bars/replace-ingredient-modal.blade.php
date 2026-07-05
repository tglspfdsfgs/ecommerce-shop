<dialog x-data="{
    modalState: {
        categorySlug: null,
        replacement: {
            ingredientSlug: null,
            quantity: null
        }
    },

    compositionState: {},

    get ingredientsInCategory() {
        return PizzaConfig.groupedIngrediends[this.modalState.categorySlug]?.ingredients;
    },

    get categoryName() {
        return PizzaConfig.groupedIngrediends[this.modalState.categorySlug]?.name;
    },

    replaceIngredient(selectedIngredientSlug) {
        const oldIngredientSlug = this.modalState.replacement.ingredientSlug;
        const quantity = this.modalState.replacement.quantity;

        const newState = {};

        for (const [slug, value] of Object.entries(this.compositionState)) {
            if (slug === oldIngredientSlug) {
                newState[selectedIngredientSlug] = quantity;
            } else {
                newState[slug] = value;
            }
        }

        this.compositionState = newState;

        replacementModal.close();
    }
}" id="replacementModal" class="modal" @open-replacement-modal.window="modalState = $event.detail; replacementModal.showModal()"
    {{ $attributes->only(["x-model"]) }} x-modelable="compositionState">
    <div class="modal-box">
        <h3 class="mb-2 text-lg font-bold" x-text="categoryName"></h3>

        <div class="grid grid-cols-2 justify-between gap-2 md:grid-cols-3">
            <template x-for="ingredient in ingredientsInCategory">
                <div class="w-full cursor-pointer select-none" :class="{ 'hidden': ingredient.slug === modalState.replacement.ingredientSlug }"
                    @click="replaceIngredient(ingredient.slug)">
                    <div class="h-25 md:h-35 flex flex-col items-center rounded-sm border-2 border-stone-300 bg-white">
                        <div class="h-15 mt-1.5 flex items-center" @click="">
                            <img class="w-full align-middle" :src="ingredient.image_url">
                        </div>
                        <span class="mx-1 text-center text-sm md:mt-3" x-text="ingredient.name"></span>
                    </div>
                </div>
            </template>
        </div>

        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>
