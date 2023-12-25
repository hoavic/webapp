@extends('coreblog::layouts.blog')

@section('post_title', $post->title)

@if ($post->terms && $post->terms->count() > 0)
    @section('post_meta')
        @foreach ($post->terms as $term)
            <div class="flex gap-2">
                <a href="{{ $term->getPermalink() }}" class="block text-blue-800 hover:text-blue-950 hover:underline">{{ $term->name }}</a>
            </div>
        @endforeach
    @endsection
@endif


@section('content')

    {!! $post->content !!}

    @if ($relatedPosts)
        <h2 class="my-4 font-bold">Related Posts</h2>
        <ul>
            @foreach ($relatedPosts as $relatedPost)
                <li>
                    <a href="{{ $relatedPost->name }}">{{ $relatedPost->title }}</a>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
