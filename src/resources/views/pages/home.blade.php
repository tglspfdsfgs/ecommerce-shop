<?php

use Livewire\Component;

new class extends Component {
    public array $showcases = [];

    public function mount(): void
    {
        $this->showcases = include resource_path("views/pages/shop/mock/showcases.php");
    }
};

?>

<div>
    <livewire:layout.header />
    <livewire:layout.main>
        <x-blocks.carousel />
        @foreach ($this->showcases as $data)
            <livewire:blocks.showcase on-home-page :data="$data" />
        @endforeach
        <x-blocks.home-categories />
    </livewire:layout.main>
    <livewire:layout.footer />
</div>
