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

        <!-- Scripts -->
        @vite(['resources/js/blog.js', 'resources/css/blog.css'])
        @if (strpos(Route::current()->getName(), 'permalink') !== false)
            @include('coreblog::includes.breadcrumbs-json')
        @endif
    </head>
    <body class="font-sans antialiased flex flex-col min-h-screen">

        <header class="site-header sticky top-0 w-full bg-white shadow">
            @include('coreblog::layouts.blog.header')
        </header>

        <div class="bg-[#0e723c]">
            <img src="/uploads/banner-21x9.png" alt="banner" width="21" height="9" loading="lazy" class="w-full max-w-7xl mx-auto my-0"/>
        </div>

        <div class="w-full max-w-7xl h-auto mx-auto">
{{--             @if (strpos(Route::current()->getName(), 'permalink') !== false)
                @include('coreblog::layouts.blog.breadcrumbs', ['data' => ''])
            @endif --}}

            @if(isset($contentStyle))
                @include('coreblog::layouts.blog.content.'.$contentStyle)
            @else
                @include('coreblog::layouts.blog.content.default')
            @endif

        </div>

        <footer class="mt-auto p-4 bg-yellow-700 text-gray-100">
            @include('coreblog::layouts.blog.footer')
        </footer>

    </body>
</html>
