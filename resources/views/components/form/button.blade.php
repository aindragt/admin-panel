@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'disabled' => false,
    'loading' => false,
])

@php
    $variants = [
        'primary'   => 'bg-indigo-600 hover:bg-indigo-700 text-white border border-transparent focus:ring-indigo-300',
        'secondary' => 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 focus:ring-gray-200 dark:bg-gray-900 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-800',
        'danger'    => 'bg-red-600 hover:bg-red-700 text-white border border-transparent focus:ring-red-300',
        'success'   => 'bg-emerald-600 hover:bg-emerald-700 text-white border border-transparent focus:ring-emerald-300',
        'ghost'     => 'bg-transparent hover:bg-gray-100 text-gray-600 border border-transparent focus:ring-gray-200 dark:text-gray-300 dark:hover:bg-gray-800',
    ];

    $sizes = [
        'sm' => 'px-3 py-1.5 text-xs gap-1.5',
        'md' => 'px-4 py-2.5 text-sm gap-2',
        'lg' => 'px-5 py-3 text-base gap-2.5',
    ];

    $variantClasses = $variants[$variant] ?? $variants['primary'];
    $sizeClasses = $sizes[$size] ?? $sizes['md'];
    $isDisabled = $disabled || $loading;
@endphp

<button
    type="{{ $type }}"
    @if ($isDisabled) disabled @endif
    {{ $attributes->merge([
        'class' => "inline-flex items-center justify-center rounded-lg font-medium shadow-sm transition
            focus:outline-none focus:ring-2 focus:ring-offset-1
            disabled:cursor-not-allowed disabled:opacity-50
            {$variantClasses} {$sizeClasses}",
    ]) }}
>
    @if ($loading)
        <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
        </svg>
    @endif

    {{ $slot }}
</button>