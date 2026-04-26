<?php

use Livewire\Component;

new class extends Component {
    public array $data;
    private array $options = [
        "sizes" => ["Standard size", "Large", "ExtraLarge", "XXLarge"],
        "doughs" => ["Dough Thick", "Dough Thin"],
        "crusts" => ["Without bort", "Cheesy", "Hot-Dog"],
    ];
    private array $defaults;

    public function mount(): void
    {
        $values = $this->data["values"];
        $size = array_key_first($values);
        $dough = array_key_first($values[$size]);
        $crust = array_key_first($values[$size][$dough]);

        $this->defaults = compact("size", "dough", "crust");
    }
};
?>

<div x-data='{
    size: @json($this->defaults["size"]),
    dough: @json($this->defaults["dough"]),
    crust: @json($this->defaults["crust"]),

    options: @json($this->options),
    values: @json($data["values"]),

    resetValues(size = this.size) {
        const firstDough = Object.keys(this.values[size])[0];
        const firstCrust = Object.keys(this.values[size][firstDough])[0];
        this.dough = firstDough;
        this.crust = firstCrust;
    },
    get selectValue() {
        return `${this.dough}|${this.crust}`;
    },
    set selectValue(val) {
        const [dough, crust] = val.split(`|`);
        this.dough = dough;
        this.crust = crust;
    },

}'
    class="card group-[.showed-more]:max-sm:card-side bg-base-100 shrink-0.5 shadow-sm transition-shadow hover:shadow-xl">
    <figure class="card w-full overflow-hidden group-[.showed-more]:max-sm:aspect-square group-[.showed-more]:max-sm:basis-1/2">
        <a href="{{ route($data["resourceRoute"]) }}" class="relative block h-full">
            @if (!empty($data["labels"]))
                <div class="absolute left-3 top-3 max-md:hidden">
                    @foreach ($data["labels"] as $label)
                        <span class="badge badge-sm badge-error rounded-sm font-bold uppercase text-white">{{ $label }}</span>
                    @endforeach
                </div>
            @endif
            <img src='{{ asset($data["cardImage"]) }}' class="h-full w-full object-cover" />
            <div class="badge badge-sm badge-neutral bg-neutral/50 text-neutral-content absolute bottom-3 right-3 border-none">
                <span x-text="(values[size][dough][crust]['weight'] ?? 0) + ` g*`">0 g*</span>
            </div>
        </a>
    </figure>

    <div class="card-body p-3 group-[.showed-more]:max-sm:basis-1/2">
        @if (!empty($data["labels"]))
            <div class="md:hidden">
                @foreach ($data["labels"] as $label)
                    <span class="badge badge-sm badge-error rounded-sm font-bold uppercase text-white">{{ $label }}</span>
                @endforeach
            </div>
        @endif
        <span class="flex items-start justify-between">
            <a href="{{ route($data["resourceRoute"]) }}" class="card-title mb-1.5">{{ $data["title"] }}</a>
            <div class="tooltip tooltip-bottom">
                <div class="tooltip-content max-w-25 wrap-break-word rounded-md">
                    <div>
                        {{ join(", ", $data["composition"]) }}
                    </div>
                </div>
                <div class="badge badge-ghost badge-sm ml-auto">Composition</div>
            </div>
        </span>
        <div class="card-actions group mb-1.5">
            <select x-model="size"
                class="select select-info group-[.showed-more]:max-sm:select-neutral w-full leading-9 group-[.showed-more]:max-sm:rounded-md group-[.showed-more]:sm:mb-2">
                @foreach ($this->options["sizes"] as $size)
                    <option @click="resetValues('{{ $size }}')" value="{{ $size }}">
                        {{ $size }}
                    </option>
                @endforeach
            </select>
            <div class="flex w-full justify-between gap-1 group-[.showed-more]:max-sm:hidden">
                @foreach ($this->options["doughs"] as $dough)
                    <input type="radio" name="dough{{ $this->getId() }}" x-model="dough" value="{{ $dough }}"
                        class="btn btn-sm checked:btn-info shrink grow" aria-label="{{ $dough }}"
                        :class="{ 'btn-disabled': !values[size]['{{ $dough }}'] }" @click="resetValues()" />
                @endforeach
            </div>
            <div class="mb-3 flex w-full justify-between gap-0.5 group-[.showed-more]:max-sm:hidden">
                @foreach ($this->options["crusts"] as $crust)
                    <input type="radio" name="crust{{ $this->getId() }}" x-model="crust" value="{{ $crust }}"
                        class="btn btn-xs checked:btn-info shrink grow" :class="{ 'btn-disabled': !values[size][dough]['{{ $crust }}'] }"
                        aria-label="{{ $crust }}" />
                @endforeach
            </div>
            <select x-model="selectValue" class="select select-neutral hidden rounded-md group-[.showed-more]:max-sm:block">
                @foreach ($this->options["doughs"] as $dough)
                    @foreach ($this->options["crusts"] as $crust)
                        <option :class="{ 'hidden': !values[size]?.['{{ $dough }}']?.['{{ $crust }}'] }"
                            value="{{ $dough }}|{{ $crust }}">{{ $dough }} / {{ $crust }}</option>
                    @endforeach
                @endforeach
            </select>
            <a href="{{ route($data["resourceRoute"]) }}" class="btn btn-outline btn-error mb-3 w-full text-black group-[.showed-more]:max-sm:hidden">Replace
                ingredients</a>
            <div class="flex w-full items-center justify-between">
                <span class="font-bold md:text-lg"><span x-text="(values[size][dough][crust]['price'] ?? 0) + `.00 uah`">0.00 uah</span></span>
                <button class="btn btn-error max-md:btn-sm text-white">
                    <x-assets.ui.basket />
                    Add
                </button>
            </div>
        </div>
    </div>
</div>
