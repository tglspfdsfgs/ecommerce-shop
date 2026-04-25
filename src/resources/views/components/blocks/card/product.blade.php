<?php

use Livewire\Component;

new class extends Component {};
?>

<div x-data="{
    current: '330-ml',
    price: { '330-ml': 57, '4*330': 188, }
}"
    class="card group-[.showed-more]:max-sm:card-side bg-base-100 shrink-0.5 flex-col shadow-sm transition-shadow hover:shadow-xl min-[359px]:flex-row sm:flex-col">
    <figure class="card h-full overflow-hidden max-sm:basis-1/2 max-sm:self-center">
        <a href="#" class="relative block h-full">
            <div class="absolute left-3 top-3 max-md:hidden">
                <span class="badge badge-sm badge-error rounded-sm font-bold uppercase text-white">NEW</span>
                <span class="badge badge-sm badge-error rounded-sm font-bold uppercase text-white">+18</span>
            </div>
            <img src='{{ asset("storage/card/cola.png") }}' class="h-full w-full object-cover" />
        </a>
    </figure>

    <div class="card-body p-3 group-[.showed-more]:max-sm:basis-1/2">
        <div class="md:hidden">
            <span class="badge badge-sm badge-error rounded-sm font-bold uppercase text-white">NEW</span>
            <span class="badge badge-sm badge-error rounded-sm font-bold uppercase text-white">+18</span>
        </div>
        <span class="mb-auto flex items-start justify-between">
            <a href="#" class="card-title mb-1.5">Cola can</a>
        </span>

        <div class="card-actions mb-1.5">
            <div class="mb-2 flex w-full flex-wrap justify-between gap-1">
                <input type="radio" name="type" x-model="current" value="330-ml" class="btn btn-sm checked:btn-info shrink grow" aria-label="330 ml" />
                <input type="radio" name="type" x-model="current" value="4*330" class="btn btn-sm checked:btn-info shrink grow" aria-label="4*330" />
            </div>

            <div class="flex w-full items-center justify-between">
                <span class="font-bold md:text-lg"><span x-text="price[current]"></span>.00 uah</span>
                <button class="btn btn-error max-md:btn-sm text-white">
                    <x-assets.ui.basket />
                    Add
                </button>
            </div>
        </div>
    </div>
</div>
