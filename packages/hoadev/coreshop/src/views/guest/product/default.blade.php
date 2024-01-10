@extends('coreblog::layouts.blog')

@section('content')

    <div x-data="{}" class="m-4 md:grid md:grid-cols-2">

        <div class="w-full" @click.prevent="alert('Tính năng đang phát triển!')">
            @php
                $gallery = $post->postMetas->where('key', 'gallery')->first() ?? '';
            @endphp

            @if ($gallery)
                <span class="block aspect-square bg-gray-100 rounded-lg">Gallery</span>
            @elseif($post->getFeatured())
                {!! $post->getFeaturedImage('medium_large', $post->title, 'my-0 rounded aspect-square') !!}
            @else
                <span class="block aspect-square bg-green-50 border border-green-900/10 rounded-lg"></span>
            @endif

        </div>

        <div class="">
            <h1 class="my-6 md:mx-6 font-bold text-2xl">{{ $post->title }}</h1>
            <div class="my-4 md:mx-6">
                @php
                    $product_type = $post->postMetas->where('key', 'product_type')->first() ?? '';
                @endphp

                @if ($product_type)
                    @switch($product_type->value)
                        @case('simple')

                            @includeIf('coreshop::guest.elements.price.simple-price')
                            @break

                        @default
                            <span class="text-red-700 text-xl font-bold">{{ $product_type }}</span>
                    @endswitch
                @endif

            </div>
            <div class="entry-summary">{!! $post->excerpt !!}</div>

            @if ($product_type)
                @switch($product_type->value)
                    @case('simple')

                        @includeIf('coreshop::guest.elements.product_single_action.simple')
                        @break

                    @default

                @endswitch
            @endif


        </div>
    </div>

    <div class="entry-content">
        <h2 class="my-6 text-2xl font-bold uppercase">Mô tả sản phẩm</h2>
        {!! $post->content !!}
    </div>

    @if ($relatedPosts->count() > 0)
        <h2 class="my-6 mx-4 font-bold uppercase text-green-800">Sản phẩm liên quan</h2>
        @includeIf('coreshop::guest.list-product.default', ['posts' => $relatedPosts])
    @endif
@endsection
