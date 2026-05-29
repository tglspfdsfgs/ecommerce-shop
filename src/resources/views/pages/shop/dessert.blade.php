<?php

use Livewire\Component;

new class extends Component {
    public array $showcases = [
        [
            "title" => "Bestsellers and novelties",
            "description" => "Novelties worth tasting",
            "products" => [
                [
                    "id" => 1,
                    "productType" => "pizza",
                    "cardImage" => "storage/card/pepperony-y-tomaty.png",
                    "resourceRoute" => "home",
                    "title" => "Pizza Pepperoni with tomatoes",
                    "composition" => ["Mozarella", "Peperoni", "BBQ sauce", "Tomatoes"],
                    "labels" => ["spicy", "cheesy", "vegetarian"],
                    "values" => [
                        "Standard size" => [
                            "Dough Thick" => [
                                "Without bort" => [
                                    "price" => 281,
                                    "weight" => 539,
                                ],
                            ],
                            "Dough Thin" => [
                                "Without bort" => [
                                    "price" => 281,
                                    "weight" => 380,
                                ],
                                "Cheesy" => [
                                    "price" => 330,
                                    "weight" => 512,
                                ],
                                "Hot-Dog" => [
                                    "price" => 368,
                                    "weight" => 588,
                                ],
                            ],
                        ],
                        "Large" => [
                            "Dough Thick" => [
                                "Without bort" => [
                                    "price" => 341,
                                    "weight" => 755,
                                ],
                            ],
                            "Dough Thin" => [
                                "Without bort" => [
                                    "price" => 341,
                                    "weight" => 524,
                                ],
                                "Cheesy" => [
                                    "price" => 389,
                                    "weight" => 728,
                                ],
                                "Hot-Dog" => [
                                    "price" => 419,
                                    "weight" => 794,
                                ],
                            ],
                        ],
                        "ExtraLarge" => [
                            "Dough Thick" => [
                                "Without bort" => [
                                    "price" => 395,
                                    "weight" => 846,
                                ],
                            ],
                            "Dough Thin" => [
                                "Without bort" => [
                                    "price" => 395,
                                    "weight" => 597,
                                ],
                                "Cheesy" => [
                                    "price" => 460,
                                    "weight" => 836,
                                ],
                                "Hot-Dog" => [
                                    "price" => 486,
                                    "weight" => 912,
                                ],
                            ],
                        ],
                        "XXLarge" => [
                            "Dough Thin" => [
                                "Without bort" => [
                                    "price" => 461,
                                    "weight" => 922,
                                ],
                                "Cheesy" => [
                                    "price" => 541,
                                    "weight" => 1033,
                                ],
                                "Hot-Dog" => [
                                    "price" => 566,
                                    "weight" => 1098,
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    "id" => 2,
                    "productType" => "drink",
                    "cardImage" => "storage/card/cola.png",
                    "resourceRoute" => "home",
                    "title" => "Cola can",
                    "composition" => ["Sugar", "Caffeine"],
                    "labels" => ["+18", "NEW"],
                    "values" => [
                        "330 ml" => [
                            "price" => 57,
                            "weight" => 330,
                        ],
                        "4*330" => [
                            "price" => 188,
                            "weight" => 1320,
                        ],
                    ],
                ],
            ],
        ],
        [
            "title" => "Bestsellers and novelties",
            "products" => [
                [
                    "id" => 1,
                    "productType" => "pizza",
                    "cardImage" => "storage/card/pepperony-y-tomaty.png",
                    "resourceRoute" => "home",
                    "title" => "Pizza Pepperoni with tomatoes",
                    "composition" => ["Mozarella", "Peperoni", "BBQ sauce", "Tomatoes"],
                    "labels" => ["spicy", "cheesy", "vegetarian"],
                    "values" => [
                        "Standard size" => [
                            "Dough Thick" => [
                                "Without bort" => [
                                    "price" => 281,
                                    "weight" => 539,
                                ],
                            ],
                            "Dough Thin" => [
                                "Without bort" => [
                                    "price" => 281,
                                    "weight" => 380,
                                ],
                                "Cheesy" => [
                                    "price" => 330,
                                    "weight" => 512,
                                ],
                                "Hot-Dog" => [
                                    "price" => 368,
                                    "weight" => 588,
                                ],
                            ],
                        ],
                        "Large" => [
                            "Dough Thick" => [
                                "Without bort" => [
                                    "price" => 341,
                                    "weight" => 755,
                                ],
                            ],
                            "Dough Thin" => [
                                "Without bort" => [
                                    "price" => 341,
                                    "weight" => 524,
                                ],
                                "Cheesy" => [
                                    "price" => 389,
                                    "weight" => 728,
                                ],
                                "Hot-Dog" => [
                                    "price" => 419,
                                    "weight" => 794,
                                ],
                            ],
                        ],
                        "ExtraLarge" => [
                            "Dough Thick" => [
                                "Without bort" => [
                                    "price" => 395,
                                    "weight" => 846,
                                ],
                            ],
                            "Dough Thin" => [
                                "Without bort" => [
                                    "price" => 395,
                                    "weight" => 597,
                                ],
                                "Cheesy" => [
                                    "price" => 460,
                                    "weight" => 836,
                                ],
                                "Hot-Dog" => [
                                    "price" => 486,
                                    "weight" => 912,
                                ],
                            ],
                        ],
                        "XXLarge" => [
                            "Dough Thin" => [
                                "Without bort" => [
                                    "price" => 461,
                                    "weight" => 922,
                                ],
                                "Cheesy" => [
                                    "price" => 541,
                                    "weight" => 1033,
                                ],
                                "Hot-Dog" => [
                                    "price" => 566,
                                    "weight" => 1098,
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    "id" => 2,
                    "productType" => "drink",
                    "cardImage" => "storage/card/cola.png",
                    "resourceRoute" => "home",
                    "title" => "Cola can",
                    "composition" => ["Sugar", "Caffeine"],
                    "labels" => ["+18", "NEW"],
                    "values" => [
                        "330 ml" => [
                            "price" => 57,
                            "weight" => 330,
                        ],
                        "4*330" => [
                            "price" => 188,
                            "weight" => 1320,
                        ],
                    ],
                ],
            ],
        ],
    ];
};
?>

<div>
    <livewire:layout.header />
    <livewire:layout.main>
        @foreach ($this->showcases as $data)
            <livewire:blocks.showcase :data="$data" />
        @endforeach
    </livewire:layout.main>
    <livewire:layout.footer />
</div>
