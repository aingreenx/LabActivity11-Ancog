@props(['name'])

<svg {{ $attributes->merge(['class' => 'h-4 w-4']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor"
     stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    @switch($name)
        @case('eye')
            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/>
            @break
        @case('chat')
            <path d="M21 12a8 8 0 0 1-11.6 7.1L4 20l1-4.6A8 8 0 1 1 21 12Z"/>
            @break
        @case('check')
            <path d="M20 6 9 17l-5-5"/>
            @break
        @case('lock')
            <rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/>
            @break
        @case('search')
            <circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>
            @break
        @case('pin')
            <path d="M12 17v5"/><path d="M9 3h6l-1 6 3 3v2H7v-2l3-3-1-6Z"/>
            @break
        @case('pen')
            <path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>
            @break
        @case('arrow-left')
            <path d="M19 12H5"/><path d="m12 19-7-7 7-7"/>
            @break
        @case('arrow-right')
            <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
            @break
        @case('alert')
            <circle cx="12" cy="12" r="9"/><path d="M12 8v5"/><path d="M12 16h.01"/>
            @break
        @case('user')
            <circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/>
            @break
    @endswitch
</svg>
