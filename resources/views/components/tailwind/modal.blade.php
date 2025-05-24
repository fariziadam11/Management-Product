@props([
    'id',
    'title' => null,
    'size' => 'md',
    'closeButton' => true,
    'staticBackdrop' => false
])

@php
$sizes = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
    '3xl' => 'sm:max-w-3xl',
    '4xl' => 'sm:max-w-4xl',
    '5xl' => 'sm:max-w-5xl',
    'full' => 'sm:max-w-full'
];

$modalSize = $sizes[$size] ?? $sizes['md'];
@endphp

<div
    x-data="{ open: false }"
    x-show="open"
    x-cloak
    x-on:open-modal.window="$event.detail === '{{ $id }}' && (open = true)"
    x-on:close-modal.window="$event.detail === '{{ $id }}' && (open = false)"
    x-on:keydown.escape.window="@if(!$staticBackdrop)open = false @endif"
    x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 overflow-y-auto modal-container"
    aria-labelledby="modal-title-{{ $id }}" role="dialog" aria-modal="true"
>
    <div class="flex min-h-screen items-center justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div
            x-show="open"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
            @if(!$staticBackdrop)
                @click="open = false"
            @endif
        ></div>

        <!-- Modal panel -->
        <div
            x-show="open"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative inline-block transform overflow-hidden rounded-lg bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full {{ $modalSize }} sm:align-middle"
        >
            @if($title || $closeButton)
                <div class="bg-white px-4 py-3 sm:px-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        @if($title)
                            <h3 class="text-lg font-medium text-gray-900">
                                {{ $title }}
                            </h3>
                        @endif

                        @if($closeButton)
                            <button
                                type="button"
                                class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none"
                                @if(!$staticBackdrop)
                                    @click="open = false"
                                @endif
                            >
                                <span class="sr-only">Close</span>
                                <i class="bi bi-x text-xl"></i>
                            </button>
                        @endif
                    </div>
                </div>
            @endif

            <div class="bg-white px-4 py-4 sm:px-6">
                {{ $slot }}
            </div>

            @if(isset($footer))
                <div class="bg-gray-50 px-4 py-3 sm:px-6 border-t border-gray-200">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>

@once
@push('scripts')
<script>
    // These functions are now defined in app.js
    // Keeping this for backward compatibility
    if (typeof window.openModal !== 'function') {
        window.openModal = function(modalId) {
            window.dispatchEvent(new CustomEvent('open-modal', { detail: modalId }))
        }
    }

    if (typeof window.closeModal !== 'function') {
        window.closeModal = function(modalId) {
            window.dispatchEvent(new CustomEvent('close-modal', { detail: modalId }))
        }
    }
    
    // Handle legacy modal triggers
    document.querySelectorAll('[data-toggle="modal"][data-target="#{{ $id }}"]').forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            window.openModal('{{ $id }}');
        });
    });
</script>
@endpush
@endonce
