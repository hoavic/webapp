<div class="pt-4 lg:py-8 xl:py-12 bg-gradient-to-b from-green-800/10 to-yellow-500/10">
    <div
        x-data="{

        }"
        class="max-w-7xl mx-auto 2xl:px-4 text-center">

        <div class="group lg:px-4 xl:px-0 grid grid-cols-1 lg:grid-cols-2 md:gap-4 items-center text-green-800 text-md transition-all duration-500">

            <div class="text-center">
                <img
                    x-intersect:enter="$el.classList.add('animate-fade-up')"
                    x-intersect:leave="$el.classList.remove('animate-fade-up')"
                    src="/uploads/cay-sam.svg" alt="Giá trị của cây sâm" width="200" height="200" class="mx-auto h-48 group-hover:brightness-110 transition-all"  loading="lazy"/>
                <h2
                    x-intersect:enter="$el.classList.add('animate-fade-right')"
                    x-intersect:leave="$el.classList.remove('animate-fade-right')"
                    class="mt-4 text-3xl text-green-800 font-bold">GIÁ TRỊ TỪ SÂM</h2>
                <p
                    x-intersect:enter="$el.classList.add('animate-fade-left')"
                    x-intersect:leave="$el.classList.remove('animate-fade-left')"
                    class="mb-8">Sâm Abelmoschus Sagittifolius thảo dược quý từ thiên nhiên.</p>
            </div>

            <div class="text-right">
                <video class="lg:border-8 lg:border-green-800 lg:rounded-full lg:drop-shadow-xl" width="1920" height="1080" loop autoplay muted playsinline>
                    <source src="/uploads/about-sia-clip.mp4" type="video/mp4" />
                    Your browser does not support the video tag.
                </video>
            </div>

        </div>



    </div>
</div>
