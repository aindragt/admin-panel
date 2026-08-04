@props(['current', 'last', 'from', 'to', 'total'])

<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between text-sm">
    {{-- Sisi Kiri: Informasi Data --}}
    <div class="text-gray-500 dark:text-gray-400 text-center sm:text-left">
        Menampilkan <span class="font-medium text-gray-900 dark:text-white">{{ $from }}</span>–<span class="font-medium text-gray-900 dark:text-white">{{ $to }}</span> dari <span class="font-medium text-gray-900 dark:text-white">{{ $total }}</span> data
    </div>

    {{-- Sisi Kanan: Navigasi Halaman --}}
    <div class="flex items-center justify-center gap-1.5">
        {{-- Tombol Prev --}}
        <button type="button" 
            {{ $current <= 1 ? 'disabled' : '' }}
            class="p-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors disabled:opacity-40 disabled:hover:bg-white dark:disabled:hover:bg-gray-800 disabled:cursor-not-allowed"
            aria-label="Previous Page"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>

        {{-- Daftar Angka Halaman (Ellipsis Pintar) --}}
        @php
            $delta = 2; // Tampilkan 2 halaman di kiri dan kanan halaman aktif
            $pages = [];
            
            for ($i = 1; $i <= $last; $i++) {
                if ($i == 1 || $i == $last || ($i >= $current - $delta && $i <= $current + $delta)) {
                    $pages[] = $i;
                }
            }

            $renderedPages = [];
            $prevPage = null;
            foreach ($pages as $page) {
                if ($prevPage !== null) {
                    if ($page - $prevPage === 2) {
                        $renderedPages[] = $prevPage + 1;
                    } elseif ($page - $prevPage > 2) {
                        $renderedPages[] = '...';
                    }
                }
                $renderedPages[] = $page;
                $prevPage = $page;
            }
        @endphp

        @foreach ($renderedPages as $p)
            @if ($p === '...')
                <span class="px-3 py-1.5 text-gray-400 dark:text-gray-600 select-none">...</span>
            @else
                <button type="button"
                    class="px-3 py-1.5 text-xs font-semibold rounded-lg border transition-colors
                        {{ $p == $current 
                            ? 'bg-indigo-600 border-indigo-600 text-white dark:bg-indigo-500 dark:border-indigo-500' 
                            : 'border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}"
                >
                    {{ $p }}
                </button>
            @endif
        @endforeach

        {{-- Tombol Next --}}
        <button type="button" 
            {{ $current >= $last ? 'disabled' : '' }}
            class="p-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors disabled:opacity-40 disabled:hover:bg-white dark:disabled:hover:bg-gray-800 disabled:cursor-not-allowed"
            aria-label="Next Page"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
    </div>
</div>
