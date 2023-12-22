<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
{{--         <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> --}}

        <!-- Scripts -->
        @vite(['resources/js/blog.js', 'resources/css/blog.css'])
    </head>
    <body class="font-sans antialiased flex flex-col min-h-screen">

        <header class="site-header sticky top-0 w-full bg-gray-100 drop-shadow-lg">
            @include('coreblog::layouts.blog.header')
        </header>

        <div class="w-full max-w-7xl h-auto mx-auto">
            @if (strpos(Route::current()->getName(), 'permalink') !== false)
                @include('coreblog::layouts.blog.breadcrums')
            @endif

            @if(isset($contentStyle))
                @include('coreblog::layouts.blog.content.'.$contentStyle)
            @else
                @include('coreblog::layouts.blog.content.default')
            @endif

        </div>

        <footer class="mt-auto p-4 bg-slate-900 text-gray-400">
            @include('coreblog::layouts.blog.footer')
        </footer>

    </body>
</html>
