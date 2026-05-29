<?php

// TODO: add query metadata
// TODO: dynamic values
return [
    'price-sort' => [
        'label' => 'Sort',
        'values' => ['DESC' => 'Price high-low', 'ASC' => 'Price low-high'],
        'component' => 'blocks.filter.inputs.select',
    ],
    'categories' => [
        'label' => 'Categories',
        'values' => [1 => 'Bestsellers and novelties', 2 => 'Best price', 3 => 'Heroes', 4 => 'Wonder', 5 => 'Finest', 6 => 'Gourmet'],
        'component' => 'blocks.filter.inputs.select',
    ],
    'cheese' => [
        'label' => 'Cheese',
        'values' => [0 => 'Bergader Blue', 1 => 'Feta', 2 => 'Mozzarella', 3 => 'Parmesan', 4 => 'Cheddar'],
        'component' => 'blocks.filter.inputs.multiselect',
    ],
    'category' => [
        'label' => 'Category',
        'values' => [1 => 'Dessert', 2 => 'Ice cream'],
        'component' => 'blocks.filter.inputs.radio',
    ],
];
