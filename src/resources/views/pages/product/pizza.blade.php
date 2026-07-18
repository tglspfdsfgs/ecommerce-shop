<?php

use App\Pizza\Services\PizzaProductService;
use Livewire\Component;

new class extends Component {
    public array $product;

    public function mount(string $slug, PizzaProductService $service): void
    {
        $this->product = $service->getBySlug($slug);
    }
};
?>

<div>
    <livewire:layout.header />
    <livewire:layout.main>
        <x-blocks.initialize-pizza-config />
        <div x-data='{
                size: @json($product["defaults"]["size"]),
                dough: @json($product["defaults"]["dough"]),
                crust: @json($product["defaults"]["crust"]),

                price: @json($product["defaults"]["price"]),
                weight: @json($product["defaults"]["weight"]),

                composition: @json($product["composition"]),

                stateController: null,

                init() {
                    this.stateController = new PizzaStateController(
                        PizzaConfig,
                        @json($product["variants"]),
                        @json($product["composition"])
                    );

                    with (this) {
                        price  = stateController.countPrice(size, dough, crust, composition);

                        $watch(`size`, (newSize) => {

                            ({ dough, crust, price, weight } = stateController.sizeChanged(newSize, composition));
                        });
                        $watch(`dough`, (newDough) => {

                            ({ crust, price, weight } = stateController.doughChanged(size, newDough, composition));
                        });
                        $watch(`crust`, (newCrust) => {

                            ({ price, weight } = stateController.crustChanged(size, dough, newCrust, composition));
                        });
                        $watch(`composition`, (newComposition) => {

                            price  = stateController.countPrice(size, dough, crust, newComposition);
                        });
                    }
                }
            }'
            class="mx-3">
            <div class="mb-3 w-full"><a class="link link-info no-underline" href=" {{ route("pizza.list") }} " wire:navigate>← Back to list</a></div>
            <div class="flex flex-col justify-items-start md:flex-row">
                <span class="w-1/3 shrink-0 max-md:w-full md:mr-5">
                    <div class="relative">
                        <img class="mx-auto" src='{{ $product["page_image_url"] }}'>
                        <div class="badge badge-sm badge-neutral bg-neutral/50 text-neutral-content absolute bottom-1 right-1 border-none">
                            <span x-text="weight + ` g*`">{{ $product["defaults"]["weight"] }} g*</span>
                        </div>
                    </div>

                </span>
                <div class="shrink overflow-hidden">
                    <h2 class="mb-2 text-xl font-bold">{{ $product["title"] }}</h2>
                    <div class="mb-4">
                        <span class="mr-2 text-lg font-bold"><span x-text="price + ` uah`">{{ $product["defaults"]["price"] }} uah</span></span>

                        <button class="btn btn-error max-md:btn-sm text-white">
                            <x-assets.ui.basket />
                            Add
                        </button>
                    </div>
                    <div>
                        @php
                            $options = app(App\Pizza\Registries\OptionsRegistry::class)->pluck("name", "slug");
                            extract($options);
                        @endphp
                        <div x-data='{ variants: @json($product["variants"]) }'>

                            <div class="mb-2">
                                <div class="mb-1">Size:</div>
                                @foreach ($sizes as $sizeSlug => $sizeName)
                                    <input type="radio" @disabled(!array_key_exists($sizeSlug, $product["variants"])) :checked="size === '{{ $sizeSlug }}'" value="{{ $sizeSlug }}"
                                        class="btn btn-sm checked:btn-info mb-1.5" aria-label="{{ $sizeName }}" x-model="size" />
                                @endforeach
                            </div>
                            <div class="mb-2">
                                <div class="mb-1">Dough:</div>
                                @foreach ($doughs as $doughSlug => $doughName)
                                    <input type="radio" x-model="dough" :checked="dough === '{{ $doughSlug }}'" value="{{ $doughSlug }}"
                                        class="btn btn-sm checked:btn-info mb-1.5" aria-label="{{ $doughName }}"
                                        :class="{ 'btn-disabled': !variants?.[size]?.['{{ $doughSlug }}'] }" />
                                @endforeach
                            </div>
                            <div class="mb-2">
                                <div class="mb-1">Crust:</div>
                                @foreach ($crusts as $crustSlug => $crustName)
                                    <input type="radio" x-model="crust" :checked="crust === '{{ $crustSlug }}'" value="{{ $crustSlug }}"
                                        class="btn btn-sm checked:btn-info mb-1.5"
                                        :class="{ 'btn-disabled': !variants?.[size]?.[dough]?.['{{ $crustSlug }}'] }" aria-label="{{ $crustName }}" />
                                @endforeach
                            </div>

                        </div>

                        <x-blocks.ingredient-bars.current-ingredients x-model="composition" />

                        <x-blocks.ingredient-bars.add-ingredient x-model="composition" />

                        <x-blocks.ingredient-bars.replace-ingredient-modal x-model="composition" />
                    </div>
                </div>
            </div>

        </div>
    </livewire:layout.main>
    <livewire:layout.footer />
</div>
