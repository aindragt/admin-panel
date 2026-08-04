@props(['title', 'subtitle'])

<div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
    {{-- Header / Toolbar Area --}}
    @if (isset($toolbar))
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">{{ $title }}</h2>
                    @if (isset($subtitle))
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $subtitle }}</p>
                    @endif
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    {{ $toolbar }}
                </div>
            </div>
        </div>
    @else
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">{{ $title }}</h2>
            @if (isset($subtitle))
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $subtitle }}</p>
            @endif
        </div>
    @endif

    {{-- Slot Utama (Tabel) --}}
    <div class="overflow-x-auto">
        {{ $slot }}
    </div>

    {{-- Footer Area (Paginasi) --}}
    @if (isset($footer))
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/30 border-t border-gray-100 dark:border-gray-800">
            {{ $footer }}
        </div>
    @endif
</div>
