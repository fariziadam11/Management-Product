@props([
    'src' => null,
    'alt' => 'User avatar',
    'size' => 'md',
    'status' => null,
    'statusPosition' => 'bottom-right',
    'rounded' => true,
    'bordered' => false,
    'initials' => null,
    'icon' => null,
    'href' => null
])

@php
// Size classes
$sizes = [
    'xs' => 'h-6 w-6 text-xs',
    'sm' => 'h-8 w-8 text-sm',
    'md' => 'h-10 w-10 text-base',
    'lg' => 'h-12 w-12 text-lg',
    'xl' => 'h-16 w-16 text-xl',
    '2xl' => 'h-20 w-20 text-2xl',
];

// Status colors
$statusColors = [
    'online' => 'bg-green-500',
    'offline' => 'bg-gray-400',
    'busy' => 'bg-red-500',
    'away' => 'bg-yellow-500',
    'dnd' => 'bg-red-600'
];

// Status positions
$statusPositions = [
    'top-right' => 'top-0 right-0',
    'top-left' => 'top-0 left-0',
    'bottom-right' => 'bottom-0 right-0',
    'bottom-left' => 'bottom-0 left-0'
];

// Base classes
$baseClasses = 'inline-flex items-center justify-center bg-gray-100 overflow-hidden';
$sizeClass = $sizes[$size] ?? $sizes['md'];
$shapeClass = $rounded ? 'rounded-full' : 'rounded-md';
$borderClass = $bordered ? 'ring-2 ring-white ring-offset-1' : '';

// Status classes
$statusClass = isset($statusColors[$status]) ? $statusColors[$status] : '';
$statusPositionClass = isset($statusPositions[$statusPosition]) ? $statusPositions[$statusPosition] : $statusPositions['bottom-right'];

// Combined classes
$classes = "$baseClasses $sizeClass $shapeClass $borderClass";
@endphp

<div class="relative inline-block">
    @if($href)
        <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
            @if($src)
                <img src="{{ $src }}" alt="{{ $alt }}" class="h-full w-full object-cover">
            @elseif($initials)
                <span class="font-medium text-gray-700 uppercase">{{ $initials }}</span>
            @elseif($icon)
                <i class="bi bi-{{ $icon }} text-gray-500"></i>
            @else
                <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            @endif
        </a>
    @else
        <div {{ $attributes->merge(['class' => $classes]) }}>
            @if($src)
                <img src="{{ $src }}" alt="{{ $alt }}" class="h-full w-full object-cover">
            @elseif($initials)
                <span class="font-medium text-gray-700 uppercase">{{ $initials }}</span>
            @elseif($icon)
                <i class="bi bi-{{ $icon }} text-gray-500"></i>
            @else
                <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            @endif
        </div>
    @endif
    
    @if($status)
        <span class="absolute {{ $statusPositionClass }} block h-2.5 w-2.5 rounded-full {{ $statusClass }} ring-2 ring-white"></span>
    @endif
</div>
