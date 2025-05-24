@props([
    'label' => null,
    'error' => null,
    'id' => null,
    'name' => null,
    'value' => null,
    'required' => false,
    'disabled' => false,
    'helper' => null,
    'placeholder' => null,
    'options' => []
])

@php
$selectClasses = 'block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm';
if ($error) {
    $selectClasses = 'block w-full rounded-lg border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500 sm:text-sm';
}
@endphp

<div>
    @if($label)
        <label for="{{ $id }}" class="block text-sm font-medium text-gray-700 mb-1">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <select
        id="{{ $id }}"
        name="{{ $name }}"
        @if($required) required @endif
        @if($disabled) disabled @endif
        {{ $attributes->merge(['class' => $selectClasses]) }}
    >
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif

        @foreach($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" @if($optionValue == $value) selected @endif>
                {{ $optionLabel }}
            </option>
        @endforeach
    </select>

    @if($helper && !$error)
        <p class="mt-1 text-sm text-gray-500">{{ $helper }}</p>
    @endif

    @if($error)
        <p class="mt-1 text-sm text-red-600">{{ $error }}</p>
    @endif
</div>
