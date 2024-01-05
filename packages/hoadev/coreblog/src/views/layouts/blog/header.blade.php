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
        <button @click="showNav = !showNav"  aria-label="Menu button"
            class="lg:hidden text-gray-500" aria-label="Toggle Navigation">
            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"><g id="Menu / Menu_Alt_03"><path id="Vector" d="M5 17H13M5 12H19M5 7H13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></g></svg>
        </button>
        @include('coreblog::layouts.blog.logo')
        <button @click.prevent="alert('Tính năng đang phát triển')" aria-label="Search button"
            class="lg:hidden text-gray-500" aria-label="Toggle Navigation">
            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="-2.5 -2.5 24 24" fill="currentColor"><path d="M8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12zm6.32-1.094 3.58 3.58a1 1 0 1 1-1.415 1.413l-3.58-3.58a8 8 0 1 1 1.414-1.414z"></path></svg>
        </button>
    </div>
    <div x-show="showNav" @click="showNav = false" class="fixed top-0 bottom-0 right-0 left-0 bg-gray-900/20"></div>
    <nav
        :class="showNav ? 'visible' : 'unvisible lg:visible'"
        class="flex-1 w-full">
        <div
            :class="showNav ? 'left-0' : '-left-96 lg:left-0'"
            class="bg-white fixed lg:relative top-0 py-4 lg:py-0 w-72 lg:w-full max-w-9/12 h-screen lg:h-auto transition-all">
            @include('coreblog::layouts.blog.nav')
        </div>
    </nav>

</div>


