<?php

use Livewire\Component;

new class extends Component {};
?>

<div class="bg-neutral drawer block">
    <div class="page-container navbar bg-neutral text-neutral-content justify-between">
        <div class="max-md:hidden">
            <a href="#" class="text-warning flex items-center">
                <x-assets.logos.logo :class='"h-8 w-8 inline mr-2"' />
                <span class="font-extrabold">Pizza</span><span class="font-semibold italic">Dash</span>
            </a>
        </div>
        <div class="md:hidden">
            <input id="my-drawer-1" type="checkbox" class="drawer-toggle" />
            <div class="drawer-content">
                <label for="my-drawer-1" class="btn btn-circle btn-ghost drawer-button">
                    <x-assets.ui.burger />
                </label>
            </div>
            <div class="drawer-side">
                <label for="my-drawer-1" aria-label="close sidebar"></label>
                <div class="menu bg-neutral text-neutral-content relative min-h-full w-screen p-4 pt-0">
                    <div class="bg-neutral border-base-300 sticky top-0 z-10 flex justify-between border-b py-2">
                        <div>
                            <a href="#" class="text-warning flex items-center">
                                <x-assets.logos.logo :class='"h-8 w-8 inline mr-2"' />
                                <span class="font-extrabold">Pizza</span><span class="font-semibold italic">Dash</span>
                            </a>
                        </div>
                        <label for="my-drawer-1" aria-label="close sidebar" class="button self-center">
                            <x-assets.ui.x-mark />
                        </label>
                    </div>
                    <ul class="w-50 mt-2">
                        <li><a class="text-error">Promo and news</a></li>
                        <li><a>Pizza</a></li>
                        <li><a>Drinks</a></li>
                        <li><a>Sides</a></li>
                        <li><a>Dessert</a></li>
                    </ul>
                    <livewire:layout.footer />
                </div>

            </div>
        </div>
        <div class="max-md:hidden">
            <ul class="menu menu-horizontal px-1">
                <li><a class="text-error">Promo and news</a></li>
                <li><a>Pizza</a></li>
                <li><a>Drinks</a></li>
                <li><a>Sides</a></li>
                <li><a>Dessert</a></li>
            </ul>
        </div>
        <div class="flex">
            <div class="drawer drawer-end mr-3">
                <input id="my-drawer-5" type="checkbox" class="drawer-toggle" />
                <div class="drawer-content">
                    <label for="my-drawer-5" class="drawer-button btn btn-ghost btn-circle indicator">
                        <x-assets.ui.basket />
                        <span class="badge badge-sm indicator-item badge-error">8</span>
                    </label>
                </div>
                <div class="drawer-side">
                    <label for="my-drawer-5" aria-label="close sidebar" class="drawer-overlay"></label>
                    <div class="menu bg-base-200 text-base-content w-160 min-h-full max-w-full p-4">
                        <div class="relative mb-2 text-center text-xl font-bold">
                            <span>Basket (8)</span>
                            <label for="my-drawer-5" aria-label="close sidebar" class="button absolute right-0 top-0">
                                <x-assets.ui.x-mark />
                            </label>
                        </div>
                        <hr class="mb-2" />
                        <div class="text-center text-lg">Basket is empty</div>
                    </div>
                </div>
            </div>
            <button class="btn btn-sm hidden">
                Login
            </button>
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full">
                        <img alt="Tailwind CSS Navbar component" src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
                    </div>
                </div>
                <ul tabindex="-1" class="menu menu-sm dropdown-content bg-base-100 text-base-content rounded-box z-1 mt-3 w-52 p-2 shadow">
                    <li><a>Profile</a></li>
                    <li><a>Settings</a></li>
                    <li><a>Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
