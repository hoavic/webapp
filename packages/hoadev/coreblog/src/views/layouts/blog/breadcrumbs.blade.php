{{-- <p class="py-2 text-sm text-gray-500">Home > Phone > iPhone > iPhone 15</p> --}}
{{-- {{ dd($breadcrumbs) }} --}}
@isset($breadcrumbs)
    <ol class="my-2 flex flex-wrap items-center text-sm text-gray-500 whitespace-nowrap">
        <li>
            <a href="/" class="flex items-center after:content-['>'] after:mx-1 hover:text-green-800" title="Home page">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z"></path>
                    <path d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z"></path>
                </svg>
            </a>
        </li>
        @isset($post)
            <li>
                <a href="/{{ config('coreblog.post_types.'.$post->type.'.archive_page') ?? config('coreblog.post_types.'.$post->type.'.type') }}" class="block py-2 after:content-['>'] after:mx-1 text-yellow-800 hover:text-green-800">
                    {{ config('coreblog.post_types.'.$post->type.'.labels.vietsub') ?? 'Posts Type' }}
                </a>
            </li>
        @endisset
        @foreach ($breadcrumbs->breadcrumbs[0]->itemListElement as $breadcrumb)
            <li>
                @if (isset($breadcrumb->item) && !$loop->last)
                    <a href="{{ $breadcrumb->item }}" class="block py-2 after:content-['>'] after:mx-1 text-yellow-800 hover:text-green-800">{{ $breadcrumb->name }}</a>
                @else
                    {{ $breadcrumb->name }}
                @endif
            </li>
        @endforeach
    </ol>
@endisset
