@props([
    'type' => 'success',
    'message' => '',
    'duration' => 4000,
])

@php
    $configs = [
        'success' => [
            'bg' => 'bg-emerald-50 dark:bg-emerald-950/20 border-emerald-200 dark:border-emerald-800/60',
            'text' => 'text-emerald-800 dark:text-emerald-400',
            'iconColor' => 'text-emerald-500',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        ],
        'error' => [
            'bg' => 'bg-red-50 dark:bg-red-950/20 border-red-200 dark:border-red-800/60',
            'text' => 'text-red-800 dark:text-red-400',
            'iconColor' => 'text-red-500',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        ],
        'warning' => [
            'bg' => 'bg-amber-50 dark:bg-amber-950/20 border-amber-200 dark:border-amber-800/60',
            'text' => 'text-amber-800 dark:text-amber-400',
            'iconColor' => 'text-amber-500',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>',
        ],
        'info' => [
            'bg' => 'bg-blue-50 dark:bg-blue-950/20 border-blue-200 dark:border-blue-800/60',
            'text' => 'text-blue-800 dark:text-blue-400',
            'iconColor' => 'text-blue-500',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        ],
    ];
@endphp

<div
    x-data="{ 
        visible: true,
        type: '{{ $type }}',
        message: '{{ $message }}',
        configs: {{ Js::from($configs) }},
        get config() {
            return this.configs[this.type] || this.configs['success'];
        }
    }"
    x-init="
        if ($el.parentElement && $el.parentElement.__x_for_key) {
            {{-- Jika dirender di dalam loop x-for (seperti tumpukan toast) --}}
            const toastData = Alpine.raw($data.toast);
            if (toastData) {
                type = toastData.type;
                message = toastData.message;
            }
        }
        setTimeout(() => { visible = false; }, {{ $duration }});
    "
    x-show="visible"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-x-12"
    x-transition:enter-end="opacity-100 translate-x-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0 scale-95"
    class="flex items-center gap-3 w-full max-w-sm p-4 rounded-xl border shadow-lg bg-white dark:bg-gray-900"
    :class="config.bg"
    role="alert"
>
    {{-- Toast Icon --}}
    <span class="flex-shrink-0" :class="config.iconColor" x-html="config.icon"></span>

    {{-- Message Teks --}}
    <p class="text-sm font-medium flex-1" :class="config.text" x-text="message"></p>

    {{-- Close Button --}}
    <button
        type="button"
        @click="visible = false"
        class="ml-auto p-1 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100/50 dark:hover:bg-gray-800/50 transition-colors"
        aria-label="Close Notification"
    >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>
