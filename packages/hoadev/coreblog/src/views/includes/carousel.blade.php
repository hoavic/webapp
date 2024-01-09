<div
    id="slider-main"
    class="relative flex items-center justify-center"
    x-data="{
        current: 0,
        offsetWid: 0,
        scrollWid: 0,
        children: 0,
        childWid: 0,
        setData() {
            this.offsetWid = $refs.scroller.offsetWidth;
            this.scrollWid = $refs.scroller.scrollWidth;
            this.children = $refs.scroller.childElementCount;
            this.childWid = this.scrollWid / this.children;
        },
        nextItem() {
            if(this.current + this.offsetWid >=  this.scrollWid) {
                this.current = 0;
            } else {
                this.current = this.current + this.childWid;
            }
            $refs.scroller.scrollTo(this.current, 0);
            {{-- console.log($refs.scroller.pageXOffset ); --}}
        },
        prevItem() {
            if(this.current <= 0 ) {
                this.current = this.scrollWid - this.offsetWid;
            } else {
                this.current = this.current - this.childWid;
            }
            $refs.scroller.scrollTo(this.current, 0);
            {{-- console.log($refs.scroller.pageXOffset ); --}}
        },
        checkEnd() {
            if(this.current + this.offsetWid >=  this.scrollWid) {
                this.nextItem();
            }
        }
    }"
    x-init="setData()"
    class="w-full overflow-x-auto">
    <ul x-ref="scroller" @ontouchmove="checkEnd()"
        class="relative w-full m-0 flex snap-x snap-mandatory overflow-x-auto scrollbar-hide scroll-smooth bg-green-100">
        <li class="w-full snap-start shrink-0">
            <a href="#" class="">
                <img src="/uploads/banner-2.png"
                    width="1920" height="720" loading="lazy"
                    alt="Go to"
                    class="m-0 xl:object-cover xl:aspect-[25/9]"/>
            </a>
        </li>
        <li class="w-full snap-start shrink-0">
            <a href="#" class="">
                <img src="/uploads/banner-1.png"
                    width="1920" height="720" loading="lazy"
                    alt="Go to"
                    class="m-0 xl:object-cover xl:aspect-[25/9]"/>
            </a>
        </li>
        <li class="w-full snap-start shrink-0">
            <a href="#" class="">
                <img src="/uploads/banner-3.png"
                    width="1920" height="720" loading="lazy"
                    alt="Go to"
                    class="m-0 xl:object-cover xl:aspect-[25/9]"/>
            </a>
        </li>
{{--         <li class="snap-start shrink-0">
            <a href="#" class="">
                <img src="/uploads/banner-4.png"
                    alt="Go to"
                    class=""/>
            </a>
        </li> --}}
    </ul>
    <div class="hidden md:block text-white opacity-80">
        <button @click="nextItem()" aria-label="Next"
            class="absolute top-0 bottom-0 right-0 my-auto p-4 hover:text-yellow-500 drop-shadow-lg">
            <svg class="w-12 h-12 hover:bg-white rounded-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill="currentColor" d="M10,0 C15.5228475,0 20,4.4771525 20,10 C20,15.5228475 15.5228475,20 10,20 C4.4771525,20 0,15.5228475 0,10 C0,4.4771525 4.4771525,0 10,0 Z M10,1.39534884 C5.24778239,1.39534884 1.39534884,5.24778239 1.39534884,10 C1.39534884,14.7522176 5.24778239,18.6046512 10,18.6046512 C14.7522176,18.6046512 18.6046512,14.7522176 18.6046512,10 C18.6046512,5.24778239 14.7522176,1.39534884 10,1.39534884 Z M8.74858635,5.64577005 L12.6187299,9.61728273 C12.8785407,9.88389868 12.8764703,10.3096256 12.6140786,10.5737019 L8.7439351,14.4686937 C8.47852194,14.735811 8.04682076,14.7371924 7.77970352,14.4717792 C7.51258627,14.2063661 7.51120484,13.7746649 7.776618,13.5075477 L11.1738765,10.088477 L7.77196674,6.59746236 C7.50916416,6.3277763 7.51474433,5.89610897 7.78443039,5.6333064 C8.05411645,5.37050382 8.48578378,5.37608399 8.74858635,5.64577005 Z"></path></svg>
        </button>
        <button @click="prevItem()" aria-label="Previous"
            class="absolute top-0 bottom-0 left-0 my-auto p-4 hover:text-yellow-500 drop-shadow-lg">
            <svg class="w-12 h-12 hover:bg-white rounded-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill="currentColor" d="M10,0 C15.5228475,0 20,4.4771525 20,10 C20,15.5228475 15.5228475,20 10,20 C4.4771525,20 0,15.5228475 0,10 C0,4.4771525 4.4771525,0 10,0 Z M10,1.39534884 C5.24778239,1.39534884 1.39534884,5.24778239 1.39534884,10 C1.39534884,14.7522176 5.24778239,18.6046512 10,18.6046512 C14.7522176,18.6046512 18.6046512,14.7522176 18.6046512,10 C18.6046512,5.24778239 14.7522176,1.39534884 10,1.39534884 Z M10.7879967,5.64577005 C11.0507993,5.37608399 11.4824666,5.37050382 11.7521527,5.6333064 C12.0218388,5.89610897 12.0274189,6.3277763 11.7646163,6.59746236 L11.7646163,6.59746236 L8.36270656,10.088477 L11.7599651,13.5075477 C12.0253782,13.7746649 12.0239968,14.2063661 11.7568796,14.4717792 C11.4897623,14.7371924 11.0580611,14.735811 10.792648,14.4686937 L10.792648,14.4686937 L6.92250445,10.5737019 C6.66011276,10.3096256 6.65804237,9.88389868 6.91785319,9.61728273 L6.91785319,9.61728273 Z"></path></svg>
        </button>
    </div>
</div>
