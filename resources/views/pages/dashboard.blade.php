@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
            🎉 Setup Berhasil!
        </h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">
            Project Laravel dengan Tailwind CSS, Dark Mode, Font Inter, dan Alpine.js sudah siap.
        </p>

        {{-- Alpine.js Test --}}
        <div x-data="{ open: false }" class="mt-6">
            <button
                @click="open = !open"
                class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors"
            >
                Toggle Alpine Test
            </button>
            <p x-show="open" x-transition class="mt-3 text-green-600 dark:text-green-400 font-medium">
                ✅ Alpine.js bekerja dengan baik!
            </p>
        </div>
    </div>
@endsection
