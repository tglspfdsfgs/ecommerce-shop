<?php

use App\Registries\Pizza\IngredientsRegistry;
use App\Registries\Pizza\OptionsRegistry;
use App\Services\PizzaService;
use Livewire\Component;

new class extends Component {
    public array $product;

    public array $options;

    public array $ingredients;

    public array $groupedIngrediends;

    public function mount(string $slug, PizzaService $service): void
    {
        $this->product = $service->getBySlug($slug);

        $this->ingredients = IngredientsRegistry::bySlug();

        $this->groupedIngrediends = IngredientsRegistry::grouped();

        $this->options = OptionsRegistry::pluck("name", "slug");
    }
};
?>

<div
    x-data='{
    size: @json($product["defaults"]["size"]),
    dough: @json($product["defaults"]["dough"]),
    crust: @json($product["defaults"]["crust"]),

    price: @json($product["defaults"]["price"]),

    values: @json($product["variants"]),

    composition: @json($product["composition"]),

    addToComposition(ingredient) {
        this.composition[ingredient.slug] = 1;
    },

    increaseIngredient(ingredient) {
        this.composition[ingredient.slug]++;
    },

    decreaseIngredient(ingredient) {
        if (this.composition[ingredient.slug] !== 1) {
            this.composition[ingredient.slug]--;
        } else {
            delete this.composition[ingredient.slug]
        }
    },

    order: {
        doughs: @json(array_keys($options["doughs"])),
        crusts: @json(array_keys($options["crusts"])),
    },

    getFirstDough() {
        return this.order.doughs.find(
            d => this.values[this.size]?.[d]
        );
    },

    getFirstCrust() {
        const dough = this.dough;

        return this.order.crusts.find(
            c => this.values[this.size]?.[dough]?.[c]
        );
    },

    countPrice() {
        this.price = this.values[this.size][this.dough][this.crust][`price`] ?? 0;
    },

    init() {
        with (this) {
            countPrice();
            $watch(`size`, () => {
                dough = getFirstDough();
                crust = getFirstCrust();
                countPrice();
            });
            $watch(`dough`, () => {
                crust = getFirstCrust();
                countPrice();
            });
            $watch(`crust`, () => { countPrice() });
        }
    }
}'>
    <livewire:layout.header />
    <livewire:layout.main>
        <div class="mx-3">
            <div class="mb-3 w-full"><a class="link link-info no-underline" href="#">← Back to list</a></div>
            <div class="flex flex-col justify-items-start md:flex-row">
                <span class="w-1/3 shrink-0 max-md:w-full md:mr-5">
                    <div class="relative">
                        <img class="mx-auto" src='{{ asset("storage/product/pepperony-y-tomaty.png") }}'>
                        <div class="badge badge-sm badge-neutral bg-neutral/50 text-neutral-content absolute bottom-1 right-1 border-none">
                            <span x-text="(values?.[size]?.[dough]?.[crust]?.['weight'] ?? 0) + ` g*`">{{ $product["defaults"]["weight"] }} g*</span>
                        </div>
                    </div>

                </span>
                <div class="shrink overflow-x-hidden">
                    <h2 class="mb-2 text-xl font-bold">{{ $product["title"] }}</h2>
                    <div class="mb-4">
                        <span class="mr-2 text-lg font-bold"><span x-text="price + `.00 uah`">{{ $product["defaults"]["price"] }}.00 uah</span></span>

                        <button class="btn btn-error max-md:btn-sm text-white">
                            <x-assets.ui.basket />
                            Add
                        </button>
                    </div>
                    <div>
                        <div class="mb-2">
                            <div class="mb-1">Size:</div>
                            @foreach ($options["sizes"] as $sizeSlug => $sizeName)
                                <input type="radio" @disabled(!array_key_exists($sizeSlug, $product["variants"])) :checked="size === '{{ $sizeSlug }}'" value="{{ $sizeSlug }}"
                                    class="btn btn-sm checked:btn-info mb-1.5" aria-label="{{ $sizeName }}" x-model="size" />
                            @endforeach
                        </div>
                        <div class="mb-2">
                            <div class="mb-1">Dough:</div>
                            @foreach ($options["doughs"] as $doughSlug => $doughName)
                                <input type="radio" x-model="dough" :checked="dough === '{{ $doughSlug }}'" value="{{ $doughSlug }}"
                                    class="btn btn-sm checked:btn-info mb-1.5" aria-label="{{ $doughName }}"
                                    :class="{ 'btn-disabled': !values?.[size]?.['{{ $doughSlug }}'] }" />
                            @endforeach
                        </div>
                        <div class="mb-2">
                            <div class="mb-1">Crust:</div>
                            @foreach ($options["crusts"] as $crustSlug => $crustName)
                                <input type="radio" x-model="crust" :checked="crust === '{{ $crustSlug }}'" value="{{ $crustSlug }}"
                                    class="btn btn-sm checked:btn-info mb-1.5" :class="{ 'btn-disabled': !values?.[size]?.[dough]?.['{{ $crustSlug }}'] }"
                                    aria-label="{{ $crustName }}" />
                            @endforeach
                        </div>

                        <div class="mb-3">
                            <div class="text-lg font-bold">Pizza ingredients</div>
                            <div>Two free replacements available</div>

                            <div class="relative">
                                <div x-data="{
                                    init() {
                                            const observer = new ResizeObserver(() => {
                                                this.checkSlider();
                                            });
                                
                                            observer.observe($refs.slider);
                                
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
                                    <template x-for="(quantity, slug) in composition" :key="slug">
                                        <div class="ingredient px-0.5">
                                            <div
                                                class="w-35 h-35 relative flex flex-col items-center justify-normal gap-0.5 overflow-hidden rounded-sm border-2 border-stone-300 bg-white">
                                                <div class="h-15 w-15 mt-1.5 flex items-center">
                                                    <img class="w-full align-middle" :src="$wire.ingredients[slug].image_url">
                                                </div>
                                                <span class="mx-1 text-center text-sm" x-text="$wire.ingredients[slug].name"></span>
                                                <span
                                                    class="bg-base-200/75 absolute bottom-0 mb-1 flex h-1/4 w-[93%] items-center justify-between rounded-md px-1">

                                                    <button type="button" @click="decreaseIngredient($wire.ingredients[slug])">
                                                        <x-assets.ui.trash />
                                                    </button>

                                                    <span x-text="quantity"></span>

                                                    <button type="button" @click="increaseIngredient($wire.ingredients[slug])">
                                                        <x-assets.ui.plus />
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <div x-data='{
                                show: @json(array_first($groupedIngrediends)["slug"]),}'>
                            <div class="text-lg font-bold">Add ingredients</div>
                            <div class="my-2">
                                @foreach ($groupedIngrediends as $category)
                                    <input type="radio" :checked="show === '{{ $category["slug"] }}'" value="{{ $category["slug"] }}"
                                        class="btn btn-sm checked:btn-info mb-1.5" aria-label="{{ $category["name"] }}" x-model="show" />
                                @endforeach
                            </div>
                            <div class="relative w-auto">
                                <template x-for="category in $wire.groupedIngrediends" :key="category.slug">
                                    <div x-data="{
                                        init() {
                                                const observer = new ResizeObserver(() => {
                                                    this.checkSlider();
                                                });
                                    
                                                observer.observe($refs.slider);
                                    
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

                                            <div :class="{ 'hidden': composition[slug] }" class="ingredient snap-start px-0.5">
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
                    </div>
                </div>
            </div>

        </div>
    </livewire:layout.main>
    <livewire:layout.footer />
</div>
