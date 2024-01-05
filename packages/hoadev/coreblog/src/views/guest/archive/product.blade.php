@extends('coreblog::layouts.blog')

@section('term_name', $post_type)

@section('content')



    <div
        x-data="{

        }"
        class="my-12 md:px-4 grid grid-cols-2 lg:grid-cols-4 md:gap-4">
        @if ($posts && $posts->count() > 0)
            @foreach ($posts as $post)

                <div class="md:p-4 flex flex-col items-center border border-gray-100 md:rounded-lg hover:shadow-lg">
                    <div class="w-full">
                        @if ($post->getFeatured())
                            <a href="{{ $post->getpermalink() }}"><img src="{{ $post->getFeaturedImageUrl('thumbnail') }}" alt="{{ $post->title }}" class="m-0"></a>
                        @else
                            <span class="block w-full aspect-square bg-green-800/10 md:rounded"></span>
                        @endif

                    </div>

                    <h3 class="mb-0 font-bold uppercase">{{ $post->title }}</h3>
                    <div class="pb-4 text-center">
                        <span class="text-red-700 text-xl font-bold">750.000 đ</span>
                        <div class="mt-4 flex flex-col md:flex-row flex-wrap justify-between gap-4 text-white text-[16px] font-bold transition-all whitespace-nowrap">
                            <a href="#" class="py-2 px-4 bg-green-800 text-white hover:bg-yellow-600 rounded-full">Mua ngay</a>
                            <button type="button" @click.prevent="alert('Tính năng đang phát triển!')"
                                class="py-2 px-4 bg-green-800 hover:bg-yellow-600 rounded-full">Thêm vào giỏ</button>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    {{ $posts->links() }}
@endsection
