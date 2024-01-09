<div class="">

    <main class="">
        @hasSection('post_title')
            <header>
                <h1 class="mx-4 my-6 text-2xl lg:text-3xl font-bold text-green-800">@yield('post_title')</h1>
                @hasSection('post_meta')
                    <div class="entry-meta m-4 text-sm text-gray-600">
                        @yield('post_meta')
                    </div>
                @endif
            </header>
        @endif

        @hasSection('term_name')
            <header class="">
                <h1 class="mx-4 my-6 text-2xl lg:text-3xl font-bold text-green-800">@yield('term_name')</h1>
            </header>
        @endif

        @yield('content')
    </main>


</div>
