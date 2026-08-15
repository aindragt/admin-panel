@props([
    'sortable' => false,
    'sorted' => null, // 'asc' or 'desc' or null
])

@php
    $baseClasses = 'px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap dark:text-gray-400';
@endphp

<th {{ $attributes->merge(['class' => $baseClasses, 'scope' => 'col']) }}>
    @if ($sortable)
        <button
            type="button"
            class="group inline-flex items-center gap-1.5 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
        >
            <span>{{ $slot }}</span>

            <span class="relative flex h-3.5 w-3.5 items-center justify-center transition-transform duration-200 group-hover:scale-110">
                @if ($sorted === 'asc')
                    <svg class="h-3.5 w-3.5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 4.5a.75.75 0 01.53.22l4.25 4.25a.75.75 0 11-1.06 1.06L10.75 7.06v8.19a.75.75 0 01-1.5 0V7.06L6.28 10.03a.75.75 0 01-1.06-1.06l4.25-4.25A.75.75 0 0110 4.5z" />
                    </svg>
                @elseif ($sorted === 'desc')
                    <svg class="h-3.5 w-3.5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 15.5a.75.75 0 01-.53-.22l-4.25-4.25a.75.75 0 111.06-1.06l2.97 2.97V4.75a.75.75 0 011.5 0v8.19l2.97-2.97a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-.53.22z" />
                    </svg>
                @else
                    <svg class="h-3.5 w-3.5 text-gray-300 opacity-70 transition-opacity group-hover:opacity-100 dark:text-gray-600" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 3.75a.75.75 0 01.75.75v9.69l2.22-2.22a.75.75 0 111.06 1.06l-3.5 3.5a.75.75 0 01-1.06 0l-3.5-3.5a.75.75 0 111.06-1.06l2.22 2.22V4.5a.75.75 0 01.75-.75z" />
                        <path d="M10 16.25a.75.75 0 01-.75-.75V5.81L7.03 8.03a.75.75 0 01-1.06-1.06l3.5-3.5a.75.75 0 011.06 0l3.5 3.5a.75.75 0 11-1.06 1.06L10.75 5.81v9.69a.75.75 0 01-.75.75z" />
                    </svg>
                @endif
            </span>
        </button>
    @else
        {{ $slot }}
    @endif
</th>