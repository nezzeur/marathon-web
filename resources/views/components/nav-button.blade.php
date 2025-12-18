@props([
    'type' => 'button',
    'color' => 'primary',
    'size' => 'md',
    'icon' => null,
    'fullWidth' => false,
    'class' => ''
])

@php
    $colorClasses = [
        'primary' => 'bg-primary text-primary-foreground hover:brightness-110 border-b-4 border-black/30 active:border-b-0 active:translate-y-1',
        'secondary' => 'bg-secondary text-secondary-foreground hover:brightness-110 border-b-4 border-black/30 active:border-b-0 active:translate-y-1',
        'destructive' => 'bg-destructive text-destructive-foreground hover:brightness-110 border-b-4 border-black/30 active:border-b-0 active:translate-y-1',
        'green' => 'bg-green-500 text-white hover:brightness-110 border-b-4 border-black/30 active:border-b-0 active:translate-y-1',
        'card' => 'bg-card text-foreground',
    ];
    $sizeClasses = [
        'sm' => 'text-xs px-3 py-2',
        'md' => 'text-xs px-4 py-3',
        'lg' => 'text-sm px-6 py-3',
    ];
    $colorClass = $colorClasses[$color] ?? $colorClasses['primary'];
    $sizeClass = $sizeClasses[$size] ?? $colorClasses['md'];
    $widthClass = $fullWidth ? 'w-full block' : 'inline-block';
    $finalClass = trim("font-mono {$sizeClass} {$colorClass} {$widthClass} hover:animate-glow-pulse {$class}");
@endphp

@if($type === 'link')
    <a {{ $attributes->merge(['class' => $finalClass]) }}>
        @if($icon) <span class="mr-1">{{ $icon }}</span> @endif
        <span class="uppercase">{{ $slot }}</span>
    </a>
@elseif($type === 'button' || $type === 'submit')
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $finalClass]) }}>
        @if($icon) <span class="mr-1">{{ $icon }}</span> @endif
        <span class="uppercase">{{ $slot }}</span>
    </button>
@else
    <div {{ $attributes->merge(['class' => $finalClass]) }}>
        @if($icon) <span class="mr-1">{{ $icon }}</span> @endif
        <span class="uppercase">{{ $slot }}</span>
    </div>
@endif
