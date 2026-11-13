@props(['name', 'size' => 'md'])

@php
    $parts = preg_split('/\s+/', trim($name));
    $initials = mb_strtoupper(mb_substr($parts[0], 0, 1) . (count($parts) > 1 ? mb_substr(end($parts), 0, 1) : ''));
    $sizes = [
        'sm' => 'h-8 w-8 text-xs',
        'md' => 'h-10 w-10 text-sm',
        'lg' => 'h-16 w-16 text-xl',
    ];
@endphp

<span {{ $attributes->class(['inline-grid shrink-0 place-items-center rounded-full bg-brand-soft font-semibold text-brand', $sizes[$size]]) }} aria-hidden="true">{{ $initials }}</span>
