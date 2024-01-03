<div
    x-data="{
        showNav: false,
        atTop: false,
        checkTop() {
            if (window.pageYOffset > $refs.elemettop.offsetTop) {
                this.atTop = true;
            } else {
                this.atTop = false;
            }
        }
    }"
    x-ref="elemettop"
    x-init=""
    :class="{ 'lg:opacity-90': atTop }"
{{--     @scroll.window="atTop = (window.pageYOffset <= 0) ? false : true" --}}
    @scroll.window="checkTop()"
    class="relative w-full max-w-7xl h-auto mx-auto py-1 px-4 lg:flex lg:items-center">

    <div class="flex items-center justify-between">
        @include('coreblog::layouts.blog.logo')
        <button @click="showNav = !showNav"
            class="lg:hidden text-gray-500" aria-label="Toggle Navigation">
            <svg class="w-8 h-8" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22 18.0048C22 18.5544 21.5544 19 21.0048 19H12.9952C12.4456 19 12 18.5544 12 18.0048C12 17.4552 12.4456 17.0096 12.9952 17.0096H21.0048C21.5544 17.0096 22 17.4552 22 18.0048Z" fill="currentColor"></path>
                <path d="M22 12.0002C22 12.5499 21.5544 12.9954 21.0048 12.9954H2.99519C2.44556 12.9954 2 12.5499 2 12.0002C2 11.4506 2.44556 11.0051 2.99519 11.0051H21.0048C21.5544 11.0051 22 11.4506 22 12.0002Z" fill="currentColor"></path>
                <path d="M21.0048 6.99039C21.5544 6.99039 22 6.54482 22 5.99519C22 5.44556 21.5544 5 21.0048 5H8.99519C8.44556 5 8 5.44556 8 5.99519C8 6.54482 8.44556 6.99039 8.99519 6.99039H21.0048Z" fill="currentColor"></path>
            </svg>
        </button>
    </div>
    <div x-show="showNav" @click="showNav = false" class="fixed top-0 bottom-0 right-0 left-0 bg-gray-900/20"></div>
    <nav
        :class="showNav ? 'visible' : 'unvisible lg:visible'"
        class="flex-1">
        <div
            :class="showNav ? 'left-0' : '-left-96 lg:left-0'"
            class="bg-white fixed lg:relative top-0 py-4 lg:py-0 w-72 max-w-9/12 h-screen lg:h-auto transition-all">
            @include('coreblog::layouts.blog.nav')
        </div>
    </nav>

</div>


