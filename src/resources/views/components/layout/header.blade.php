<?php

use Livewire\Component;

new class extends Component {};
?>

<div class="bg-neutral drawer block">
    <div class="page-container navbar bg-neutral text-neutral-content justify-between">
        <div class="max-md:hidden">
            <button class="btn btn-ghost text-xl">LOGO</button>
        </div>
        <div class="md:hidden">
            <input id="my-drawer-1" type="checkbox" class="drawer-toggle" />
            <div class="drawer-content">
                <label for="my-drawer-1" class="btn btn-circle btn-ghost drawer-button">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-5 w-5 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </label>
            </div>
            <div class="drawer-side">
                <label for="my-drawer-1" aria-label="close sidebar"></label>
                <div class="menu bg-neutral text-neutral-content min-h-full w-screen p-4">
                    <div class="flex justify-between">
                        <div>
                            <button class="btn btn-ghost text-xl">LOGO</button>
                        </div>
                        <label for="my-drawer-1" aria-label="close sidebar" class="button">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </label>
                    </div>
                    <ul class="w-50">
                        <li><a class="text-error">Promo and news</a></li>
                        <li><a>Pizza</a></li>
                        <li><a>Drinks</a></li>
                        <li><a>Sides</a></li>
                        <li><a>Dessert</a></li>
                    </ul>
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
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="badge badge-sm indicator-item badge-error">8</span>
                    </label>
                </div>
                <div class="drawer-side">
                    <label for="my-drawer-5" aria-label="close sidebar" class="drawer-overlay"></label>
                    <div class="menu bg-base-200 text-base-content w-160 min-h-full max-w-full p-4">
                        <div class="relative mb-2 text-center text-xl font-bold">
                            <span>Basket (8)</span>
                            <label for="my-drawer-5" aria-label="close sidebar" class="button absolute right-0 top-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
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
