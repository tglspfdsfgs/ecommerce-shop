@php
    use App\Pizza\Registries\IngredientsRegistry;
    use App\Pizza\Rules\IngredientRules;
    $ingredients = IngredientsRegistry::bySlug();
@endphp

<div x-data='{
        compositionState: {},

        totalCount: 0,

        max_total: @json(IngredientRules::MAX_TOTAL),

        ingredients: @json($ingredients),

        countTotal() {
            this.totalCount = Object.values(this.compositionState).reduce((sum, curr) => sum + curr, 0);
        },

        canIncrease(ingredient) {
            if (this.compositionState[ingredient.slug] < ingredient.category.max_per_ingredient
                 && this.totalCount < this.max_total) {
                    return true
                }
            return false;
        },

        increaseIngredient(ingredient) {
            if (this.canIncrease(ingredient)) {
                this.compositionState[ingredient.slug]++;
            }
        },

        decreaseIngredient(ingredient) {
            if (this.composition[ingredient.slug] === 1) {
                delete this.compositionState[ingredient.slug];
            } else {
                this.composition[ingredient.slug]--;
            }
        },

        init() {
            $watch(`compositionState`, () => {
                this.countTotal();
            });
        },
    }'
    {{ $attributes->only(["x-model"]) }} x-modelable="compositionState" class="mb-3">
    <div class="text-lg font-bold">Pizza ingredients</div>
    <div class="mb-2">
        <span>Two free replacements available</span>
        <div class="tooltip tooltip-bottom">
            <div class="tooltip-content max-w-50 wrap-break-word rounded-md">
                <div>
                    You can replace the current ingredient with something similar to it (For example, meat for meat, vegetables for vegetables, cheese for
                    cheese)
                </div>
            </div>
            <div class="badge badge-ghost badge-sm ml-auto">Details</div>
        </div>
    </div>

    <div class="relative">
        <div x-data="{
            init() {
                    const observer = new ResizeObserver(() => {
                        this.checkSlider();
                    });
        
                    observer.observe($refs.slider);
        
                    $watch(`composition`, () => { this.checkSlider() });
        
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
        }" class="flex overflow-x-auto" x-ref="slider">
            <button x-cloak x-show="canScroll"
                @click="$refs.slider.scrollBy({ left: $refs.slider.querySelector('.ingredient').offsetWidth, behavior: 'smooth'})"
                class="btn btn-circle bg-base-300/75 btn-sm absolute right-0 top-1/2 z-10 -translate-y-1/2 rounded-md">
                ❯
            </button>
            <button x-cloak x-show="canScroll"
                @click="$refs.slider.scrollBy({ left: -$refs.slider.querySelector('.ingredient').offsetWidth, behavior: 'smooth' })"
                class="btn btn-circle bg-base-300/75 btn-sm absolute left-0 top-1/2 z-10 -translate-y-1/2 rounded-md">
                ❮
            </button>
            <template x-for="(quantity, slug) in compositionState" :key="slug">
                <div class="ingredient px-0.5">
                    <div
                        class="w-35 h-35 relative flex flex-col items-center justify-normal gap-0.5 overflow-hidden rounded-sm border-2 border-stone-300 bg-white">
                        <div class="h-15 w-15 mt-1.5 flex items-center">
                            <img class="w-full align-middle" :src="ingredients[slug].image_url">
                        </div>
                        <span class="mx-1 text-center text-sm" x-text="ingredients[slug].name"></span>
                        <span class="bg-base-200/75 absolute bottom-0 mb-1 flex h-1/4 w-[93%] items-center justify-between rounded-md px-1">

                            <button type="button" @click="decreaseIngredient(ingredients[slug])">
                                <x-assets.ui.trash />
                            </button>

                            <span x-text="quantity"></span>

                            <button type="button" @click="increaseIngredient(ingredients[slug])"
                                :class="{ 'cursor-not-allowed': !canIncrease(ingredients[slug]) }">
                                <x-assets.ui.plus />
                            </button>
                        </span>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
