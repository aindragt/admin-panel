@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'submit',
    'disabled' => false,
    'loading' => false
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed';

    $sizeClasses = match($size) {
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
        default => 'px-4 py-2 text-sm',
    };

    $variantClasses = match($variant) {
        'primary' => 'bg-indigo-600 hover:bg-indigo-700 text-white focus:ring-indigo-500',
        'secondary' => 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500',
        'success' => 'bg-emerald-600 hover:bg-emerald-700 text-white focus:ring-emerald-500',
        'ghost' => 'bg-transparent hover:bg-gray-100 text-gray-600 dark:text-gray-300 dark:hover:bg-gray-800',
        default => 'bg-indigo-600 hover:bg-indigo-700 text-white focus:ring-indigo-500',
    };
@endphp

<button
    type="{{ $type }}"
    @disabled($disabled || $loading)
    {{ $attributes->merge(['class' => "$baseClasses $sizeClasses $variantClasses"]) }}
>
    @if($loading)
        <svg class="w-4 h-4 mr-2 -ml-1 text-current animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    @endif
    {{ $slot }}
</button>