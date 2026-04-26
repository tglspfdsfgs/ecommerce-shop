<?php

use Livewire\Component;

new class extends Component {
    public array $data;
};
?>

<div x-data='{
    current: @json(array_key_first($data["values"])),
    values: @json($data["values"])
}'
    class="card group-[.showed-more]:max-sm:card-side bg-base-100 shrink-0.5 shadow-sm transition-shadow hover:shadow-xl group-[.showed-more]:flex-col group-[.showed-more]:min-[359px]:flex-row group-[.showed-more]:sm:flex-col">
    <figure class="card h-full overflow-hidden max-sm:basis-1/2 max-sm:self-center">
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
                <span x-text="(values[current]['weight'] ?? 0) + ` g*`">0 g*</span>
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
        <span class="mb-auto flex items-start justify-between">
            <a href="{{ route($data["resourceRoute"]) }}" class="card-title mb-1.5">Cola can</a>
            @if (!empty($data["composition"]))
                <div class="tooltip tooltip-bottom">
                    <div class="tooltip-content max-w-25 wrap-break-word rounded-md">
                        <div>
                            {{ join(", ", $data["composition"]) }}
                        </div>
                    </div>
                    <div class="badge badge-ghost badge-sm ml-auto">Composition</div>
                </div>
            @endif
        </span>

        <div class="card-actions mb-1.5">
            <div class="mb-2 grid w-full grid-cols-2 gap-1">
                @foreach (array_keys($data["values"]) as $option)
                    <input type="radio" name="{{ $this->getId() }}" x-model="current" value="{{ $option }}"
                        class="btn btn-sm checked:btn-info shrink grow" aria-label="{{ $option }}" />
                @endforeach
            </div>

            <div class="flex w-full items-center justify-between">
                <span class="font-bold md:text-lg"><span x-text="(values[current]['price'] ?? 0) + '.00 uah'">0.00 uah</span></span>
                <button class="btn btn-error max-md:btn-sm text-white">
                    <x-assets.ui.basket />
                    Add
                </button>
            </div>
        </div>
    </div>
</div>
