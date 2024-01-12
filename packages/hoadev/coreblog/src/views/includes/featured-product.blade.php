<div class="py-4 lg:py-8 bg-white">
    <div
        x-data="{

        }"
        class="max-w-7xl mx-auto">

        <h2 class="mt-4 text-3xl text-center text-green-800 font-bold">SẢN PHẨM</h2>

        @includeIf('coreshop::guest.list-product.default', ['posts' => $products])

        <p class="my-6 text-center font-bold"><a href="{{ config('coreblog.post_types.product.type') }}" class="inline-block py-2 px-8 bg-white text-green-800 border-2 border-green-800 hover:bg-green-800 hover:text-white transition-all rounded-full">Xem tất cả</a></p>

    </div>
</div>
