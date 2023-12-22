<div class="">

    <main class="">
        @hasSection('post_title')
            <h1 class="text-2xl font-bold">@yield('post_title')</h1>
        @endif

        @yield('content')
    </main>


</div>
