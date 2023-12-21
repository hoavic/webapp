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

        <header class="site-header sticky top-0 w-full py-2 px-4 flex items-center bg-gray-100 drop-shadow-lg">
            @include('coreblog::layouts.blog.header')
        </header>

        <div class="w-full max-w-7xl h-auto mx-auto">

            @include('coreblog::layouts.blog.breadcrums')

            <div class="flex lg:flex-row gap-4">

                <main class="flex-1">
                    @hasSection('post_title')
                        <h1 class="text-2xl font-bold">@yield('post_title')</h1>
                    @endif

                    @yield('content')
                </main>

                <aside class="w-full lg:w-[320px]">
                    @include('coreblog::layouts.blog.aside')
                </aside>

            </div>

        </div>

        <footer class="mt-auto p-4 bg-slate-900 text-gray-400">
            @include('coreblog::layouts.blog.footer')
        </footer>

    </body>
</html>
