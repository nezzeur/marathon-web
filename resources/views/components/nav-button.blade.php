@props([
    'type' => 'submit',
    'href' => null,
    'color' => 'primary',
    'size' => 'md',
    'icon' => null,
    'class' => ''
])

@php
    $baseClasses = 'font-mono font-semibold uppercase transition-all duration-300 active:translate-y-1';

    $sizeClasses = match($size) {
        'sm' => 'text-xs px-3 py-2',
        'md' => 'text-sm px-4 py-3',
        'lg' => 'text-base px-6 py-4',
        default => 'text-sm px-4 py-3'
    };

    $colorClasses = match($color) {
        'primary' => 'bg-primary text-primary-foreground border-b-4 border-black/30 hover:brightness-110',
        'secondary' => 'bg-secondary text-white border-b-4 border-black/30 hover:brightness-110',
        'destructive' => 'bg-red-600 text-white border-b-4 border-black/30 hover:brightness-110',
        'card' => 'bg-card text-white border-b-4 border-black/30 hover:brightness-110',
        'success' => 'bg-green-500 text-white border-b-4 border-black/30 hover:brightness-110',
        default => 'bg-primary text-primary-foreground border-b-4 border-black/30 hover:brightness-110'
    };

    $classes = "$baseClasses $sizeClasses $colorClasses $class";
@endphp

@if($type === 'link')
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <span class="mr-1">{{ $icon }}</span>
        @endif
        {{ $slot }}
    </a>
@elseif($type === 'submit')
    <button type="submit" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <span class="mr-1">{{ $icon }}</span>
        @endif
        {{ $slot }}
    </button>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <span class="mr-1">{{ $icon }}</span>
        @endif
        {{ $slot }}
    </button>
@endif

