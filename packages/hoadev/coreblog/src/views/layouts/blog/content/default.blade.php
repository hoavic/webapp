<div class="grid gap-4 grid-cols-1 lg:grid-cols-10">

    <main class="w-full lg:col-span-7">
        @hasSection('post_title')
            <header>
                <h1 class="my-4 text-2xl font-bold">@yield('post_title')</h1>
                @hasSection('post_meta')
                    <div class="entry-meta my-4">
                        @yield('post_meta')
                    </div>
                @endif
            </header>
        @endif

        @hasSection('term_name')
            <header class="px-4">
                <h1 class="my-4 text-2xl font-bold">@yield('term_name')</h1>
            </header>
        @endif

        @yield('content')
    </main>

    <aside class="w-full lg:col-span-3">
        @include('coreblog::layouts.blog.aside')
    </aside>

</div>
