<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::home')->name('home');
Route::livewire('/pizzas', 'pages::shop.pizza')->name('pizzas');
Route::livewire('/drinks', 'pages::shop.drinks')->name('drinks');
Route::livewire('/sides', 'pages::shop.sides')->name('sides');
Route::livewire('/desserts', 'pages::shop.dessert')->name('desserts');
