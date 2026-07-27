{{-- Footer Partial --}}
<footer class="flex-shrink-0 h-12 flex items-center justify-between px-6 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800">
    <p class="text-xs text-gray-500 dark:text-gray-400">
        &copy; {{ date('Y') }} <span class="font-medium">{{ config('app.name') }}</span>. All rights reserved.
    </p>
    <p class="text-xs text-gray-400 dark:text-gray-600">
        Built with Laravel & Tailwind CSS
    </p>
</footer>
