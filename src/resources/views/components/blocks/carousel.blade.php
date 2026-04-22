<div x-data="{
    autoplayIntervalTime: 4000,
    slides: [{
            imgMOB: '{{ asset("storage/carousel/bestprice209-249-slider-mob-eng.png") }}',
            imgPC: '{{ asset("storage/carousel/bestprice209-249-slider-pc-eng.png") }}',
            resource: '#1',
        },
        {
            imgMOB: '{{ asset("storage/carousel/cinnamonrollssale-slider-mob-eng.png") }}',
            imgPC: '{{ asset("storage/carousel/cinnamonrollssale-slider-pc-eng.png") }}',
            resource: '#2',
        },
        {
            imgMOB: '{{ asset("storage/carousel/enjoyandsave169-slider-mob-eng.png") }}',
            imgPC: '{{ asset("storage/carousel/enjoyandsave169-slider-pc-eng.png") }}',
            resource: '#3',
        },
        {
            imgMOB: '{{ asset("storage/carousel/grimbergenambree2xsale-slider-mob-eng.png") }}',
            imgPC: '{{ asset("storage/carousel/grimbergenambree2xsale-slider-pc-eng.png") }}',
            resource: '#4',
        },
        {
            imgMOB: '{{ asset("storage/carousel/more-pizza-slider-mob-eng.png") }}',
            imgPC: '{{ asset("storage/carousel/more-pizza-slider-pc-eng.png") }}',
            resource: '#5',
        },
        {
            imgMOB: '{{ asset("storage/carousel/redbull2x-slider-mob-eng.png") }}',
            imgPC: '{{ asset("storage/carousel/redbull2x-slider-pc-eng.png") }}',
            resource: '#6',
        },
    ],
    currentSlideIndex: 1,
    isPaused: false,
    autoplayInterval: null,
    previous() {
        if (this.currentSlideIndex > 1) {
            this.currentSlideIndex = this.currentSlideIndex - 1
        } else {

            this.currentSlideIndex = this.slides.length
        }
    },
    next() {
        if (this.currentSlideIndex < this.slides.length) {
            this.currentSlideIndex = this.currentSlideIndex + 1
        } else {

            this.currentSlideIndex = 1
        }
    },
    autoplay() {
        this.autoplayInterval = setInterval(() => {
            if (!this.isPaused) {
                this.next()
            }
        }, this.autoplayIntervalTime)
    },

    setAutoplayInterval(newIntervalTime) {
        clearInterval(this.autoplayInterval)
        this.autoplayIntervalTime = newIntervalTime
        this.autoplay()
    },
}" x-init="autoplay" class="relative mb-10 w-full overflow-hidden">

    <div class="aspect-600/400 md:aspect-1280/390 relative mb-3 w-full">
        <template x-for="(slide, index) in slides">
            <div x-cloak x-show="currentSlideIndex == index + 1" class="absolute inset-0" x-transition.opacity.duration.1000ms>

                <a x-bind:href="slide.resource" class="z-1 btn btn-wide btn-lg text-error absolute bottom-4 left-4 border-[#e5e5e5] bg-white max-md:hidden">
                    Details
                </a>

                <img class="rounded-box absolute inset-0 w-full object-cover max-md:hidden" x-bind:src="slide.imgPC" />

                <a x-bind:href="slide.resource">
                    <img class="rounded-box absolute inset-0 w-full object-cover md:hidden" x-bind:src="slide.imgMOB" />
                </a>
            </div>
        </template>
    </div>

    <div class="flex justify-center" role="group" aria-label="slides">
        <template x-for="(slide, index) in slides">
            <button class="btn btn-square btn-xs mx-1" x-on:click="(currentSlideIndex = index + 1), setAutoplayInterval(autoplayIntervalTime)"
                x-bind:class="[currentSlideIndex === index + 1 ? 'btn-error' : '']" x-bind:aria-label="'slide ' + (index + 1)">
            </button>
        </template>
    </div>

</div>
