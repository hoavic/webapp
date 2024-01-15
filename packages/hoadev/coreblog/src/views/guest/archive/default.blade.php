@extends('coreblog::layouts.blog')

@section('term_name', $post_label)

@section('content')

{{--
    {{ $posts }} --}}

<div class="p-4">
    @includeIf('coreblog::guest.list-post.default')
</div>

    {{ $posts->links() }}
@endsection
