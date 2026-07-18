<?php

use Livewire\Component;

new class extends Component {
    public array $product;
};
?>

<div x-data='{
    size: @json($product["defaults"]["size"]),
    dough: @json($product["defaults"]["dough"]),
    crust: @json($product["defaults"]["crust"]),

    price: @json($product["defaults"]["price"]),
    weight: @json($product["defaults"]["weight"]),

    composition: @json($product["composition"]),

    stateController: null,

    get selectDoughAndCrust() {
        return `${this.dough}|${this.crust}`;
    },
    set selectDoughAndCrust(val) {
        const [dough, crust] = val.split(`|`);
        this.dough = dough;
        this.crust = crust;
    },
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
    class="card group-[.showed-more]:max-sm:card-side bg-base-100 shrink-0.5 shadow-sm transition-shadow hover:shadow-xl">
    <figure class="card w-full overflow-hidden group-[.showed-more]:max-sm:aspect-square group-[.showed-more]:max-sm:basis-1/2">
        <a href="{{ route("pizza.product", parameters: ["slug" => $product["slug"]]) }}" wire:navigate class="relative block h-full">
            @if (!empty($product["labels"]))
                <div class="absolute left-3 top-3 max-md:hidden">
                    @foreach ($product["labels"] as $label)
                        <span class="badge badge-sm badge-error rounded-sm font-bold uppercase text-white">{{ $label }}</span>
                    @endforeach
                </div>
            @endif
            <img src='{{ $product["card_image_url"] }}' class="h-full w-full object-cover" />
            <div class="badge badge-sm badge-neutral bg-neutral/50 text-neutral-content absolute bottom-3 right-3 border-none">
                <span x-text="weight + ` g*`">{{ $product["defaults"]["weight"] }} g*</span>
            </div>
        </a>
    </figure>

    <div class="card-body p-3 group-[.showed-more]:max-sm:basis-1/2">
        @if (!empty($product["labels"]))
            <div class="md:hidden">
                @foreach ($product["labels"] as $label)
                    <span class="badge badge-sm badge-error rounded-sm font-bold uppercase text-white">{{ $label }}</span>
                @endforeach
            </div>
        @endif
        <span class="flex items-start justify-between">
            <a href="#" class="card-title mb-1.5">{{ $product["title"] }}</a>
            <div class="tooltip tooltip-bottom">
                <div class="tooltip-content max-w-25 wrap-break-word rounded-md">
                    <div x-text="Object.keys(composition).map(slug => ` ${PizzaConfig.ingredients[slug].name}`)">
                    </div>
                </div>
                <div class="badge badge-ghost badge-sm ml-auto">Composition</div>
            </div>
        </span>
        @php
            $options = app(App\Pizza\Registries\OptionsRegistry::class)->pluck("name", "slug");
            extract($options);
        @endphp
        <div x-data='{ variants: @json($product["variants"]) }' class="card-actions group mb-1.5">
            <select x-model="size"
                class="select select-info group-[.showed-more]:max-sm:select-neutral w-full leading-9 group-[.showed-more]:max-sm:rounded-md group-[.showed-more]:sm:mb-2">
                @foreach ($sizes as $sizeSlug => $sizeName)
                    <option @disabled(!array_key_exists($sizeSlug, $product["variants"])) value="{{ $sizeSlug }}">
                        {{ $sizeName }}
                    </option>
                @endforeach
            </select>
            <div class="flex w-full justify-between gap-1 group-[.showed-more]:max-sm:hidden">
                @foreach ($doughs as $doughSlug => $doughName)
                    <input type="radio" name="dough{{ $this->getId() }}" x-model="dough" value="{{ $doughSlug }}"
                        class="btn btn-sm checked:btn-info shrink grow" aria-label="{{ $doughName }}"
                        :class="{ 'btn-disabled': !variants[size]['{{ $doughSlug }}'] }" />
                @endforeach
            </div>
            <div class="mb-3 flex w-full justify-between gap-0.5 group-[.showed-more]:max-sm:hidden">
                @foreach ($crusts as $crustSlug => $crustName)
                    <input name="crust{{ $this->getId() }}" type="radio" x-model="crust" :checked="crust === '{{ $crustSlug }}'"
                        value="{{ $crustSlug }}" class="btn btn-xs checked:btn-info shrink grow"
                        :class="{ 'btn-disabled': !variants?.[size]?.[dough]?.['{{ $crustSlug }}'] }" aria-label="{{ $crustName }}" />
                @endforeach
            </div>
            <select x-model="selectDoughAndCrust" class="select select-neutral hidden rounded-md group-[.showed-more]:max-sm:block">
                @foreach ($doughs as $doughSlug => $doughName)
                    @foreach ($crusts as $crustSlug => $crustName)
                        <option :class="{ 'hidden': !variants[size]?.['{{ $doughSlug }}']?.['{{ $crustSlug }}'] }"
                            value="{{ $doughSlug }}|{{ $crustSlug }}">{{ $doughName }} / {{ $crustName }}</option>
                    @endforeach
                @endforeach
            </select>
            <a href="{{ route("pizza.product", parameters: ["slug" => $product["slug"]]) }}" wire:navigate
                class="btn btn-outline btn-error mb-3 w-full text-black group-[.showed-more]:max-sm:hidden">Replace
                ingredients</a>
            <div class="flex w-full items-center justify-between">
                <span class="font-bold md:text-lg"><span x-text="price + ` uah`">{{ $product["defaults"]["price"] }} uah</span></span>
                <button class="btn btn-error max-md:btn-sm text-white">
                    <x-assets.ui.basket />
                    Add
                </button>
            </div>
        </div>
    </div>
</div>
