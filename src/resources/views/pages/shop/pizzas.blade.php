<?php

use App\Pizza\Services\PizzaService;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component {
    public array $showcases = [];

    public array $filterSchemes = [];

    private PizzaService $service;

    public function mount(PizzaService $service): void
    {
        $this->filterSchemes = include resource_path("views/pages/shop/mock/filterSchemes.php");

        $this->showcases = [
            "list" => $service->showcases(),
            "productType" => $service::PRODUCT_TYPE,
        ];

        // dd($this->showcases);
    }

    #[On("filters-updated")]
    public function loadProducts(array $filters = []): void
    {
        // TODO: query
    }
};
?>

<div>
    <livewire:layout.header />
    <livewire:layout.main>
        <div wire:ignore>
            <livewire:blocks.filter.filter-bar :filter-schemes="$filterSchemes" include-reset-btns />
        </div>

        <x-blocks.initialize-pizza-config />

        @foreach ($showcases["list"] as $showcase)
            {{-- prettier-ignore --}}
            <livewire:blocks.showcase :data="$showcase" :productType="$showcases['productType']" :key="$showcase['id']" />
        @endforeach
    </livewire:layout.main>
    <livewire:layout.footer />
</div>
