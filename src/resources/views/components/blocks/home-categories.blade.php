<div class="sm:h-99 mx-3 mb-5 grid gap-4 sm:grid-cols-2 sm:grid-rows-3 md:h-auto md:grid-cols-5 md:grid-rows-2">
    <a href="{{ route("pizza") }}" wire:navigate
        class="bg-bottom-right max-sm:h-50 md:h-150 bg-base-300 text-base-content card bg-contain bg-no-repeat sm:row-span-3 md:col-span-3 md:row-span-2"
        style="background-image: url('{{ asset("storage/categories/pizza.png") }}')">
        <span class="md:mt-15 ml-10 mt-7 text-4xl font-bold md:ml-20 md:text-7xl">PIZZA</span>
    </a>
    <a href="{{ route("sides") }}" wire:navigate style="background-image: url('{{ asset("storage/categories/sides.png") }}')"
        class="bg-bottom-right max-sm:h-50 bg-base-300 text-base-content card bg-contain bg-no-repeat md:col-span-2 md:col-start-4">
        <span class="ml-10 mt-7 text-4xl font-bold">SIDES</span>
    </a>
    <a href="{{ route("dessert") }}" wire:navigate
        class="bg-bottom-right max-sm:h-50 bg-base-300 text-base-content card bg-contain bg-no-repeat sm:col-start-2 md:col-start-4 md:row-start-2"
        style="background-image: url('{{ asset("storage/categories/starter.png") }}')">
        <span class="ml-10 mt-7 text-4xl font-bold md:ml-5 md:text-2xl lg:text-4xl">STARTER</span>
    </a>
    <a href="{{ route("drinks") }}" wire:navigate
        class="bg-bottom-right max-sm:h-50 bg-base-300 text-base-content card bg-contain bg-no-repeat sm:col-start-2 sm:row-start-3 md:col-start-5 md:row-start-2"
        style="background-image: url('{{ asset("storage/categories/drinks.png") }}')">
        <span class="ml-10 mt-7 text-4xl font-bold md:ml-5 md:text-2xl lg:text-4xl">DRINKS</span>
    </a>
</div>
