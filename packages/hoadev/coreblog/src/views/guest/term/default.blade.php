@extends('coreblog::layouts.blog')

@section('term_name', $term->name)

@section('content')

<div class="taxonomy-description">
    {!! $term->taxonomy->description !!}
</div>

{{--
    {{ $posts }} --}}

    <div class="md:p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @if ($posts && $posts->count() > 0)
            @foreach ($posts as $post)
                <article class="border border-gray-200">
                    <div class="">
                        @if ($post->getFeatured())
                            <a href="{{ $post->getpermalink() }}"><img src="{{ $post->getFeaturedImageUrl('large') }}" alt="{{ $post->title }}" class="m-0"></a>
                        @endif
                    </div>
                    <div class="">
                        <h2 class="font-bold text-blue-800">
                            <a href="{{ $post->getpermalink() }}">{{ $post->title }}</a>
                        </h2>
                        <p class="entry-summary">
                            {{ $post->getExcerpt(20) }}
                        </p>
                    </div>
                </article>
            @endforeach
        @endif
    </div>

    {{ $posts->links() }}
@endsection
