<div x-data='{
        compositionState: {},

        groupedIngrediends: PizzaConfig.groupedIngrediends,

        showedCategory: Object.keys(PizzaConfig.groupedIngrediends)[0],

        max_total: PizzaConfig.ingredientRules.max_total,

        totalCount: 0,

        countTotal() {
            this.totalCount = Object.values(this.compositionState).reduce((sum, curr) => sum + curr, 0);
        },

        isCategoryBlocked(category) {
            return category.exclusive && Object.keys(this.compositionState)
                .some(slug => category.ingredients[slug]);
        },

        canAdd(ingredientSlug, category) {
            return !(this.totalCount >= this.max_total
                || this.isCategoryBlocked(category)
                || this.compositionState[ingredientSlug]);
        },

        addToComposition(ingredientSlug, category) {
            if (this.canAdd(ingredientSlug, category)) {
                this.compositionState[ingredientSlug] = 1;
            }
        },

        init() {
            $watch(`compositionState`, () => {
                this.countTotal();
            });
        },
    }'
    {{ $attributes->only(["x-model"]) }} x-modelable="compositionState">
    <div class="text-lg font-bold">Add ingredients</div>
    <div class="my-2">
        <template x-for="category in groupedIngrediends" :key="category.id">
            <input type="radio" :checked="showedCategory === category.slug" :value="category.slug" class="btn btn-sm checked:btn-info mb-1.5 mr-1"
                :aria-label="category.name" x-model="showedCategory" />
        </template>
    </div>
    <div class="relative w-auto">
        <template x-for="category in groupedIngrediends" :key="category.slug">
            <div x-data="{
                init() {
                        const observer = new ResizeObserver(() => {
                            this.checkSlider();
                        });
            
                        observer.observe($refs.slider);
            
                        $watch(`compositionState`, () => { this.checkSlider() });
            
                        this.checkSlider();
                    },
                    canScroll: false,
                    checkSlider() {
                        this.$nextTick(() => {
                            this.canScroll =
                                this.$refs.slider.scrollWidth >
                                this.$refs.slider.clientWidth + 1;
                        });
                    },
            }" x-ref="slider" x-show="showedCategory === category.slug" class="flex overflow-x-auto">

                <button x-cloak x-show="canScroll"
                    @click="$refs.slider.scrollBy({ left: $refs.slider.querySelector('.ingredient').offsetWidth, behavior: 'smooth' })"
                    class="btn btn-circle bg-base-300/75 btn-sm absolute right-0 top-1/2 z-10 -translate-y-1/2 rounded-md">
                    ❯
                </button>
                <button x-cloak x-show="canScroll"
                    @click="$refs.slider.scrollBy({ left: -$refs.slider.querySelector('.ingredient').offsetWidth, behavior: 'smooth' })"
                    class="btn btn-circle bg-base-300/75 btn-sm absolute left-0 top-1/2 z-10 -translate-y-1/2 rounded-md">
                    ❮
                </button>
                <template x-for="ingredient in category.ingredients" :key="ingredient.slug">
                    <template x-if="!compositionState[ingredient.slug]">
                        <div @click="addToComposition(ingredient.slug, category)" class="ingredient cursor-pointer select-none snap-start px-0.5"
                            :class="{ 'opacity-50 pointer-events-none': !canAdd(ingredient.slug, category) }">
                            <div
                                class="w-35 h-35 relative flex flex-col items-center justify-normal gap-0.5 overflow-hidden rounded-sm border-2 border-stone-300 bg-white">
                                <div class="h-15 w-15 mt-1.5 flex items-center">
                                    <img class="w-full align-middle" :src="ingredient.image_url">
                                </div>
                                <span class="mx-1 text-center text-sm" x-text="ingredient.name"></span>

                                <span class="bg-base-200/75 absolute bottom-1 right-1 block rounded-md p-1 align-middle">
                                    <x-assets.ui.plus />
                                </span>
                            </div>
                        </div>
                    </template>
                </template>
            </div>
        </template>
    </div>
</div>
