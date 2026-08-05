@props([
    'name',
    'label'       => null,
    'value'       => '',
    'min'         => null,
    'max'         => null,
    'required'    => false,
    'disabled'    => false,
    'error'       => null,
    'hint'        => null,
])

@php
    $inputId = $name;
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

    <div class="relative">
        {{-- Ikon Kalender dekoratif di kiri --}}
        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400 dark:text-gray-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>

        <input
            type="date"
            name="{{ $name }}"
            id="{{ $inputId }}"
            value="{{ old($name, $value) }}"
            @if ($min) min="{{ $min }}" @endif
            @if ($max) max="{{ $max }}" @endif
            @if ($required) required @endif
            @if ($disabled) disabled @endif
            {{ $attributes->merge([
                'class' => 'block w-full pl-10 pr-3.5 py-2.5 rounded-lg border text-sm shadow-sm transition focus:outline-none focus:ring-2
                    bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 placeholder:text-gray-400 dark:placeholder:text-gray-500
                    disabled:cursor-not-allowed disabled:opacity-50 disabled:bg-gray-50 dark:disabled:bg-gray-800
                    ' . ($hasError
                        ? 'border-red-400 focus:border-red-400 focus:ring-red-300/60'
                        : 'border-gray-300 dark:border-gray-700 focus:border-indigo-500 focus:ring-indigo-300/60 dark:focus:ring-indigo-500/30'),
            ]) }}
        />
    </div>

    @if ($hasError)
        <p class="mt-1.5 text-sm text-red-500">{{ $error }}</p>
    @elseif ($hint)
        <p class="mt-1.5 text-sm text-gray-400 dark:text-gray-500">{{ $hint }}</p>
    @endif
</div>
