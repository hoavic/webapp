@extends('coreblog::layouts.blog')

@section('term_name', $post_label)

@section('content')

    {{-- <div
        x-data="{

        }"
        class="my-8 md:px-4 grid grid-cols-2 lg:grid-cols-4 md:gap-4">
        @if ($posts && $posts->count() > 0)
            @foreach ($posts as $post)

                <div class="md:p-4 flex flex-col items-center border border-gray-100 md:rounded-lg hover:shadow-lg">
                    <a href="{{ $post->getpermalink() }}" class="block w-full no-underline">
                        @if ($post->getFeatured())
                            <img src="{{ $post->getFeaturedImageUrl('thumbnail') }}" alt="{{ $post->title }}" class="m-0">
                        @else
                            <span class="block w-full aspect-square bg-green-800/10 md:rounded"></span>
                        @endif
                        <h3 class="mb-0 font-bold uppercase  text-gray-900 text-center">{{ $post->title }}</h3>
                    </a>

                    <div class="pb-4 text-center">

                        @php
                            $product_type = $post->postMetas->where('key', 'product_type')->first() ?? '';
                        @endphp

                        @if ($product_type)
                            @switch($product_type->value)
                                @case('simple')
                                    <span class="text-red-700 text-xl font-bold">{{ $post->variants[0]->getPrice() }}</span>
                                    @break

                                @default
                                    <span class="text-red-700 text-xl font-bold">{{ $product_type }}</span>
                            @endswitch
                        @endif

                        <div class="mt-4 flex flex-col md:flex-row flex-wrap justify-between gap-4 text-white text-[16px] font-bold transition-all whitespace-nowrap">
                            <a href="{{ $post->getPermalink() }}" @click.prevent="alert('Tính năng đang phát triển!')"
                                class="py-2 px-4 no-underline bg-green-800 text-white hover:bg-yellow-600 hover:text-white rounded-full">Mua ngay</a>
                            <button type="button" @click.prevent="alert('Tính năng đang phát triển!')"
                                class="py-2 px-4 bg-green-800 hover:bg-yellow-600 rounded-full">Thêm vào giỏ</button>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div> --}}

    <div class="px-4">
        @includeIf('coreshop::guest.list-product.four-column')
    </div>


    {{ $posts->links() }}
@endsection
