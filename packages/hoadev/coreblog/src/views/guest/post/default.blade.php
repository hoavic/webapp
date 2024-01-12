@extends('coreblog::layouts.blog')

@section('post_title', $post->title)

@php
    if ($post->type === 'page') {
        $contentStyle = 'no-sidebar';
    }
@endphp


@if ($post->terms && $post->terms->count() > 0)
    @section('post_meta')
        <div class="flex gap-2">
            @foreach ($post->terms as $term)
                <a href="{{ $term->getPermalink() }}" class="block hover:underline">{{ $term->name }}</a>
            @endforeach
        </div>
    @endsection
@endif


@section('content')

    <div class="entry-content content-box">
        {!! $post->content !!}
    </div>

    @if ($post->type !== 'page' && $relatedPosts->count() > 0)
        <h2 class="my-6 mx-4 font-bold uppercase text-green-800">Related Posts</h2>
        <ul class="list-none pl-0 grid grid-cols-2 md:grid-cols-3 gap-4 lg:gap-y-6">
            @foreach ($relatedPosts as $relatedPost)
                <li>
                    <a href="{{ $relatedPost->name }}" class="no-underline">
                        @if ($relatedPost->getFeatured())
                            {!! $relatedPost->getFeaturedImage('medium', $relatedPost->title, 'my-0 rounded-lg') !!}
                        @else
                            <span class="aspect-video bg-gray-200 block rounded-lg"></span>
                        @endif
                        <h3 class="mx-0 my-2 text-xl font-bold text-slate-900">{{ $relatedPost->title }}</h3>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
