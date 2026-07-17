<?php

use App\Pizza\Services\PizzaShowcasesService;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component {
    public array $showcases = [];

    public array $filterSchemes;

    public function mount(PizzaShowcasesService $showcasesService): void
    {
        $this->filterSchemes = $showcasesService->filterSchemes();

        $this->showcases = [
            "list" => $showcasesService->get(),
            "productType" => $showcasesService::PRODUCT_TYPE,
        ];
    }

    #[On("filters-updated")]
    public function loadProducts(array $filters = []): void
    {
        $this->showcases["list"] = app(PizzaShowcasesService::class)->get($filters);
    }
};
?>

<div>
    <livewire:layout.header />
    <livewire:layout.main>

        <div wire:ignore>
            <livewire:blocks.filter.filter-bar :filter-schemes="$filterSchemes" include-reset-btns />
        </div>

        <x-blocks.filter.loading-overlay />

        <x-blocks.initialize-pizza-config />

        @foreach ($showcases["list"] as $showcase)
            {{-- prettier-ignore --}}
            <livewire:blocks.showcase :data="$showcase" :product-type="$showcases['productType']" :key="$showcase['id']" />
        @endforeach
    </livewire:layout.main>
    <livewire:layout.footer />
</div>
