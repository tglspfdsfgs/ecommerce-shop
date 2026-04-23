<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::home')->name('home');
Route::livewire('/pizza', 'pages::pizza')->name('pizza');
Route::livewire('/drinks', 'pages::drinks')->name('drinks');
Route::livewire('/sides', 'pages::sides')->name('sides');
Route::livewire('/dessert', 'pages::dessert')->name('dessert');
