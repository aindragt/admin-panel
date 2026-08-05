@props([
    'current' => 1,
    'last' => 1,
    'from' => 0,
    'to' => 0,
    'total' => 0,
])

@php
    $range = 2;
    $pageNumbers = [];

    for ($i = 1; $i <= $last; $i++) {
        if ($i === 1 || $i === $last || ($i >= $current - $range && $i <= $current + $range)) {
            $pageNumbers[] = $i;
        }
    }

    // Sisipkan penanda ellipsis di setiap gap antar angka
    $items = [];
    $previousPage = null;

    foreach ($pageNumbers as $page) {
        if ($previousPage !== null && $page - $previousPage > 1) {
            $items[] = '...';
        }
        $items[] = $page;
        $previousPage = $page;
    }
@endphp

<div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
    <p class="text-sm text-gray-500 dark:text-gray-400">
        Menampilkan
        <span class="font-medium text-gray-700 dark:text-gray-300">{{ $from }}</span>–<span class="font-medium text-gray-700 dark:text-gray-300">{{ $to }}</span>
        dari
        <span class="font-medium text-gray-700 dark:text-gray-300">{{ $total }}</span>
        data
    </p>

    <nav class="flex items-center gap-1.5" aria-label="Pagination">
        {{-- Prev --}}
        <button
            type="button"
            @if ($current <= 1) disabled @endif
            class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-gray-300 text-gray-500 transition-all duration-150
                hover:bg-gray-50 hover:text-gray-800 active:scale-90
                disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:bg-transparent disabled:active:scale-100
                dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800"
        >
            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 010 1.06L8.832 10l3.958 3.71a.75.75 0 11-1.02 1.1l-4.5-4.25a.75.75 0 010-1.1l4.5-4.25a.75.75 0 011.02.02z" clip-rule="evenodd" />
            </svg>
        </button>

        @foreach ($items as $item)
            @if ($item === '...')
                <span class="px-1.5 text-sm text-gray-400 dark:text-gray-600">&hellip;</span>
            @else
                <button
                    type="button"
                    class="inline-flex h-8 min-w-8 items-center justify-center rounded-lg border px-2.5 text-sm font-medium transition-all duration-150 active:scale-90
                        {{ $item === $current
                            ? 'border-indigo-600 bg-indigo-600 text-white shadow-sm shadow-indigo-200 dark:shadow-none'
                            : 'border-gray-300 text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800' }}"
                >
                    {{ $item }}
                </button>
            @endif
        @endforeach

        {{-- Next --}}
        <button
            type="button"
            @if ($current >= $last) disabled @endif
            class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-gray-300 text-gray-500 transition-all duration-150
                hover:bg-gray-50 hover:text-gray-800 active:scale-90
                disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:bg-transparent disabled:active:scale-100
                dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800"
        >
            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 010-1.06L11.168 10 7.21 6.29a.75.75 0 111.02-1.1l4.5 4.25a.75.75 0 010 1.1l-4.5 4.25a.75.75 0 01-1.02-.02z" clip-rule="evenodd" />
            </svg>
        </button>
    </nav>
</div>