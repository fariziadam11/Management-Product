@props([
    'id' => null,
    'type' => 'info',
    'position' => 'top-right',
    'title' => null,
    'message' => null,
    'icon' => null,
    'dismissible' => true,
    'autoDismiss' => true,
    'dismissAfter' => 5000,
    'transition' => true
])

@php
// Generate a unique ID if not provided
$toastId = $id ?? 'toast-' . md5(uniqid('', true));

// Toast types with their respective styles
$types = [
    'info' => [
        'bg' => 'bg-blue-50',
        'border' => 'border-blue-400',
        'icon' => $icon ?? 'info-circle',
        'icon-color' => 'text-blue-400',
        'title-color' => 'text-blue-800',
        'text-color' => 'text-blue-700'
    ],
    'success' => [
        'bg' => 'bg-green-50',
        'border' => 'border-green-400',
        'icon' => $icon ?? 'check-circle',
        'icon-color' => 'text-green-400',
        'title-color' => 'text-green-800',
        'text-color' => 'text-green-700'
    ],
    'warning' => [
        'bg' => 'bg-yellow-50',
        'border' => 'border-yellow-400',
        'icon' => $icon ?? 'exclamation-triangle',
        'icon-color' => 'text-yellow-400',
        'title-color' => 'text-yellow-800',
        'text-color' => 'text-yellow-700'
    ],
    'error' => [
        'bg' => 'bg-red-50',
        'border' => 'border-red-400',
        'icon' => $icon ?? 'x-circle',
        'icon-color' => 'text-red-400',
        'title-color' => 'text-red-800',
        'text-color' => 'text-red-700'
    ],
    'neutral' => [
        'bg' => 'bg-gray-50',
        'border' => 'border-gray-300',
        'icon' => $icon ?? 'bell',
        'icon-color' => 'text-gray-400',
        'title-color' => 'text-gray-800',
        'text-color' => 'text-gray-700'
    ]
];

// Get the styles for the current toast type
$currentType = $types[$type] ?? $types['info'];

// Position classes
$positions = [
    'top-right' => 'top-4 right-4',
    'top-left' => 'top-4 left-4',
    'bottom-right' => 'bottom-4 right-4',
    'bottom-left' => 'bottom-4 left-4',
    'top-center' => 'top-4 left-1/2 transform -translate-x-1/2',
    'bottom-center' => 'bottom-4 left-1/2 transform -translate-x-1/2'
];

$positionClass = $positions[$position] ?? $positions['top-right'];
@endphp

<div
    x-data="{
        show: false,
        init() {
            this.show = true;
            @if($autoDismiss)
            setTimeout(() => { this.show = false }, {{ $dismissAfter }});
            @endif
        }
    }"
    x-show="show"
    @if($transition)
    x-transition:enter="transform ease-out duration-300 transition"
    x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @endif
    id="{{ $toastId }}"
    class="fixed {{ $positionClass }} z-50 max-w-sm w-full shadow-lg rounded-lg pointer-events-auto"
    role="alert"
    aria-live="assertive"
    aria-atomic="true"
>
    <div class="overflow-hidden rounded-lg border-l-4 {{ $currentType['border'] }} {{ $currentType['bg'] }} shadow-md">
        <div class="p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="bi bi-{{ $currentType['icon'] }} h-5 w-5 {{ $currentType['icon-color'] }}"></i>
                </div>
                <div class="ml-3 w-0 flex-1 pt-0.5">
                    @if($title)
                        <p class="text-sm font-medium {{ $currentType['title-color'] }}">{{ $title }}</p>
                    @endif
                    @if($message)
                        <p class="mt-1 text-sm {{ $currentType['text-color'] }}">{{ $message }}</p>
                    @else
                        <p class="mt-1 text-sm {{ $currentType['text-color'] }}">{{ $slot }}</p>
                    @endif
                </div>
                @if($dismissible)
                    <div class="ml-4 flex-shrink-0 flex">
                        <button
                            @click="show = false"
                            class="inline-flex {{ $currentType['text-color'] }} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        >
                            <span class="sr-only">Close</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@once
@push('scripts')
<script>
    // Global toast function
    window.showToast = function(options) {
        const defaults = {
            type: 'info',
            position: 'top-right',
            title: '',
            message: '',
            dismissible: true,
            autoDismiss: true,
            dismissAfter: 5000
        };
        
        const settings = {...defaults, ...options};
        
        // Create a unique ID for this toast
        const toastId = 'toast-' + Math.random().toString(36).substr(2, 9);
        
        // Create the toast element
        const toast = document.createElement('div');
        toast.id = toastId;
        toast.setAttribute('x-data', '{ show: false }');
        toast.setAttribute('x-init', 'setTimeout(() => { show = true }, 100); ' + (settings.autoDismiss ? `setTimeout(() => { show = false }, ${settings.dismissAfter})` : ''));
        toast.setAttribute('x-show', 'show');
        toast.setAttribute('x-transition:enter', 'transform ease-out duration-300 transition');
        toast.setAttribute('x-transition:enter-start', 'translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2');
        toast.setAttribute('x-transition:enter-end', 'translate-y-0 opacity-100 sm:translate-x-0');
        toast.setAttribute('x-transition:leave', 'transition ease-in duration-200');
        toast.setAttribute('x-transition:leave-start', 'opacity-100');
        toast.setAttribute('x-transition:leave-end', 'opacity-0');
        toast.setAttribute('x-transition:leave-end.delay', 'remove()');
        
        // Add the toast to the DOM
        document.body.appendChild(toast);
        
        // Initialize Alpine on the new element
        if (window.Alpine) {
            window.Alpine.initTree(toast);
        }
        
        return toastId;
    };
</script>
@endpush
@endonce
