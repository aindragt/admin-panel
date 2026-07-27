@props([
    'label', 
    'value', 
    'change', 
    'trend' => 'up', 
    'icon' => 'users', 
    'color' => 'blue'
])

@php
    // Menentukan warna background dan text icon berdasarkan props 'color'
    $colorClasses = match($color) {
        'blue'   => 'bg-blue-100 text-blue-600 dark:bg-blue-900/50 dark:text-blue-400',
        'green'  => 'bg-green-100 text-green-600 dark:bg-green-900/50 dark:text-green-400',
        'yellow' => 'bg-yellow-100 text-yellow-600 dark:bg-yellow-900/50 dark:text-yellow-400',
        'purple' => 'bg-purple-100 text-purple-600 dark:bg-purple-900/50 dark:text-purple-400',
        default  => 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400',
    };

    // Menentukan warna trend (naik = hijau, turun = merah)
    $isUp = $trend === 'up';
    $trendColorClass = $isUp ? 'text-emerald-500' : 'text-red-500';
@endphp

<div class="p-5 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-900 dark:border-gray-800 flex flex-col">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $label }}</h3>
        <div class="p-2 rounded-lg {{ $colorClasses }}">
            {{-- Icon Placeholder sederhana menggunakan inisial icon jika SVG asli belum tersedia di project --}}
            <span class="text-xs font-bold uppercase">{{ substr($icon, 0, 2) }}</span>
        </div>
    </div>
    
    <div class="flex items-baseline gap-2">
        <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $value }}</span>
    </div>

    <div class="mt-4 flex items-center text-sm">
        <span class="flex items-center font-medium {{ $trendColorClass }}">
            @if($isUp)
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
            @else
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
            @endif
            {{ $change }}
        </span>
        <span class="ml-2 text-gray-500 dark:text-gray-400">vs bulan lalu</span>
    </div>
</div>