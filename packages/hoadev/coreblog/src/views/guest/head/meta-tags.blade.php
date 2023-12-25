@isset($meta_tags)
{{--
    - Title
    - Description
    - Image
    - Timestamp
    - permalink
--}}
    <meta name="description" content="{{ $meta_tags->description }}" />

    <link rel="canonical" href="{{ $meta_tags->canonical }}" />

    @includeIf('coreblog::guest.head.open-graph', ['meta_tags' => $meta_tags])

    @includeIf('coreblog::guest.head.twitter-card', ['meta_tags' => $meta_tags])

    @includeIf('coreblog::guest.head.article', ['meta_tags' => $meta_tags])
@endisset
