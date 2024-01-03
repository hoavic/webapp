<div class="">

    <main class="">
        @hasSection('post_title')
            <h1 class="m-4 text-2xl lg:text-3xl font-bold text-green-800">@yield('post_title')</h1>
        @endif

        @yield('content')
    </main>


</div>
