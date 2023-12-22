@extends('coreblog::layouts.blog')

@section('post_title', $post->title)

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
