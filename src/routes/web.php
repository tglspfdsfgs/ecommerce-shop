<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::home')->name('home');
Route::livewire('/pizza', 'pages::shop.pizzas')->name('pizza.list');
Route::livewire('/drink', 'pages::shop.drinks')->name('drink.list');
Route::livewire('/side', 'pages::shop.sides')->name('side.list');
Route::livewire('/dessert', 'pages::shop.dessert')->name('dessert.list');

Route::livewire('/pizza/{slug}', 'pages::product.pizza')->name('pizza.product');
