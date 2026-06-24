@php
    use App\Pizza\Registries\IngredientsRegistry;
    $groupedIngrediends = IngredientsRegistry::grouped();
@endphp

<div x-data='{
        compositionState: {},

        groupedIngrediends: @json($groupedIngrediends),

        show: @json(array_first($groupedIngrediends)["slug"]),

        addToComposition(ingredient) {
            this.compositionState[ingredient.slug] = 1;
        },
    }'
    {{ $attributes->only(["x-model"]) }} x-modelable="compositionState">
    <div class="text-lg font-bold">Add ingredients</div>
    <div class="my-2">
        @foreach ($groupedIngrediends as $category)
            <input type="radio" :checked="show === '{{ $category["slug"] }}'" value="{{ $category["slug"] }}" class="btn btn-sm checked:btn-info mb-1.5"
                aria-label="{{ $category["name"] }}" x-model="show" />
        @endforeach
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
            }" x-ref="slider" x-show="show === category.slug" class="flex overflow-x-auto">
                <button x-cloak x-show="canScroll"
                    @click="$refs.slider.scrollBy({
                                                    left: $refs.slider.querySelector('.ingredient').offsetWidth,
                                                    behavior: 'smooth'
                                                })"
                    class="btn btn-circle bg-base-300/75 btn-sm absolute right-0 top-1/2 z-10 -translate-y-1/2 rounded-md">
                    ❯
                </button>
                <button x-cloak x-show="canScroll"
                    @click="$refs.slider.scrollBy({
                                                    left: -$refs.slider.querySelector('.ingredient').offsetWidth,
                                                    behavior: 'smooth'
                                                    })"
                    class="btn btn-circle bg-base-300/75 btn-sm absolute left-0 top-1/2 z-10 -translate-y-1/2 rounded-md">
                    ❮
                </button>
                <template x-for="(ingredient, slug) in category.ingredients" :key="slug">

                    <div :class="{ 'hidden': slug in compositionState }" class="ingredient snap-start px-0.5">
                        <div
                            class="w-35 h-35 relative flex flex-col items-center justify-normal gap-0.5 overflow-hidden rounded-sm border-2 border-stone-300 bg-white">
                            <div class="h-15 w-15 mt-1.5 flex items-center">
                                <img class="w-full align-middle" :src="ingredient.image_url">
                            </div>
                            <span class="mx-1 text-center text-sm" x-text="ingredient.name"></span>

                            <button class="bg-base-200/75 absolute bottom-1 right-1 block rounded-md p-1 align-middle" type="button"
                                @click="addToComposition(ingredient)">
                                <x-assets.ui.plus />
                            </button>
                        </div>
                    </div>

                </template>
            </div>
        </template>
    </div>
</div>
