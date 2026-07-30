@props([
    'name',
    'label' => null,
    'placeholder' => null,
    'value' => null,
    'error' => null,
    'hint' => null,
    'required' => false,
    'disabled' => false,
    'rows' => 4,
])

@php
    $inputId = $attributes->get('id', $name);
    $hasError = filled($error);
@endphp

<div class="w-full">
    @if ($label)
        <label for="{{ $inputId }}" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <textarea
        name="{{ $name }}"
        id="{{ $inputId }}"
        rows="{{ $rows }}"
        @if ($placeholder) placeholder="{{ $placeholder }}" @endif
        @if ($required) required @endif
        @if ($disabled) disabled @endif
        {{ $attributes->merge([
            'class' => 'block w-full resize-y rounded-lg border px-3.5 py-2.5 text-sm shadow-sm transition
                bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100
                placeholder:text-gray-400 dark:placeholder:text-gray-500
                focus:outline-none focus:ring-2
                disabled:cursor-not-allowed disabled:opacity-50 disabled:bg-gray-50 dark:disabled:bg-gray-800
                ' . ($hasError
                    ? 'border-red-400 focus:border-red-400 focus:ring-red-300/60'
                    : 'border-gray-300 dark:border-gray-700 focus:border-indigo-500 focus:ring-indigo-300/60 dark:focus:ring-indigo-500/30'),
        ]) }}
    >{{ old($name, $value) }}</textarea>

    @if ($hasError)
        <p class="mt-1.5 text-sm text-red-500">{{ $error }}</p>
    @elseif ($hint)
        <p class="mt-1.5 text-sm text-gray-400 dark:text-gray-500">{{ $hint }}</p>
    @endif
</div>