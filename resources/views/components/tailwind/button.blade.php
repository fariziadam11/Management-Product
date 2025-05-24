@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'disabled' => false,
    'icon' => null,
    'iconPosition' => 'left'
])

@php
$baseClasses = 'inline-flex items-center justify-center font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors';

$variants = [
    'primary' => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500',
    'secondary' => 'bg-gray-600 text-white hover:bg-gray-700 focus:ring-gray-500',
    'success' => 'bg-green-600 text-white hover:bg-green-700 focus:ring-green-500',
    'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
    'warning' => 'bg-yellow-500 text-white hover:bg-yellow-600 focus:ring-yellow-400',
    'info' => 'bg-cyan-600 text-white hover:bg-cyan-700 focus:ring-cyan-500',
    'light' => 'bg-gray-100 text-gray-800 hover:bg-gray-200 focus:ring-gray-300',
    'dark' => 'bg-gray-800 text-white hover:bg-gray-900 focus:ring-gray-600',
    'outline-primary' => 'border-2 border-blue-600 text-blue-600 hover:bg-blue-50 focus:ring-blue-500',
    'outline-danger' => 'border-2 border-red-600 text-red-600 hover:bg-red-50 focus:ring-red-500',
];

$sizes = [
    'xs' => 'px-2.5 py-1.5 text-xs',
    'sm' => 'px-3 py-2 text-sm',
    'md' => 'px-4 py-2 text-sm',
    'lg' => 'px-4 py-2 text-base',
    'xl' => 'px-6 py-3 text-base'
];

$classes = $baseClasses . ' ' . 
          ($variants[$variant] ?? $variants['primary']) . ' ' . 
          ($sizes[$size] ?? $sizes['md']) . ' ' .
          ($disabled ? 'opacity-50 cursor-not-allowed' : '');
@endphp

@if($href)
<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon && $iconPosition === 'left')
        <i class="bi bi-{{ $icon }} mr-2"></i>
    @endif
    {{ $slot }}
    @if($icon && $iconPosition === 'right')
        <i class="bi bi-{{ $icon }} ml-2"></i>
    @endif
</a>
@else
<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }} @if($disabled)disabled @endif>
    @if($icon && $iconPosition === 'left')
        <i class="bi bi-{{ $icon }} mr-2"></i>
    @endif
    {{ $slot }}
    @if($icon && $iconPosition === 'right')
        <i class="bi bi-{{ $icon }} ml-2"></i>
    @endif
</button>
@endif
