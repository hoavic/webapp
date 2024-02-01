<div class="pt-4 lg:pt-8 xl:pb-8 bg-gradient-to-b from-green-800/10 to-yellow-500/10">
    <div
        x-data="{

        }"
        class="max-w-7xl mx-auto xl:px-4 text-center">

        <h2
            x-intersect:enter="$el.classList.add('animate-fade-right')"
            x-intersect:leave="$el.classList.remove('animate-fade-right')"
            class="animate-duration-[2000ms] animate-ease-in-out mt-4 text-3xl text-green-800 font-bold">GIÁ TRỊ TỪ SÂM</h2>

        <p
            x-intersect:enter="$el.classList.add('animate-fade-left')"
            x-intersect:leave="$el.classList.remove('animate-fade-left')"
            class="animate-duration-[2000ms] animate-ease-in-out mb-8">Sâm là thảo dược quý từng được dâng vua tiến chúa, được chế biến thành những món ăn đậm hương vị cung đình.</p>

        <video class="xl:mb-4 xl:rounded-2xl xl:drop-shadow-xl" width="1920" height="1080" loop autoplay muted playsinline>
            <source src="/uploads/about-sia-clip.mp4" type="video/mp4" />
            Your browser does not support the video tag.
        </video>

    </div>
</div>
