@extends('coreblog::layouts.blog')

{{-- @section('post_title', $post->title) --}}

@section('content')

    {!! $term->name !!}
{{--
    {{ $posts }} --}}

    <div class="">
        @if ($posts && $posts->count() > 0)
            @foreach ($posts as $post)
                <article>
                    <header>

                    </header>
                    <div class="entry-summary my-2">
                        {{ $post->getExcerpt() }}
                    </div>
                </article>
            @endforeach
        @endif

    </div>
@endsection
