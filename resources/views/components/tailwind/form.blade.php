@props([
    'method' => 'POST',
    'action' => '',
    'hasFiles' => false,
    'submitText' => 'Submit',
    'cancelRoute' => null,
    'cancelText' => 'Cancel',
    'id' => null,
    'class' => '',
    'autocomplete' => 'on'
])

@php
    $formId = $id ?? 'form-' . md5(uniqid('', true));
    $realMethod = strtoupper($method);
    $spoofedMethods = ['PUT', 'PATCH', 'DELETE'];
    $formMethod = in_array($realMethod, $spoofedMethods) ? 'POST' : $realMethod;
@endphp

<div
    x-data="{
        formErrors: {},
        isSubmitting: false,
        validateForm() {
            // Reset errors
            this.formErrors = {};

            // Get all required fields
            const requiredFields = document.querySelectorAll('#{{ $formId }} [required]');
            let isValid = true;

            // Validate each required field
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    this.formErrors[field.name] = `${field.name.replace('_', ' ')} is required`;
                    isValid = false;
                }
            });

            return isValid;
        }
    }"
    class="w-full {{ $class }}"
>
    <form
        id="{{ $formId }}"
        action="{{ $action }}"
        method="{{ $formMethod }}"
        enctype="{{ $hasFiles ? 'multipart/form-data' : 'application/x-www-form-urlencoded' }}"
        autocomplete="{{ $autocomplete }}"
        @submit.prevent="isSubmitting = true; if(validateForm()) $event.target.submit()"
        class="space-y-6"
    >
        @csrf

        @if(in_array($realMethod, $spoofedMethods))
            @method($realMethod)
        @endif

        <!-- Form Content -->
        <div class="space-y-6">
            {{ $slot }}
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end space-x-3 pt-5 border-t border-gray-200">
            @if($cancelRoute)
                <a
                    href="{{ $cancelRoute }}"
                    class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
                >
                    {{ $cancelText }}
                </a>
            @endif

            <button
                type="submit"
                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
                :disabled="isSubmitting"
            >
                <span x-show="!isSubmitting">{{ $submitText }}</span>
                <span x-show="isSubmitting" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Processing...
                </span>
            </button>
        </div>
    </form>

    <!-- Form Error Display -->
    <div x-show="Object.keys(formErrors).length > 0" class="mt-4 bg-red-50 border-l-4 border-red-500 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Please correct the following errors:</h3>
                <div class="mt-2 text-sm text-red-700">
                    <ul class="list-disc pl-5 space-y-1">
                        <template x-for="(error, field) in formErrors" :key="field">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form Input Component -->
@component('components.tailwind.input-group')
@endcomponent
