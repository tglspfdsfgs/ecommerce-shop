<div class="sm:h-99 mx-3 mb-5 grid gap-4 sm:grid-cols-2 sm:grid-rows-3 md:h-auto md:grid-cols-5 md:grid-rows-2">
    <a href="#"
        class="bg-bottom-right max-sm:h-50 md:h-150 bg-base-300 text-base-content card bg-contain bg-no-repeat sm:row-span-3 md:col-span-3 md:row-span-2"
        style="background-image: url('{{ asset("storage/categories/pizza.png") }}')">
        <span class="md:mt-15 ml-10 mt-7 text-4xl font-bold md:ml-20 md:text-7xl">PIZZA</span>
    </a>
    <a href="#" style="background-image: url('{{ asset("storage/categories/sides.png") }}')"
        class="bg-bottom-right max-sm:h-50 bg-base-300 text-base-content card bg-contain bg-no-repeat md:col-span-2 md:col-start-4">
        <span class="ml-10 mt-7 text-4xl font-bold">SIDES</span>
    </a>
    <a href="#" class="bg-bottom-right max-sm:h-50 bg-base-300 text-base-content card bg-contain bg-no-repeat sm:col-start-2 md:col-start-4 md:row-start-2"
        style="background-image: url('{{ asset("storage/categories/starter.png") }}')">
        <span class="ml-10 mt-7 text-4xl font-bold md:ml-5 md:text-2xl lg:text-4xl">STARTER</span>
    </a>
    <a href="#"
        class="bg-bottom-right max-sm:h-50 bg-base-300 text-base-content card bg-contain bg-no-repeat sm:col-start-2 sm:row-start-3 md:col-start-5 md:row-start-2"
        style="background-image: url('{{ asset("storage/categories/drinks.png") }}')">
        <span class="ml-10 mt-7 text-4xl font-bold md:ml-5 md:text-2xl lg:text-4xl">DRINKS</span>
    </a>
</div>

{{--

<div class="grid gap-4 sm:grid-cols-2 sm:grid-rows-3 sm:h-99 md:h-auto md:grid-cols-5 md:grid-rows-2">
    <div class="flex bg-base-300 text-base-content card sm:row-span-3 md:col-span-3 md:row-span-2">
        <span class="self-start mt-7 ml-10 text-4xl md:mt-15 md:ml-20 md:text-7xl font-bold ">PIZZA</span>
        <img class="self-end w-2/5 sm:w-3/4 mt-auto" src="{{ asset('storage/categories/pizza.png') }}" />
    </div>
    <div class="bg-base-300 text-base-content card relative md:col-span-2 md:col-start-4">
        <span class="absolute z-1 top-7 left-10 text-4xl font-bold">SIDES</span>
        <img class="ml-auto w-2/3 h-auto" src="{{ asset('storage/categories/sides.png') }}" />
    </div>
    <div class="flex bg-base-300 text-base-content card sm:col-start-2 md:col-start-4 md:row-start-2">
        <span class="self-start mt-7 ml-10 text-4xl font-bold">STARTER</span>
        <img class="self-end mt-auto" src="{{ asset('storage/categories/starter.png') }}" />
    </div>
    <div class="flex bg-base-300 text-base-content card sm:col-start-2 sm:row-start-3 md:col-start-5 md:row-start-2">
        <span class="self-start mt-7 ml-10 text-4xl font-bold">DRINKS</span>
        <img class="self-end mt-auto" src="{{ asset('storage/categories/drinks.png') }}" />
    </div>
</div>
--}}
