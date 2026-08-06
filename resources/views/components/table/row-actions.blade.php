@props([
    'rowId' => null,
])

<div
    x-data="{ open: false }"
    @click.outside="open = false"
    @keydown.escape="open = false"
    class="relative inline-block text-left"
>
    {{-- Trigger Button (Ikon Titik Tiga Vertikal) --}}
    <button
        type="button"
        @click="open = !open"
        class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-gray-400
               hover:text-gray-600 dark:hover:text-gray-200
               hover:bg-gray-100 dark:hover:bg-gray-800/60
               transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500/30"
        title="Aksi"
    >
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 5a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm0 7a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm0 7a1.5 1.5 0 110-3 1.5 1.5 0 010 3z"/>
        </svg>
    </button>

    {{-- Dropdown Panel --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 z-20 mt-1 w-44 origin-top-right rounded-xl border border-gray-200
               dark:border-gray-800 bg-white dark:bg-gray-900 shadow-lg overflow-hidden"
        style="display: none;"
    >
        <div class="py-1">
            {{-- Lihat Detail --}}
            <button type="button" @click="open = false"
                class="flex items-center gap-2.5 w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300
                       hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors text-left">
                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Lihat Detail
            </button>

            {{-- Ubah Data --}}
            <button type="button" @click="open = false"
                class="flex items-center gap-2.5 w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300
                       hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors text-left">
                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Ubah Data
            </button>

            {{-- Divider --}}
            <div class="my-1 border-t border-gray-100 dark:border-gray-800"></div>

            {{-- Hapus (warna merah/danger) --}}
            <button type="button" @click="open = false"
                class="flex items-center gap-2.5 w-full px-4 py-2 text-sm text-red-600 dark:text-red-400
                       hover:bg-red-50 dark:hover:bg-red-950/20 transition-colors text-left">
                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Hapus Data
            </button>
        </div>
    </div>
</div>
