@extends('coreblog::layouts.blog')

@section('title', config('app.name'))

@section('content')

{{--     <section class="">
        <div class="w-full aspect-video lg:aspect-[10/4] bg-gray-300 rounded-lg drop-shadow"></div>

    </section> --}}

    <section class="my-4 px-4">
        <ul class="flex flex-wrap gap-4 justify-center">
            @if ($categories && $categories->count() > 0)
                @foreach ($categories as $category)
                    <li>
                        {{-- <a href="{{ $category->getPermalink() }}" title="{{ $category->term->name }}" class="block py-2 px-4 bg-indigo-800 hover:bg-indigo-950 text-white transition-colors rounded-full drop-shadow-lg">{{ $category->term->name }}</a> --}}
                        <a href="{{ $category->getPermalink() }}" title="{{ $category->term->name }}" class="block py-2 px-4 text-green-800 hover:text-white font-bold bg-white hover:bg-green-800 border-2 border-green-800 transition-colors rounded-full drop-shadow-lg">{{ $category->term->name }}</a>
                    </li>
                @endforeach
            @endif
        </ul>
    </section>

    <section class="my-4 px-4">
        <h2 class="font-bold">Newest Posts</h2>
        @include('coreblog::includes.post-slide', ['slidePosts' => $newestPosts])
    </section>

@endsection
