    <!-- Twitter Card data -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="{{ config('app.url') }}">
    <meta name="twitter:title" content="{{ $meta_tags->title }}">
    <meta name="twitter:description" content="{{ $meta_tags->description }}">
    <meta name="twitter:creator" content="@author_handle">
    <!-- Twitter summary card with large image must be at least 280x150px -->
    <meta name="twitter:image:src" content="{{ $meta_tags->image }}">
