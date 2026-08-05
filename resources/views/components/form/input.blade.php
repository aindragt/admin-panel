@props([
    'name',
    'label'       => null,
    'type'        => 'text',
    'placeholder' => null,
    'value'       => null,
    'error'       => null,
    'hint'        => null,
    'required'    => false,
    'disabled'    => false,
    // Add-on Props
    'prefix'      => null,
    'suffix'      => null,
    'prefixIcon'  => false,
    'suffixIcon'  => false,
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

    {{-- Wrapper Container Group untuk Input & Addons --}}
    <div class="relative flex rounded-lg border shadow-sm transition bg-white dark:bg-gray-900 overflow-hidden focus-within:ring-2
        {{ $disabled ? 'opacity-50 cursor-not-allowed bg-gray-50 dark:bg-gray-800' : '' }}
        {{ $hasError
            ? 'border-red-400 focus-within:border-red-400 focus-within:ring-red-300/60'
            : 'border-gray-300 dark:border-gray-700 focus-within:border-indigo-500 focus-within:ring-indigo-300/60 dark:focus-within:ring-indigo-500/30' }}">
        
        {{-- Prefix Teks --}}
        @if ($prefix)
            <span class="inline-flex items-center px-3 bg-gray-50 dark:bg-gray-800 border-r border-gray-300 dark:border-gray-700 text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap select-none">
                {{ $prefix }}
            </span>
        @endif

        {{-- Prefix Icon Slot --}}
        @if ($prefixIcon)
            <span class="inline-flex items-center pl-3 text-gray-400 dark:text-gray-500">
                {{ $prefixIcon }}
            </span>
        @endif

        {{-- Input Utama --}}
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $inputId }}"
            @if ($placeholder) placeholder="{{ $placeholder }}" @endif
            @if ($required) required @endif
            @if ($disabled) disabled @endif
            value="{{ old($name, $value) }}"
            {{ $attributes->merge([
                'class' => 'block w-full px-3.5 py-2.5 text-sm bg-transparent border-0 ring-0 focus:outline-none focus:ring-0
                    text-gray-900 dark:text-gray-100 placeholder:text-gray-400 dark:placeholder:text-gray-500
                    disabled:cursor-not-allowed',
            ]) }}
        />

        {{-- Error Warning Icon (jika ada error dan bukan suffixIcon kustom) --}}
        @if ($hasError && !$suffixIcon)
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.72-1.36 3.486 0l6.516 11.598c.75 1.334-.213 2.987-1.743 2.987H3.484c-1.53 0-2.493-1.653-1.743-2.987L8.257 3.1zM11 13a1 1 0 10-2 0 1 1 0 002 0zm-.25-5.5a.75.75 0 00-1.5 0v3a.75.75 0 001.5 0v-3z" clip-rule="evenodd" />
                </svg>
            </div>
        @endif

        {{-- Suffix Icon Slot --}}
        @if ($suffixIcon)
            <span class="inline-flex items-center pr-3 text-gray-400 dark:text-gray-500">
                {{ $suffixIcon }}
            </span>
        @endif

        {{-- Suffix Teks --}}
        @if ($suffix)
            <span class="inline-flex items-center px-3 bg-gray-50 dark:bg-gray-800 border-l border-gray-300 dark:border-gray-700 text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap select-none">
                {{ $suffix }}
            </span>
        @endif
    </div>

    @if ($hasError)
        <p class="mt-1.5 text-sm text-red-500">{{ $error }}</p>
    @elseif ($hint)
        <p class="mt-1.5 text-sm text-gray-400 dark:text-gray-500">{{ $hint }}</p>
    @endif
</div>