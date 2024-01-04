<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>
        @isset($meta_tags)
            @include('coreblog::guest.head.meta-tags', ['meta_tags' => $meta_tags])
        @endisset
        <!-- Fonts -->
{{--         <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/js/blog.js', 'resources/css/blog.css'])
        @if (strpos(Route::current()->getName(), 'permalink') !== false)
            @include('coreblog::includes.breadcrumbs-json')
        @endif
    </head>
    <body class="antialiased flex flex-col min-h-screen">

        <header class="site-header sticky top-0 w-full bg-white shadow-lg z-40">
            @include('coreblog::layouts.blog.header')
        </header>

        @if (Route::current()->getName() === 'home')

            {{-- <div
                x-data="{
                    sliderWid: 0,
                    sliderScrollWid: 0,
                    currentPosSlide: 0,
                    calcWid() {
                        this.sliderWid = screen.width;
                        this.sliderScrollWid = $refs.myslider.scrollWidth;
                        console.log(this.sliderScrollWid);
                    }
                }"
                x-init="calcWid()"
                class="relative">

                <div x-ref="myslider" class="w-full flex h-auto whitespace-nowrap overflow-x-auto">
                    <div id="item-1" class="inline-block min-w-full">
                        <img src="/uploads/banner-2.png" alt="banner" width="21" height="9" loading="lazy" class="w-full my-0"/>
                    </div>
                    <div id="item-2" class="inline-block min-w-full">
                        <img src="/uploads/banner-1.png" alt="banner" width="21" height="9" loading="lazy" class="w-full my-0"/>
                    </div>
                </div>

                <div class="absolute bottom-0 right-0">
                    <button type="button"
                        class="py-2 px-4 bg-gray-500 rounded-lg">Next</button>
                </div>

            </div> --}}

            @include('coreblog::includes.slider')

            @include('coreblog::includes.promotion')

            @include('coreblog::includes.pickup')

        @endif

        <div class="w-full max-w-7xl h-auto mx-auto">
            @if (strpos(Route::current()->getName(), 'permalink') !== false)
                @include('coreblog::layouts.blog.breadcrumbs')
            @endif

            @if(isset($contentStyle))
                @include('coreblog::layouts.blog.content.'.$contentStyle)
            @else
                @include('coreblog::layouts.blog.content.default')
            @endif

        </div>

        <footer class="mt-auto py-4 bg-gradient-to-r from-white to-yellow-600/20 text-red-900 border-t border-yellow-800 shadow-lg">
            @include('coreblog::layouts.blog.footer')
        </footer>

    </body>
</html>
