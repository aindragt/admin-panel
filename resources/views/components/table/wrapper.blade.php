@props([
    'title' => null,
    'subtitle' => null,
])

<div {{ $attributes->merge([
    'class' => 'table-fade-in overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm
        transition-shadow duration-300 hover:shadow-md
        dark:border-gray-800 dark:bg-gray-900',
]) }}>
    @if ($title || $subtitle || isset($toolbar))
        <div class="flex flex-col gap-3 border-b border-gray-100 px-5 py-4 dark:border-gray-800 sm:flex-row sm:items-center sm:justify-between">
            <div>
                @if ($title)
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">{{ $title }}</h3>
                @endif
                @if ($subtitle)
                    <p class="mt-0.5 text-sm text-gray-400 dark:text-gray-500">{{ $subtitle }}</p>
                @endif
            </div>

            @isset($toolbar)
                <div class="flex flex-col gap-2.5 sm:flex-row sm:items-center">
                    {{ $toolbar }}
                </div>
            @endisset
        </div>
    @endif

    {{-- overflow-x-auto: kunci agar tabel bisa di-scroll horizontal di mobile
         tanpa membuat seluruh halaman ikut bergeser --}}
    <div class="overflow-x-auto">
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="border-t border-gray-100 px-5 py-4 dark:border-gray-800">
            {{ $footer }}
        </div>
    @endisset
</div>