<?php

use Livewire\Component;

new class extends Component {
    public bool $onHomePage = false;
};
?>

<section x-data="{ showedMore: {{ json_encode(!$onHomePage) }} }" class="mb-5">
    <div class="mx-3 mb-4 sm:flex sm:justify-start">
        <h2 class="text-3xl font-bold">
            Bestsellers and novelties
            <span class="tooltip" data-tip="Novelties worth tasting">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="bg-base-300 mb-3 inline-block size-5 rounded-full">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                </svg>
            </span>
        </h2>

        <a @click="showedMore = true" class="link link-info ml-auto text-lg" :class="{ 'hidden': showedMore }">
            Show all
        </a>
    </div>

    <div class="disable-scroll-x group relative" :class="showedMore && 'showed-more'">
        <button @click="$refs.slider.scrollBy({ left: -$refs.slider.clientWidth, behavior: 'smooth' })"
            class="btn btn-circle btn-outline btn-info btn-lg md:btn-sm absolute left-0 top-1/2 z-10 -translate-y-1/2" :class="showedMore && 'hidden'">
            ❮
        </button>
        <button @click="$refs.slider.scrollBy({ left: $refs.slider.clientWidth, behavior: 'smooth' })"
            class="btn btn-circle btn-outline btn-info btn-lg md:btn-sm absolute right-0 top-1/2 z-10 -translate-y-1/2" :class="showedMore && 'hidden'">
            ❯
        </button>

        <div x-ref="slider" x-bind:class="showedMore ? 'flex flex-wrap' : 'flex flex-nowrap overflow-x-auto no-scrollbar'">
            <div class="mb-3 w-full shrink-0 snap-start px-3 sm:w-1/2 md:w-1/3 lg:w-1/4">
                <livewire:blocks.card.product />
            </div>
            <div class="mb-3 w-full shrink-0 snap-start px-3 sm:w-1/2 md:w-1/3 lg:w-1/4">
                <livewire:blocks.card.product />
            </div>
            <div class="mb-3 w-full shrink-0 snap-start px-3 sm:w-1/2 md:w-1/3 lg:w-1/4">
                <livewire:blocks.card.product />
            </div>
            <div class="mb-3 w-full shrink-0 snap-start px-3 sm:w-1/2 md:w-1/3 lg:w-1/4">
                <livewire:blocks.card.product />
            </div>
            <div class="mb-3 w-full shrink-0 snap-start px-3 sm:w-1/2 md:w-1/3 lg:w-1/4">
                <livewire:blocks.card.product />
            </div>
            <div class="mb-3 w-full shrink-0 snap-start px-3 sm:w-1/2 md:w-1/3 lg:w-1/4">
                <livewire:blocks.card.product />
            </div>
        </div>
    </div>

</section>
