@props([
    'items' => [],
    'homeIcon' => true,
    'separator' => 'chevron',
    'responsive' => true,
    'class' => ''
])

@php
// Separator options
$separators = [
    'chevron' => '<svg class="h-4 w-4 text-gray-400 mx-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>',
    'slash' => '<span class="text-gray-400 mx-1">/</span>',
    'dot' => '<span class="text-gray-400 mx-1">•</span>',
    'arrow' => '<svg class="h-4 w-4 text-gray-400 mx-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>'
];

$separatorHtml = $separators[$separator] ?? $separators['chevron'];

// Base classes
$baseClasses = 'flex items-center text-sm';
if ($responsive) {
    $baseClasses .= ' flex-wrap';
}

// Combined classes
$classes = $baseClasses . ' ' . $class;
@endphp

<nav aria-label="Breadcrumb" class="{{ $classes }}">
    <ol class="flex items-center space-x-1 md:space-x-2">
        @if($homeIcon)
            <li>
                <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700 transition-colors duration-150">
                    <svg class="h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    <span class="sr-only">Home</span>
                </a>
            </li>
            @if(count($items) > 0)
                <li class="flex items-center">
                    {!! $separatorHtml !!}
                </li>
            @endif
        @endif

        @foreach($items as $index => $item)
            <li class="flex items-center">
                @if(isset($item['url']) && $index < count($items) - 1)
                    <a 
                        href="{{ $item['url'] }}" 
                        class="text-gray-500 hover:text-gray-700 transition-colors duration-150 truncate max-w-xs md:max-w-none"
                        @if(isset($item['title']))
                        title="{{ $item['title'] }}"
                        @endif
                    >
                        {{ $item['label'] }}
                    </a>
                @else
                    <span 
                        class="text-gray-900 font-medium truncate max-w-xs md:max-w-none"
                        @if(isset($item['title']))
                        title="{{ $item['title'] }}"
                        @endif
                    >
                        {{ $item['label'] }}
                    </span>
                @endif

                @if($index < count($items) - 1)
                    <div class="flex items-center">
                        {!! $separatorHtml !!}
                    </div>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
