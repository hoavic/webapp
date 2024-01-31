@extends('coreblog::layouts.blog')

@section('content')

    <div x-data="{}" class="m-4 md:grid md:grid-cols-2">

        <div class="relative w-full">
            @php
                $gallery = $post->postMetas->where('key', 'gallery')->first() ?? '';
            @endphp

            @if ($gallery->value)
                <div
                    x-ref="carousel_container"
                    @keyup.esc="hideLightBox()"
                    x-data="{
                        show_light_box: false,
                        currentIndex: 0,
                        currentScroll: 0,
                        images: {},
                        imageThumbnails: {},
                        totalImages: 0,
                        nextImage() {
                            if(this.currentIndex >= (this.totalImages - 1)) {
                                this.moveToImageIndex(0);
                            } else {
                                this.moveToImageIndex(this.currentIndex + 1);
                            }
                        },
                        prevImage() {
                            if(this.currentIndex <= 0) {
                                this.moveToImageIndex(this.totalImages - 1);
                            } else {
                                this.moveToImageIndex(this.currentIndex - 1)
                            }
                        },
                        initData() {
                            this.images = $refs.carousel.getElementsByTagName('img');
                            this.totalImages = this.images.length;
                            this.imageThumbnails = $refs.carousel_thumb.getElementsByTagName('img');
                        },
                        showLightBox() {
                            this.show_light_box = true;
                            this.moveToImageIndex(0);
                        },
                        hideLightBox() {
                            this.show_light_box = false;
                            this.moveToImageIndex(0);
                        },
                        moveToImageIndex(index) {
                            this.currentIndex = index;
                            $refs.carousel.scrollTo($refs.carousel.scrollWidth/this.totalImages * this.currentIndex, 0);
                            [...this.imageThumbnails].forEach((image) => {
                                image.classList.remove('border-4');
                                image.classList.remove('rounded-lg');
                            });
                            this.imageThumbnails[this.currentIndex].classList.add('border-4');
                            this.imageThumbnails[this.currentIndex].classList.add('rounded-lg');
                        }
                    }"
                    x-init="initData()"

                    >
                    <div
                        :class="show_light_box ? 'fixed top-0 bottom-0 right-0 w-full z-50' : ''"
                        class="overflow-hidden transition-all">
                        <div
                            x-ref="carousel"
                            :class="show_light_box ? '' : ''"
                            class="flex flex-nowrap overflow-x-auto overflow-y-hidden scroll-smooth scrollbar-hide snap-x snap-mandatory gap-0 bg-gray-100 duration-100 transition-all">
                            @foreach ($gallery->value as $media)
                                <div :class="show_light_box ? 'h-screen flex items-center justify-center bg-black' : ''" class="flex-none w-full snap-start transition-all">
                                    <img src="{{ $media->custom_properties->url }}" @if($loop->index !== 0) loading="lazy" @endif class="block m-0 lg:h-full"/>
                                </div>
                            @endforeach
                        </div>

                        <div
                            x-show="show_light_box"
                            x-ref="carousel_thumb"
                            :class="show_light_box ? 'justify-center' : ''"
                            class="absolute bottom-4 left-0 right-0 mx-auto flex flex-wrap overflow-x-auto scroll-smooth gap-2 duration-100 transition-all">
                            @foreach ($gallery->value as $media)
                                <img @click.prevent="moveToImageIndex({{ $loop->index }})" src="{{ $media->custom_properties->url }}" loading="lazy" class="m-0 w-20 @if($loop->index === 0) border-4 @endif border-green-800 transition-all"/>
                            @endforeach
                        </div>

                        <button x-show="!show_light_box" @click.prevent="showLightBox()"
                                class="absolute top-0 right-0 text-white bg-gray-800/20 z-50">
                            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 1024" fill="currentColor"><path d="M290 236.4l43.9-43.9a8.01 8.01 0 0 0-4.7-13.6L169 160c-5.1-.6-9.5 3.7-8.9 8.9L179 329.1c.8 6.6 8.9 9.4 13.6 4.7l43.7-43.7L370 423.7c3.1 3.1 8.2 3.1 11.3 0l42.4-42.3c3.1-3.1 3.1-8.2 0-11.3L290 236.4zm352.7 187.3c3.1 3.1 8.2 3.1 11.3 0l133.7-133.6 43.7 43.7a8.01 8.01 0 0 0 13.6-4.7L863.9 169c.6-5.1-3.7-9.5-8.9-8.9L694.8 179c-6.6.8-9.4 8.9-4.7 13.6l43.9 43.9L600.3 370a8.03 8.03 0 0 0 0 11.3l42.4 42.4zM845 694.9c-.8-6.6-8.9-9.4-13.6-4.7l-43.7 43.7L654 600.3a8.03 8.03 0 0 0-11.3 0l-42.4 42.3a8.03 8.03 0 0 0 0 11.3L734 787.6l-43.9 43.9a8.01 8.01 0 0 0 4.7 13.6L855 864c5.1.6 9.5-3.7 8.9-8.9L845 694.9zm-463.7-94.6a8.03 8.03 0 0 0-11.3 0L236.3 733.9l-43.7-43.7a8.01 8.01 0 0 0-13.6 4.7L160.1 855c-.6 5.1 3.7 9.5 8.9 8.9L329.2 845c6.6-.8 9.4-8.9 4.7-13.6L290 787.6 423.7 654c3.1-3.1 3.1-8.2 0-11.3l-42.4-42.4z"></path></svg>
                        </button>
                        <button x-show="show_light_box" @click.prevent="hideLightBox()"
                                class="absolute top-0 right-0 text-white bg-gray-800/20 z-50">
                            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 1024" fill="currentColor"><path d="M391 240.9c-.8-6.6-8.9-9.4-13.6-4.7l-43.7 43.7L200 146.3a8.03 8.03 0 0 0-11.3 0l-42.4 42.3a8.03 8.03 0 0 0 0 11.3L280 333.6l-43.9 43.9a8.01 8.01 0 0 0 4.7 13.6L401 410c5.1.6 9.5-3.7 8.9-8.9L391 240.9zm10.1 373.2L240.8 633c-6.6.8-9.4 8.9-4.7 13.6l43.9 43.9L146.3 824a8.03 8.03 0 0 0 0 11.3l42.4 42.3c3.1 3.1 8.2 3.1 11.3 0L333.7 744l43.7 43.7A8.01 8.01 0 0 0 391 783l18.9-160.1c.6-5.1-3.7-9.4-8.8-8.8zm221.8-204.2L783.2 391c6.6-.8 9.4-8.9 4.7-13.6L744 333.6 877.7 200c3.1-3.1 3.1-8.2 0-11.3l-42.4-42.3a8.03 8.03 0 0 0-11.3 0L690.3 279.9l-43.7-43.7a8.01 8.01 0 0 0-13.6 4.7L614.1 401c-.6 5.2 3.7 9.5 8.8 8.9zM744 690.4l43.9-43.9a8.01 8.01 0 0 0-4.7-13.6L623 614c-5.1-.6-9.5 3.7-8.9 8.9L633 783.1c.8 6.6 8.9 9.4 13.6 4.7l43.7-43.7L824 877.7c3.1 3.1 8.2 3.1 11.3 0l42.4-42.3c3.1-3.1 3.1-8.2 0-11.3L744 690.4z"></path></svg>
                        </button>
                        <button @click.prevent="prevImage()" class="absolute left-0 top-0 bottom-0 my-auto text-white">
                            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><polyline fill="none" stroke="currentColor" stroke-width="2" points="7 2 17 12 7 22" transform="matrix(-1 0 0 1 24 0)"></polyline></svg>
                        </button>
                        <button @click.prevent="nextImage()" class="absolute right-0 top-0 bottom-0 my-auto text-white">
                            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><polyline fill="none" stroke="currentColor" stroke-width="2" points="7 2 17 12 7 22"></polyline></svg>
                        </button>
                    </div>


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
