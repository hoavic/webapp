<div class="bg-gradient-to-r from-black via-black to-black">
    <div
        x-data="{

        }"
            x-intersect:enter="$el.classList.add('animate-fade')"
            x-intersect:leave="$el.classList.remove('animate-fade')"
            class="animate-duration-[2000ms] animate-ease-in-out relative w-full aspect-video text-center">

        <video width="1920" height="1080" loop autoplay muted playsinline>
            <source src="/uploads/about-sia-clip.mp4" type="video/mp4" />
            Your browser does not support the video tag.
        </video>

    </div>
</div>
