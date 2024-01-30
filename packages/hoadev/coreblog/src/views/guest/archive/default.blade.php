@extends('coreblog::layouts.blog')

@section('term_name', $post_label)

@section('content')

{{--
    {{ $posts }} --}}

<div class="p-4">
    @includeIf('coreblog::guest.list-post.default', ['eager_load_from' => 5])
</div>

    {{ $posts->links() }}
@endsection
