<div class="grid gap-4 grid-cols-1 lg:grid-cols-10">

    <main class="w-full lg:col-span-7">
        @hasSection('post_title')
            <h1 class="text-2xl font-bold">@yield('post_title')</h1>
        @endif

        @yield('content')
    </main>

    <aside class="w-full lg:col-span-3">
        @include('coreblog::layouts.blog.aside')
    </aside>

</div>
