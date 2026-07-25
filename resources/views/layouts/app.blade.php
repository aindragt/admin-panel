<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Admin Panel'))</title>

    {{-- Google Fonts: Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Vite Assets (CSS + JS) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Stack untuk CSS tambahan per-halaman --}}
    @stack('styles')
</head>
<body class="bg-gray-100 dark:bg-gray-900 font-sans text-gray-900 dark:text-gray-100 antialiased">

    {{-- Sidebar --}}
    @include('components.layout.sidebar')

    {{-- Main Wrapper --}}
    <div class="flex flex-col min-h-screen md:pl-64">

        {{-- Navbar --}}
        @include('components.layout.navbar')

        {{-- Main Content --}}
        <main class="flex-1 p-6">
            @yield('content')
        </main>

        {{-- Footer --}}
        @include('components.layout.footer')

    </div>

    {{-- Stack untuk JavaScript tambahan per-halaman --}}
    @stack('scripts')
</body>
</html>
