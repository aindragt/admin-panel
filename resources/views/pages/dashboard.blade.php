@extends('layouts.app')

@section('title', 'Dashboard — Admin Panel')
@section('page-title', 'Dashboard')

@section('content')
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            Selamat Datang! 👋
        </h2>
        <p class="mt-2 text-gray-600 dark:text-gray-400">
            Master layout sudah siap. Semua komponen layout (Sidebar, Navbar, dan Footer) telah terintegrasi dengan baik menggunakan Alpine.js dan Tailwind CSS.
        </p>

        {{-- Alpine.js Test --}}
        <div x-data="{ open: false }" class="mt-6">
            <button
                @click="open = !open"
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors"
            >
                Toggle Alpine Test
            </button>
            <div x-show="open" x-transition class="mt-3 p-3 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                <p class="text-sm text-green-700 dark:text-green-400 font-medium">
                    ✅ Alpine.js bekerja dengan baik di dalam master layout!
                </p>
            </div>
        </div>
    </div>
@endsection
