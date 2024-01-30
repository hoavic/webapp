<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @if ($posts && $posts->count() > 0)
        @foreach ($posts as $post)
            <article class="border border-gray-200 rounded-lg hover:shadow-lg">
                @if ($post->getFeatured())
                    <a href="{{ $post->getpermalink() }}">
                        {{-- <img src="{{ $post->getFeaturedImageUrl('large') }}" alt="{{ $post->title }}" class="m-0 object-cover aspect-[3/2]"> --}}
                        {!! $post->getFeaturedImage('medium', $post->title, 'm-0 object-cover aspect-[3/2] rounded-t-md', '(max-width: 430px) 95vw, (max-width: 850px) 48vw, 280px', $loop->iteration < $eager_load_from ? 'eager' : 'lazy') !!}
                    </a>
                @endif
                <h2 class="font-bold leading-4">
                    <a href="{{ $post->getpermalink() }}" class="text-xl no-underline">{{ $post->title }}</a>
                </h2>
                <p class="entry-summary text-gray-600">
                    {!! $post->getExcerpt(20) !!}
                </p>
            </article>
        @endforeach
    @endif
</div>
