@props([
    'variant' => 'primary',
    'size' => 'md',
    'rounded' => true,
    'icon' => null,
    'dot' => false,
    'outline' => false,
    'removable' => false,
    'href' => null,
    'pulse' => false,
    'uppercase' => false,
    'count' => null,
    'notification' => false,
    'clickable' => false
])

@php
// Solid variants - enhanced with more vibrant colors
$solidVariants = [
    'primary' => 'bg-blue-100 text-blue-800 border border-blue-200',
    'secondary' => 'bg-gray-100 text-gray-800 border border-gray-200',
    'success' => 'bg-green-100 text-green-800 border border-green-200',
    'danger' => 'bg-red-100 text-red-800 border border-red-200',
    'warning' => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
    'info' => 'bg-cyan-100 text-cyan-800 border border-cyan-200',
    'light' => 'bg-gray-100 text-gray-800 border border-gray-200',
    'dark' => 'bg-gray-800 text-white border border-gray-700',
    'purple' => 'bg-purple-100 text-purple-800 border border-purple-200',
    'pink' => 'bg-pink-100 text-pink-800 border border-pink-200',
    'indigo' => 'bg-indigo-100 text-indigo-800 border border-indigo-200',
    'teal' => 'bg-teal-100 text-teal-800 border border-teal-200'
];

// Solid variants - more intense for notifications and highlights
$intenseSolidVariants = [
    'primary' => 'bg-blue-600 text-white border border-blue-700',
    'secondary' => 'bg-gray-600 text-white border border-gray-700',
    'success' => 'bg-green-600 text-white border border-green-700',
    'danger' => 'bg-red-600 text-white border border-red-700',
    'warning' => 'bg-yellow-500 text-white border border-yellow-600',
    'info' => 'bg-cyan-600 text-white border border-cyan-700',
    'light' => 'bg-gray-200 text-gray-800 border border-gray-300',
    'dark' => 'bg-gray-900 text-white border border-black',
    'purple' => 'bg-purple-600 text-white border border-purple-700',
    'pink' => 'bg-pink-600 text-white border border-pink-700',
    'indigo' => 'bg-indigo-600 text-white border border-indigo-700',
    'teal' => 'bg-teal-600 text-white border border-teal-700'
];

// Outline variants
$outlineVariants = [
    'primary' => 'bg-transparent border border-blue-500 text-blue-700 hover:bg-blue-50',
    'secondary' => 'bg-transparent border border-gray-500 text-gray-700 hover:bg-gray-50',
    'success' => 'bg-transparent border border-green-500 text-green-700 hover:bg-green-50',
    'danger' => 'bg-transparent border border-red-500 text-red-700 hover:bg-red-50',
    'warning' => 'bg-transparent border border-yellow-500 text-yellow-700 hover:bg-yellow-50',
    'info' => 'bg-transparent border border-cyan-500 text-cyan-700 hover:bg-cyan-50',
    'light' => 'bg-transparent border border-gray-300 text-gray-700 hover:bg-gray-50',
    'dark' => 'bg-transparent border border-gray-800 text-gray-800 hover:bg-gray-100',
    'purple' => 'bg-transparent border border-purple-500 text-purple-700 hover:bg-purple-50',
    'pink' => 'bg-transparent border border-pink-500 text-pink-700 hover:bg-pink-50',
    'indigo' => 'bg-transparent border border-indigo-500 text-indigo-700 hover:bg-indigo-50',
    'teal' => 'bg-transparent border border-teal-500 text-teal-700 hover:bg-teal-50'
];

// Dot colors
$dotColors = [
    'primary' => 'bg-blue-500',
    'secondary' => 'bg-gray-500',
    'success' => 'bg-green-500',
    'danger' => 'bg-red-500',
    'warning' => 'bg-yellow-500',
    'info' => 'bg-cyan-500',
    'light' => 'bg-gray-300',
    'dark' => 'bg-gray-800',
    'purple' => 'bg-purple-500',
    'pink' => 'bg-pink-500',
    'indigo' => 'bg-indigo-500',
    'teal' => 'bg-teal-500'
];

// Sizes
$sizes = [
    'xs' => 'px-1.5 py-0.5 text-xs',
    'sm' => 'px-2 py-0.5 text-xs',
    'md' => 'px-2.5 py-0.5 text-sm',
    'lg' => 'px-3 py-1 text-base'
];

// Base classes
$baseClasses = 'inline-flex items-center justify-center font-medium';

// Shape
$shapeClass = $rounded ? ' rounded-full' : ' rounded';

// Variant - use intense variants for notifications
$variantClass = $outline 
    ? ($outlineVariants[$variant] ?? $outlineVariants['primary']) 
    : ($notification 
        ? ($intenseSolidVariants[$variant] ?? $intenseSolidVariants['primary'])
        : ($solidVariants[$variant] ?? $solidVariants['primary']));

// Size
$sizeClass = $sizes[$size] ?? $sizes['md'];

// Animation
$animationClass = $pulse ? ' animate-pulse' : '';

// Text transform
$textTransformClass = $uppercase ? ' uppercase tracking-wide' : '';

// Clickable
$clickableClass = $clickable ? ' cursor-pointer hover:shadow-sm transition-all duration-150' : '';

// Combine all classes
$classes = $baseClasses . ' ' . $variantClass . ' ' . $sizeClass . ' ' . $shapeClass . ' ' . $animationClass . ' ' . $textTransformClass . ' ' . $clickableClass;

// Dot color
$dotColor = $dotColors[$variant] ?? $dotColors['primary'];
@endphp

@if($href)
<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    @if($dot)
        <span class="h-2 w-2 {{ $dotColor }} rounded-full mr-1.5 flex-shrink-0"></span>
    @elseif($icon)
        <i class="bi bi-{{ $icon }} mr-1.5 -ml-0.5 flex-shrink-0"></i>
    @endif
    {{ $slot }}
    @if($count !== null)
        <span class="ml-1 {{ $size === 'xs' || $size === 'sm' ? 'text-xs' : 'text-sm' }} bg-white bg-opacity-25 px-1.5 py-0.5 rounded-full">
            {{ $count }}
        </span>
    @endif
    @if($removable)
        <button type="button" class="ml-1 -mr-1 h-4 w-4 rounded-full inline-flex items-center justify-center text-current hover:bg-opacity-25 hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-{{ $variant }}-500">
            <span class="sr-only">Remove</span>
            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    @endif
</a>
@else
<span {{ $attributes->merge(['class' => $classes]) }}>
    @if($dot)
        <span class="h-2 w-2 {{ $dotColor }} rounded-full mr-1.5 flex-shrink-0"></span>
    @elseif($icon)
        <i class="bi bi-{{ $icon }} mr-1.5 -ml-0.5 flex-shrink-0"></i>
    @endif
    {{ $slot }}
    @if($count !== null)
        <span class="ml-1 {{ $size === 'xs' || $size === 'sm' ? 'text-xs' : 'text-sm' }} bg-white bg-opacity-25 px-1.5 py-0.5 rounded-full">
            {{ $count }}
        </span>
    @endif
    @if($removable)
        <button type="button" class="ml-1 -mr-1 h-4 w-4 rounded-full inline-flex items-center justify-center text-current hover:bg-opacity-25 hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-{{ $variant }}-500">
            <span class="sr-only">Remove</span>
            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    @endif
</span>
@endif
