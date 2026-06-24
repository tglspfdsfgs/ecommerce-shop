<?php

use App\Pizza\Registries\OptionsRegistry;
use App\Pizza\Services\PizzaService;
use Livewire\Component;

new class extends Component {
    public array $product;

    private array $options;

    public function mount(string $slug, PizzaService $service): void
    {
        $this->product = $service->getBySlug($slug);

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

    order: {
        doughs: @json(array_keys($this->options["doughs"])),
        crusts: @json(array_keys($this->options["crusts"])),
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
                            @foreach ($this->options["sizes"] as $sizeSlug => $sizeName)
                                <input type="radio" @disabled(!array_key_exists($sizeSlug, $product["variants"])) :checked="size === '{{ $sizeSlug }}'" value="{{ $sizeSlug }}"
                                    class="btn btn-sm checked:btn-info mb-1.5" aria-label="{{ $sizeName }}" x-model="size" />
                            @endforeach
                        </div>
                        <div class="mb-2">
                            <div class="mb-1">Dough:</div>
                            @foreach ($this->options["doughs"] as $doughSlug => $doughName)
                                <input type="radio" x-model="dough" :checked="dough === '{{ $doughSlug }}'" value="{{ $doughSlug }}"
                                    class="btn btn-sm checked:btn-info mb-1.5" aria-label="{{ $doughName }}"
                                    :class="{ 'btn-disabled': !values?.[size]?.['{{ $doughSlug }}'] }" />
                            @endforeach
                        </div>
                        <div class="mb-2">
                            <div class="mb-1">Crust:</div>
                            @foreach ($this->options["crusts"] as $crustSlug => $crustName)
                                <input type="radio" x-model="crust" :checked="crust === '{{ $crustSlug }}'" value="{{ $crustSlug }}"
                                    class="btn btn-sm checked:btn-info mb-1.5" :class="{ 'btn-disabled': !values?.[size]?.[dough]?.['{{ $crustSlug }}'] }"
                                    aria-label="{{ $crustName }}" />
                            @endforeach
                        </div>

                        <x-blocks.ingredient-bars.current-ingredients x-model="composition" />

                        <x-blocks.ingredient-bars.add-ingredient x-model="composition" />
                    </div>
                </div>
            </div>

        </div>
    </livewire:layout.main>
    <livewire:layout.footer />
</div>
