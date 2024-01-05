<div class="grid gap-4 grid-cols-1 lg:grid-cols-10">

    <main class="w-full lg:col-span-7">
        @hasSection('post_title')
            <header>
                <h1 class="m-4 text-2xl lg:text-3xl font-bold text-green-800">@yield('post_title')</h1>
                @hasSection('post_meta')
                    <div class="entry-meta m-4 text-sm text-gray-600">
                        @yield('post_meta')
                    </div>
                @endif
            </header>
        @endif

        @hasSection('term_name')
            <header class="">
                <h1 class="m-4 text-2xl lg:text-3xl font-bold text-green-800">@yield('term_name')</h1>
            </header>
        @endif

        @yield('content')
    </main>

    <aside class="w-full lg:col-span-3">
        @include('coreblog::layouts.blog.aside')
    </aside>

</div>
