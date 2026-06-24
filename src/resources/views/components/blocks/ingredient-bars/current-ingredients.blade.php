@php
    use App\Pizza\Registries\IngredientsRegistry;
    $ingredients = IngredientsRegistry::bySlug();
@endphp

<div x-data='{
        compositionState: {},

        ingredients: @json($ingredients),

        increaseIngredient(ingredient) {
            this.compositionState[ingredient.slug]++;
        },

        decreaseIngredient(ingredient) {
            if (this.composition[ingredient.slug] !== 1) {
                this.composition[ingredient.slug]--;
            } else {
                delete this.compositionState[ingredient.slug]
            }
        },
    }'
    {{ $attributes->only(["x-model"]) }} x-modelable="compositionState" class="mb-3">
    <div class="text-lg font-bold">Pizza ingredients</div>
    <div>Two free replacements available</div>

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
                @click="$refs.slider.scrollBy({
                                                    left: $refs.slider.querySelector('.ingredient').offsetWidth,
                                                    behavior: 'smooth'
                                                })"
                class="btn btn-circle bg-base-300/75 btn-sm absolute right-0 top-1/2 z-10 -translate-y-1/2 rounded-md">
                ❯
            </button>
            <button x-cloak x-show="canScroll"
                @click="refs.slider.scrollBy({
                                                    left: -$refs.slider.querySelector('.ingredient').offsetWidth,
                                                    behavior: 'smooth'
                                                })"
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

                            <button type="button" @click="increaseIngredient(ingredients[slug])">
                                <x-assets.ui.plus />
                            </button>
                        </span>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
