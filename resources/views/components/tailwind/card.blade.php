@props([
    'header' => null,
    'footer' => null,
    'noPadding' => false,
    'variant' => 'default'
])

@php
$variants = [
    'default' => 'bg-white border border-gray-200',
    'primary' => 'bg-white border-l-4 border-blue-500',
    'success' => 'bg-white border-l-4 border-green-500',
    'warning' => 'bg-white border-l-4 border-yellow-500',
    'danger' => 'bg-white border-l-4 border-red-500',
    'info' => 'bg-white border-l-4 border-cyan-500'
];

$cardClass = $variants[$variant] ?? $variants['default'];
@endphp

<div {{ $attributes->merge(['class' => "rounded-lg shadow-sm overflow-hidden $cardClass"]) }}>
    @if($header)
        <div class="px-6 py-4 border-b border-gray-200">
            {{ $header }}
        </div>
    @endif

    <div class="{{ $noPadding ? '' : 'p-6' }}">
        {{ $slot }}
    </div>

    @if($footer)
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $footer }}
        </div>
    @endif
</div>
