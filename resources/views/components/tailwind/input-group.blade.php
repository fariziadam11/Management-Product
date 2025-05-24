@props([
    'name' => '',
    'id' => null,
    'label' => '',
    'type' => 'text',
    'value' => null,
    'placeholder' => '',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'autofocus' => false,
    'help' => '',
    'error' => '',
    'class' => '',
    'labelClass' => '',
    'inputClass' => '',
    'wrapperClass' => '',
    'min' => null,
    'max' => null,
    'step' => null,
    'autocomplete' => null,
    'pattern' => null,
    'multiple' => false,
    'accept' => null,
    'rows' => 3
])

@php
    $inputId = $id ?? $name;
    
    // Base classes
    $baseInputClass = 'block w-full rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors duration-200';
    $baseErrorClass = 'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500';
    $baseSuccessClass = 'border-green-300 text-green-900 placeholder-green-300 focus:ring-green-500 focus:border-green-500';
    $baseDisabledClass = 'bg-gray-100 text-gray-500 cursor-not-allowed';
    
    // Determine input classes
    $classes = $baseInputClass;
    if ($error) {
        $classes .= ' ' . $baseErrorClass;
    } else {
        $classes .= ' border-gray-300';
    }
    
    if ($disabled) {
        $classes .= ' ' . $baseDisabledClass;
    }
    
    $classes .= ' ' . $inputClass;
@endphp

<div class="w-full {{ $wrapperClass }}">
    @if($label)
        <label for="{{ $inputId }}" class="block text-sm font-medium text-gray-700 mb-1 {{ $labelClass }}">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    
    <div class="relative">
        @if($type === 'textarea')
            <textarea
                id="{{ $inputId }}"
                name="{{ $name }}"
                class="{{ $classes }}"
                placeholder="{{ $placeholder }}"
                {{ $required ? 'required' : '' }}
                {{ $disabled ? 'disabled' : '' }}
                {{ $readonly ? 'readonly' : '' }}
                {{ $autofocus ? 'autofocus' : '' }}
                rows="{{ $rows }}"
                {{ $autocomplete ? 'autocomplete=' . $autocomplete : '' }}
            >{{ $value ?? old($name, '') }}</textarea>
        @elseif($type === 'select')
            <select
                id="{{ $inputId }}"
                name="{{ $name }}"
                class="{{ $classes }}"
                {{ $required ? 'required' : '' }}
                {{ $disabled ? 'disabled' : '' }}
                {{ $readonly ? 'readonly' : '' }}
                {{ $autofocus ? 'autofocus' : '' }}
                {{ $multiple ? 'multiple' : '' }}
                {{ $autocomplete ? 'autocomplete=' . $autocomplete : '' }}
            >
                {{ $slot }}
            </select>
        @elseif($type === 'checkbox' || $type === 'radio')
            <div class="flex items-center">
                <input
                    id="{{ $inputId }}"
                    name="{{ $name }}"
                    type="{{ $type }}"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded {{ $type === 'radio' ? 'rounded-full' : '' }} {{ $inputClass }}"
                    {{ $value ? 'value=' . $value : '' }}
                    {{ $required ? 'required' : '' }}
                    {{ $disabled ? 'disabled' : '' }}
                    {{ $readonly ? 'readonly' : '' }}
                    {{ $autofocus ? 'autofocus' : '' }}
                    {{ old($name) === $value || (isset($checked) && $checked) ? 'checked' : '' }}
                />
                @if($label)
                    <span class="ml-2 text-sm text-gray-700">{{ $label }}</span>
                @endif
            </div>
        @elseif($type === 'file')
            <div class="flex items-center">
                <label class="w-full flex flex-col items-center px-4 py-6 bg-white text-blue-500 rounded-lg shadow-lg tracking-wide uppercase border border-blue-500 cursor-pointer hover:bg-blue-500 hover:text-white transition-colors duration-200">
                    <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                    </svg>
                    <span class="mt-2 text-base leading-normal">{{ $placeholder ?: 'Select a file' }}</span>
                    <input
                        id="{{ $inputId }}"
                        name="{{ $name }}"
                        type="file"
                        class="hidden"
                        {{ $required ? 'required' : '' }}
                        {{ $disabled ? 'disabled' : '' }}
                        {{ $multiple ? 'multiple' : '' }}
                        {{ $accept ? 'accept=' . $accept : '' }}
                    />
                </label>
            </div>
        @else
            <input
                id="{{ $inputId }}"
                name="{{ $name }}"
                type="{{ $type }}"
                class="{{ $classes }}"
                placeholder="{{ $placeholder }}"
                {{ $value !== null ? 'value=' . $value : '' }}
                {{ $required ? 'required' : '' }}
                {{ $disabled ? 'disabled' : '' }}
                {{ $readonly ? 'readonly' : '' }}
                {{ $autofocus ? 'autofocus' : '' }}
                {{ $min !== null ? 'min=' . $min : '' }}
                {{ $max !== null ? 'max=' . $max : '' }}
                {{ $step !== null ? 'step=' . $step : '' }}
                {{ $pattern !== null ? 'pattern=' . $pattern : '' }}
                {{ $autocomplete !== null ? 'autocomplete=' . $autocomplete : '' }}
            />
            
            @if($type === 'password')
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <button
                        type="button"
                        x-data="{ show: false }"
                        @click="show = !show; $el.previousElementSibling.type = show ? 'text' : 'password'"
                        class="text-gray-400 hover:text-gray-500 focus:outline-none"
                    >
                        <svg
                            x-show="!show"
                            class="h-5 w-5"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                        </svg>
                        <svg
                            x-show="show"
                            class="h-5 w-5"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            style="display: none;"
                        >
                            <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                            <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                        </svg>
                    </button>
                </div>
            @endif
        @endif
    </div>
    
    @if($error)
        <p class="mt-1 text-sm text-red-600">{{ $error }}</p>
    @endif
    
    @if($help && !$error)
        <p class="mt-1 text-sm text-gray-500">{{ $help }}</p>
    @endif
</div>
