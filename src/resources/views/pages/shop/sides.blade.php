<?php

use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component {
    public array $showcases = [];

    public array $filterSchemes = [];

    public function mount(): void
    {
        $this->filterSchemes = include resource_path("views/pages/shop/mock/filterSchemes.php");
        $this->showcases = include resource_path("views/pages/shop/mock/showcases.php");
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

        @foreach ($this->showcases as $data)
            <livewire:blocks.showcase :data="$data" />
        @endforeach
    </livewire:layout.main>
    <livewire:layout.footer />
</div>
