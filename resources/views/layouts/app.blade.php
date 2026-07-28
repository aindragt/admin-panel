<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{
        darkMode: localStorage.getItem('color-theme') === 'dark' || (!localStorage.getItem('color-theme') && window.matchMedia('(prefers-color-scheme: dark)').matches),
        sidebarOpen: window.innerWidth >= 1024
    }"
    x-init="$watch('darkMode', val => {
        localStorage.setItem('color-theme', val ? 'dark' : 'light');
        val ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark');
    })"
    :class="{ 'dark': darkMode }"
>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Admin Panel'))</title>

    {{-- Google Fonts: Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,300..800;1,14..32,300..800&display=swap" rel="stylesheet">

    {{-- Tailwind CSS Play CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Per-page styles --}}
    @stack('styles')
</head>
<body class="bg-gray-50 dark:bg-gray-950 font-sans text-gray-900 dark:text-gray-100 antialiased">

    <div class="flex h-screen overflow-hidden">

        {{-- Sidebar --}}
        @include('layouts.partials.sidebar')

        {{-- Main Content Area --}}
        <div class="flex flex-col flex-1 overflow-hidden">

            {{-- Navbar --}}
            @include('layouts.partials.navbar')

            {{-- Scrollable content --}}
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>

            {{-- Footer --}}
            @include('layouts.partials.footer')

        </div>
    </div>

    {{-- Per-page scripts --}}
    @stack('scripts')
</body>
</html>
