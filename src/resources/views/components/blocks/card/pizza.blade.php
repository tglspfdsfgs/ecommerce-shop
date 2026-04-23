<?php

use Livewire\Component;

new class extends Component {};
?>

<div x-data="{
    size: 'standard',
    dough: 'dough-thick',
    crust: 'without-bort',
    get selectValue() {
        return `${this.dough}|${this.crust}`;
    },
    set selectValue(val) {
        const [dough, crust] = val.split('|');
        this.dough = dough;
        this.crust = crust;
    },
    price: {
        'standard': { 'without-bort': 281, 'cheesy': 330, 'hot-dog': 346 },
        'large': { 'without-bort': 341, 'cheesy': 398, 'hot-dog': 419 },
        'extraLarge': { 'without-bort': 395, 'cheesy': 460, 'hot-dog': 486 },
        'XXLarge': { 'without-bort': 461, 'cheesy': 541, 'hot-dog': 556 },
    }
}" class="card group-[.showed-more]:max-sm:card-side bg-base-100 shrink-0.5 shadow-sm transition-shadow hover:shadow-xl">
    <figure class="card w-full overflow-hidden group-[.showed-more]:max-sm:aspect-square group-[.showed-more]:max-sm:basis-1/2">
        <a href="#" class="relative block h-full">
            <div class="absolute left-3 top-3 max-md:hidden">
                <span class="badge badge-sm badge-error rounded-sm font-bold uppercase text-white">spicy</span>
                <span class="badge badge-sm badge-error rounded-sm font-bold uppercase text-white">cheesy</span>
                <span class="badge badge-sm badge-error rounded-sm font-bold uppercase text-white">vegetarian</span>
            </div>
            <img src='{{ asset("storage/card/pepperony-y-tomaty.png") }}' class="h-full w-full object-cover" />
            <div class="badge badge-sm badge-neutral bg-neutral/50 text-neutral-content absolute bottom-3 right-3 border-none">550 g*</div>
        </a>
    </figure>

    <div class="card-body p-3 group-[.showed-more]:max-sm:basis-1/2">
        <div class="md:hidden">
            <span class="badge badge-sm badge-error rounded-sm font-bold uppercase text-white">spicy</span>
            <span class="badge badge-sm badge-error rounded-sm font-bold uppercase text-white">cheesy</span>
            <span class="badge badge-sm badge-error rounded-sm font-bold uppercase text-white">vegetarian</span>
        </div>
        <span class="flex items-start justify-between">
            <a href="#" class="card-title mb-1.5">Pizza Pepperoni with tomatoes</a>
            <div class="tooltip tooltip-bottom">
                <div class="tooltip-content max-w-25 wrap-break-word rounded-md">
                    <div>
                        Mozarella, Peperoni, BBQ sauce, Tomatoes
                    </div>
                </div>
                <div class="badge badge-ghost badge-sm ml-auto">Composition</div>
            </div>
        </span>

        <div class="card-actions group mb-1.5">
            <select x-model="size"
                class="select select-info group-[.showed-more]:max-sm:select-neutral w-full leading-9 group-[.showed-more]:max-sm:rounded-md group-[.showed-more]:sm:mb-2">
                <option value="standard">Standard size</option>
                <option value="large">Large</option>
                <option value="extraLarge">ExtraLarge</option>
                <option value="XXLarge">XXLarge</option>
            </select>
            <div class="flex w-full justify-between gap-1 group-[.showed-more]:max-sm:hidden">
                <input type="radio" name="dough" x-model="dough" @click="crust = 'without-bort'" value="dough-thick"
                    class="btn btn-sm checked:btn-info shrink grow" aria-label="Dough Thick" />
                <input type="radio" name="dough" x-model="dough" value="dough-thin" class="btn btn-sm checked:btn-info shrink grow"
                    aria-label="Dough Thin" />
            </div>
            <div class="mb-3 flex w-full justify-between gap-0.5 group-[.showed-more]:max-sm:hidden">
                <input type="radio" name="crust" x-model="crust" value="without-bort" class="btn btn-xs checked:btn-info shrink grow"
                    aria-label="Without bort" />
                <input type="radio" name="crust" x-model="crust" value="cheesy" class="btn btn-xs checked:btn-info shrink grow"
                    :class="dough === 'dough-thick' ? 'btn-disabled' : ''" aria-label="Cheesy" />
                <input type="radio" name="crust" x-model="crust" value="hot-dog" class="btn btn-xs checked:btn-info shrink grow"
                    :class="dough === 'dough-thick' ? 'btn-disabled' : ''" aria-label="Hot-Dog" />
            </div>

            <select x-model="selectValue" class="select select-neutral hidden rounded-md group-[.showed-more]:max-sm:block">
                <option value="dough-thick|without-bort">Dough Thick / Without bort</option>
                <option value="dough-thin|without-bort">Dough Thin / Without bort</option>
                <option value="dough-thin|cheesy">Dough Thin / Cheesy</option>
                <option value="dough-thin|hot-dog">Dough Thin / Hot-Dog</option>
            </select>

            <a href="#" class="btn btn-outline btn-error mb-3 w-full text-black group-[.showed-more]:max-sm:hidden">Replace ingredients</a>
            <div class="flex w-full items-center justify-between">
                <span class="font-bold md:text-lg"><span x-text="price[size][crust]"></span>.00 uah</span>
                <button class="btn btn-error max-md:btn-sm text-white">
                    <x-assets.ui.basket />
                    Add
                </button>
            </div>
        </div>
    </div>
</div>
