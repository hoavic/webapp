@extends('coreblog::layouts.blog')

@section('title', config('app.name'))

@section('content')

{{--     <section class="">
        <div class="w-full aspect-video lg:aspect-[10/4] bg-gray-300 rounded-lg drop-shadow"></div>

    </section> --}}

{{--     <section class="my-4 px-4">
        <ul class="flex flex-wrap gap-4 justify-center">
            @if ($categories && $categories->count() > 0)
                @foreach ($categories as $category)
                    <li>
                        <a href="{{ $category->getPermalink() }}" title="{{ $category->term->name }}" class="block py-2 px-4 text-green-800 hover:text-white font-bold bg-white hover:bg-green-800 border-2 border-green-800 transition-colors rounded-full drop-shadow-lg">{{ $category->term->name }}</a>
                    </li>
                @endforeach
            @endif
        </ul>
    </section> --}}

    <section class="my-6 px-4">
        <h2 class="mx-0 my-6 font-bold text-2xl uppercase text-yellow-800">Bài viết nổi bật</h2>
        {{-- @include('coreblog::includes.post-slide', ['slidePosts' => $newestPosts]) --}}
        @include('coreblog::guest.list-post.four-column', ['posts' => $newestPosts])
    </section>

@endsection
