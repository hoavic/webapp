    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $meta_tags->title }}" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ $meta_tags->canonical }}" />
    @isset($meta_tags->image)
        <meta property="og:image" content="{{ $meta_tags->image }}" />
    @endisset
    <meta property="og:description" content="{!! $meta_tags->description !!}" />
    <meta property="og:site_name" content="{{ config('app.name') }}" />
