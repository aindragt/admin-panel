@props([
    'name',
    'label' => null,
    'options' => [],
    'selected' => null,
    'error' => null,
    'placeholder' => null,
    'required' => false,
    'disabled' => false,
])

@php
    $inputId = $attributes->get('id', $name);
    $hasError = filled($error);
    $currentValue = old($name, $selected);
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

    <div class="relative">
        <select
            name="{{ $name }}"
            id="{{ $inputId }}"
            @if ($required) required @endif
            @if ($disabled) disabled @endif
            {{ $attributes->merge([
                'class' => 'block w-full appearance-none rounded-lg border px-3.5 py-2.5 pr-10 text-sm shadow-sm transition
                    bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100
                    focus:outline-none focus:ring-2
                    disabled:cursor-not-allowed disabled:opacity-50 disabled:bg-gray-50 dark:disabled:bg-gray-800
                    ' . ($hasError
                        ? 'border-red-400 focus:border-red-400 focus:ring-red-300/60'
                        : 'border-gray-300 dark:border-gray-700 focus:border-indigo-500 focus:ring-indigo-300/60 dark:focus:ring-indigo-500/30'),
            ]) }}
        >
            @if ($placeholder)
                <option value="" disabled {{ $currentValue ? '' : 'selected' }}>{{ $placeholder }}</option>
            @endif

            @foreach ($options as $value => $label)
                <option value="{{ $value }}" @selected((string) $currentValue === (string) $value)>
                    {{ $label }}
                </option>
            @endforeach
        </select>

        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
            <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
            </svg>
        </div>
    </div>

    @if ($hasError)
        <p class="mt-1.5 text-sm text-red-500">{{ $error }}</p>
    @endif
</div>