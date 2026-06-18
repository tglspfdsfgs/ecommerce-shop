<?php

use App\Registries\PizzaIngredientsRegistry;
use App\Registries\PizzaOptionsRegistry;
use App\Services\PizzaService;
use Livewire\Component;

new class extends Component {
    public array $product;

    public array $options;

    public array $ingredients;

    public function mount(string $slug, PizzaService $service): void
    {
        $this->product = $service->getBySlug($slug);

        $this->ingredients = PizzaIngredientsRegistry::list();

        $this->options = PizzaOptionsRegistry::pluck("name", "slug");
    }
};
?>

<div x-data='{
    size: @json($product["defaults"]["size"]),
    dough: @json($product["defaults"]["dough"]),
    crust: @json($product["defaults"]["crust"]),

    price: @json($product["defaults"]["price"]),

    values: @json($product["variants"]),

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
    }
}'
    x-init="countPrice();
    $watch('size', () => {
        dough = getFirstDough();
        crust = getFirstCrust();
        countPrice();
    });
    $watch('dough', () => { countPrice() });
    $watch('crust', () => { countPrice() });">
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
                <div class="shrink">
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

                        <div>
                            <div class="text-lg font-bold">Pizza ingredients</div>
                            <div>Two free replacements available</div>
                            <div class="flex overflow-hidden">
                                <div class="px-0.5">
                                    <div class="w-30 h-30 flex flex-col items-center justify-between gap-0.5 rounded-sm border-2 border-stone-300 bg-white">
                                        <div class="h-15 w-15 flex items-center">
                                            <img class="w-full align-middle" src="{{ asset("storage/composition/meat/pepp.png") }}">
                                        </div>
                                        <span class="text-sm">Peperoni</span>
                                        <span class="bg-base-200/75 mb-1 flex h-1/4 w-[93%] items-center justify-between rounded-md px-1">
                                            <button type="button">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                    stroke="currentColor" class="size-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                            <span>1</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                                <div class="px-0.5">
                                    <div class="w-30 h-30 flex flex-col items-center justify-between gap-0.5 rounded-sm border-2 border-stone-300 bg-white">
                                        <div class="h-15 w-15 flex items-center">
                                            <img class="w-full align-middle" src="{{ asset("storage/composition/cheese/mozzarella.png") }}">
                                        </div>
                                        <span class="text-sm">Mozzarella</span>
                                        <span class="bg-base-200/75 mb-1 flex h-1/4 w-[93%] items-center justify-between rounded-md px-1">
                                            <button type="button">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                    stroke="currentColor" class="size-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                            <span>1</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                                <div class="px-0.5">
                                    <div class="w-30 h-30 flex flex-col items-center justify-between gap-0.5 rounded-sm border-2 border-stone-300 bg-white">
                                        <div class="h-15 w-15 flex items-center">
                                            <img class="w-full align-middle" src="{{ asset("storage/composition/vegetables/tomato.png") }}">
                                        </div>
                                        <span class="text-sm">Tomatoes</span>
                                        <span class="bg-base-200/75 mb-1 flex h-1/4 w-[93%] items-center justify-between rounded-md px-1">
                                            <button type="button">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                    stroke="currentColor" class="size-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                            <span>1</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                                <div class="px-0.5">
                                    <div class="w-30 h-30 flex flex-col items-center justify-between gap-0.5 rounded-sm border-2 border-stone-300 bg-white">
                                        <div class="h-15 w-15 flex items-center">
                                            <img class="w-full align-middle" src="{{ asset("storage/composition/sauses/sous-bbk.png") }}">
                                        </div>
                                        <span class="text-sm">BBQ sauce</span>
                                        <span class="bg-base-200/75 mb-1 flex h-1/4 w-[93%] items-center justify-between rounded-md px-1">
                                            <button type="button">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                    stroke="currentColor" class="size-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                            <span>1</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </livewire:layout.main>
    <livewire:layout.footer />
</div>
