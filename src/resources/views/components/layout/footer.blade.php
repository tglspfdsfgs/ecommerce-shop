<?php

use Livewire\Component;

new class extends Component {};
?>

<footer class="bg-neutral">
    <footer class="page-container footer sm:footer-horizontal bg-neutral text-neutral-content p-10">
        <div>
            <a href="#" class="text-warning mb-2 flex flex-col items-center text-lg">
                <x-assets.logos.logo :class='"h-12 w-12 mb-1"' />
                <span><span class="font-extrabold">Pizza</span><span class="font-semibold italic">Dash</span></span>
            </a>
            <h6 class="footer-title">Payment support</h6>
            <div class="flex gap-2">
                <x-assets.payment-logos.visa />
                <x-assets.payment-logos.mastercard />
            </div>
        </div>
        <nav>
            <h6 class="footer-title">Company</h6>
            <a class="link link-hover">News</a>
            <a class="link link-hover">About us</a>
            <a class="link link-hover">Contact</a>
            <a class="link link-hover">Jobs</a>
        </nav>
        <nav>
            <h6 class="footer-title">Contacts</h6>
            <span>
                <x-assets.contact.email />
                <a href="tel:5555551234" class="link link-hover font-bold">
                    (555) 555-1234
                </a>
            </span>
            <span>
                <x-assets.contact.phone />
                <a href="mailto:pizzadash@email.com" class="link link-hover font-bold">
                    pizzadash@email.com
                </a>
            </span>
            <br />
            <div class="grid grid-flow-col gap-4">
                <a href="https://x.com">
                    <x-assets.socials.twitter />
                </a>
                <a href="https://www.youtube.com/">
                    <x-assets.socials.youtube />
                </a>
                <a href="https://www.facebook.com">
                    <x-assets.socials.facebook />
                </a>
            </div>
            <br />
            <a class="btn btn-wide btn-success">Leave feedback</a>
        </nav>
    </footer>
    <footer class="page-container footer bg-neutral text-neutral-content border-base-300 border-t px-10 py-4">
        <aside class="grid-flow-col items-center">
            <x-assets.logos.hash />
            <p>
                All rights reserved
            </p>
        </aside>
        <nav class="md:place-self-center md:justify-self-end">
            <div class="grid grid-flow-row gap-4 md:grid-flow-col">
                <a>
                    Privacy policy
                </a>
                <span class="max-md:hidden">|</span>
                <a>
                    Information policy
                </a>
                <span class="max-md:hidden">|</span>
                <a>
                    Public offer agreement
                </a>
            </div>
        </nav>
    </footer>
</footer>
