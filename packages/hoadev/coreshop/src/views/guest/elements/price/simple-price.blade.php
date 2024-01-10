@isset($post->variants[0])
    <span class="text-red-700 text-xl font-bold">{{ $post->variants[0]->getPrice() }}</span>
@endisset

