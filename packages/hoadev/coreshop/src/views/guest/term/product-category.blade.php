@extends('coreblog::layouts.blog')

@section('term_name', $term->name)

@section('content')

<div class="taxonomy-description">
    {!! $term->taxonomy->description !!}
</div>

    <div class="p-4">
        @includeIf('coreshop::guest.list-product.four-column', ['posts' => $posts, 'eager_load_from' => 5])
    </div>

    {{ $posts->links() }}
@endsection
