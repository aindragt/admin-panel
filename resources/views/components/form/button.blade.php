@props([
    'variant'  => 'primary',
    'size'     => 'md',
    'type'     => 'button',
    'disabled' => false,
    'loading'  => false,
])

@php
$variants = [
    'primary'   => 'bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white shadow-sm focus:ring-indigo-400',
    'secondary' => 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 active:bg-gray-100 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 shadow-sm focus:ring-gray-300',
    'danger'    => 'bg-red-600 hover:bg-red-700 active:bg-red-800 text-white shadow-sm focus:ring-red-400',
    'success'   => 'bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white shadow-sm focus:ring-emerald-400',
    'ghost'     => 'bg-transparent hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-400 focus:ring-gray-300',
];

$sizes = [
    'sm' => 'px-3 py-1.5 text-xs rounded-lg',
    'md' => 'px-4 py-2.5 text-sm rounded-lg',
    'lg' => 'px-6 py-3 text-base rounded-xl',
];

$variantClass = $variants[$variant] ?? $variants['primary'];
$sizeClass    = $sizes[$size] ?? $sizes['md'];
$isDisabled   = $disabled || $loading;
@endphp

<button
    type="{{ $type }}"
    {{ $isDisabled ? 'disabled' : '' }}
    {{ $attributes->merge([
        'class' => "
            inline-flex items-center justify-center gap-2 font-medium
            transition-all duration-150
            focus:outline-none focus:ring-2 focus:ring-offset-2
            disabled:opacity-50 disabled:cursor-not-allowed
            {$variantClass} {$sizeClass}
        "
    ]) }}
>
    {{-- Loading Spinner --}}
    @if($loading)
        <svg class="animate-spin w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
        </svg>
    @endif

    {{-- Slot: konten tombol (teks / ikon) --}}
    {{ $slot }}
</button>
