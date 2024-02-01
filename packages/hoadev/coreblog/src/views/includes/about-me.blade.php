@php
    $demo = request()->query('demo', 'normal');
@endphp

@if ($demo)
    @switch($demo)
        @case('video-full')
            @includeIf('coreblog::includes.about-me.video-full')
            @break

        @case('video-wide')
            @includeIf('coreblog::includes.about-me.video-wide')
            @break

        @case('video-frame')
            @includeIf('coreblog::includes.about-me.video-frame')
            @break

        @case('video-round')
            @includeIf('coreblog::includes.about-me.video-round')
            @break

        @default
            @includeIf('coreblog::includes.about-me.normal')

    @endswitch

@else
    @includeIf('coreblog::includes.about-me.normal')
@endif

