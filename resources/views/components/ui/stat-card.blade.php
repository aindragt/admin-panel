{{--
    Reusable Stat Card Component
    Props:
      - $label   : string  — Nama metrik (contoh: "Total Users")
      - $value   : string  — Nilai utama (contoh: "1,234")
      - $change  : string  — Perubahan dalam persen (contoh: "+12.5%")
      - $trend   : string  — "up" atau "down" (menentukan warna dan ikon arah)
      - $icon    : string  — Nama ikon: "users" | "shopping-bag" | "currency-dollar" | "trending-up"
      - $color   : string  — "blue" | "green" | "yellow" | "purple"
--}}

@props([
    'label'  => 'Metric',
    'value'  => '0',
    'change' => '0%',
    'trend'  => 'up',
    'icon'   => 'users',
    'color'  => 'blue',
])

@php
    $colors = [
        'blue'   => 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400',
        'green'  => 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400',
        'yellow' => 'bg-yellow-50 dark:bg-yellow-900/20 text-yellow-600 dark:text-yellow-400',
        'purple' => 'bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400',
    ];

    $icons = [
        'users'            => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v2h5M7 20v-2a3 3 0 015.356-1.857M7 20v2m5-10a3 3 0 100-6 3 3 0 000 6zm6 0a3 3 0 100-6 3 3 0 000 6z',
        'shopping-bag'     => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z',
        'currency-dollar'  => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        'trending-up'      => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6',
    ];

    $colorClass = $colors[$color] ?? $colors['blue'];
    $iconPath   = $icons[$icon] ?? $icons['users'];
    $trendUp    = $trend === 'up';
@endphp

<div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-5 flex items-start gap-4 hover:shadow-md transition-shadow">

    {{-- Icon Badge --}}
    <div class="flex-shrink-0 w-12 h-12 rounded-xl {{ $colorClass }} flex items-center justify-center">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPath }}"/>
        </svg>
    </div>

    {{-- Content --}}
    <div class="flex-1 min-w-0">
        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider truncate">
            {{ $label }}
        </p>
        <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">
            {{ $value }}
        </p>
        <div class="mt-1 flex items-center gap-1">
            <svg class="w-3.5 h-3.5 {{ $trendUp ? 'text-green-500' : 'text-red-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                @if($trendUp)
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/>
                @else
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                @endif
            </svg>
            <span class="text-xs font-medium {{ $trendUp ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                {{ $change }}
            </span>
            <span class="text-xs text-gray-400 dark:text-gray-500">vs bulan lalu</span>
        </div>
    </div>
</div>
