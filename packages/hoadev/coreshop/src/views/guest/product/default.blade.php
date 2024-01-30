@extends('coreblog::layouts.blog')

@section('content')

    <div x-data="{}" class="m-4 md:grid md:grid-cols-2">

        <div class="w-full">
            @php
                $gallery = $post->postMetas->where('key', 'gallery')->first() ?? '';
            @endphp

            @if ($gallery->value)
                <div
                    x-data="{
                        show_light_box: false,
                        currentIndex: 0,
                        prevIndex: 0,
                        images: {},
                        totalImages: 0,
                        imageWidth: 0,
                        nextImage() {

                            this.prevIndex = this.currentIndex;
                            this.currentIndex = (this.currentIndex + 1) % this.totalImages;
                            $refs.carousel.style.transform = 'translateX(-${this.imageWidth}px)';
                            $refs.backgroundImage.src = this.images[this.currentIndex].src;
                            setTimeout(() => {
                                $refs.carousel.appendChild(this.images[this.prevIndex]);
                                $refs.carousel.style.transform = '';
                            }, 500);

                        },
                        initData() {
                            this.images = $refs.carousel.getElementsByTagName('img');

                            this.totalImages = Object.keys(this.images).length;
                            this.imageWidth = $refs.carousel.offsetWidth;
                            console.log(this.totalImages);
                        }
                    }"
                    x-init="initData()"
                    class="relative overflow-hidden transition-all">
                    <img x-ref="backgroundImage" class='absolute top-0 left-0 w-full m-0' />
                    <div
                        x-ref="carousel"
                        :class="show_light_box ? 'fixed top-0 bottom-0 right-0 w-full z-50 justify-center' : ''"
                        class="flex gap-0 bg-gray-100 transition-all">
                        @foreach ($gallery->value as $media)

                            <img src="{{ $media->custom_properties->url }}" class="m-0 transition-all"/>

                        @endforeach
                    </div>
                    <button @click.prevent="show_light_box = !show_light_box" @keyup.esc="show_light_box = false"
                            class="absolute top-0 right-0 bg-gray-800">tog</button>
                    <button class="arrow-button left-arrow">Prev</button>
                    <button @click.prevent="nextImage()" class="arrow-button right-arrow">Next</button>
                </div>
            @elseif($post->getFeatured())
                <a href="{{ $post->getFeaturedImageUrl('large') }}" target="_blank" rel="nofollow">
                    {!! $post->getFeaturedImage('large', $post->title, 'my-0 rounded aspect-square') !!}
                </a>
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
            <div class="entry-summary content-box">{!! $post->excerpt !!}</div>

{{--             @if ($product_type)
                @switch($product_type->value)
                    @case('simple')

                        @includeIf('coreshop::guest.elements.product_single_action.simple')
                        @break

                    @default

                @endswitch
            @endif --}}
            <div class="my-6 md:mx-6 flex flex-col items-center gap-4">
                <a href="/huong-dan-mua-hang"
                    class="w-full py-2 px-8 flex items-center justify-center gap-2 bg-green-800 text-white uppercase font-bold hover:bg-green-600 transition-all rounded-full">
                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="currentColor" stroke="none" viewBox="0 0 24 24"><path d="M21.822 7.431A1 1 0 0 0 21 7H7.333L6.179 4.23A1.994 1.994 0 0 0 4.333 3H2v2h2.333l4.744 11.385A1 1 0 0 0 10 17h8c.417 0 .79-.259.937-.648l3-8a1 1 0 0 0-.115-.921zM17.307 15h-6.64l-2.5-6h11.39l-2.25 6z"></path><circle cx="10.5" cy="19.5" r="1.5"></circle><circle cx="17.5" cy="19.5" r="1.5"></circle></svg>
                    Mua hàng
                </a>
                <a href="/dai-ly-phan-phoi"
                    class="w-full py-2 px-8 flex items-center justify-center gap-2 bg-white text-yellow-600 uppercase font-bold border-2 border-yellow-600 hover:bg-yellow-600 hover:text-white transition-all rounded-full">
                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor"><defs></defs><title>partnership</title><path d="M8,9a4,4,0,1,1,4-4A4,4,0,0,1,8,9ZM8,3a2,2,0,1,0,2,2A2,2,0,0,0,8,3Z" transform="translate(0)"></path><path d="M24,9a4,4,0,1,1,4-4A4,4,0,0,1,24,9Zm0-6a2,2,0,1,0,2,2A2,2,0,0,0,24,3Z" transform="translate(0)"></path><path d="M26,30H22a2,2,0,0,1-2-2V21h2v7h4V19h2V13a1,1,0,0,0-1-1H20.58L16,20l-4.58-8H5a1,1,0,0,0-1,1v6H6v9h4V21h2v7a2,2,0,0,1-2,2H6a2,2,0,0,1-2-2V21a2,2,0,0,1-2-2V13a3,3,0,0,1,3-3h7.58L16,16l3.42-6H27a3,3,0,0,1,3,3v6a2,2,0,0,1-2,2v7A2,2,0,0,1,26,30Z" transform="translate(0)"></path><rect id="_Transparent_Rectangle_" data-name="<Transparent Rectangle>" class="cls-1" width="32" height="32" style="fill:none"></rect></svg>
                    Danh sách đại lý
                </a>
{{--                 <a href="/he-thong-phan-phoi"
                    class="w-full py-3 px-8 bg-yellow-800 text-white text-center uppercase font-bold hover:bg-green-600 rounded-full">Đăng ký đại lý</a> --}}
            </div>

        </div>
    </div>

    <div class="entry-content content-box">
        <h2 class="my-8 text-2xl font-bold uppercase">Mô tả sản phẩm</h2>
        {!! $post->content !!}
    </div>

    @if ($relatedPosts->count() > 0)
        <h2 class="my-6 mx-4 font-bold uppercase text-green-800">Sản phẩm liên quan</h2>
        @includeIf('coreshop::guest.list-product.default', ['posts' => $relatedPosts, 'eager_load_from' => 0])
    @endif
@endsection
