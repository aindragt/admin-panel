@extends('layouts.app')

@section('title', 'Dashboard — ' . config('app.name'))
@section('page-title', 'Dashboard')

@section('content')
    @php
    // Data Dummy untuk Tab 1: General CMS
    $cmsStats = [
        ['label' => 'Total Artikel',     'value' => '142',    'change' => '+8 minggu ini',  'icon' => 'document-text',  'color' => 'blue'],
        ['label' => 'Pengguna Aktif',    'value' => '1.284',  'change' => '+12.5%',         'icon' => 'users',          'color' => 'green'],
        ['label' => 'Komentar Pending',  'value' => '37',     'change' => '5 hari ini',     'icon' => 'chat',           'color' => 'yellow'],
        ['label' => 'Halaman Dilihat',   'value' => '58.420', 'change' => '+4.6%',          'icon' => 'eye',            'color' => 'purple'],
    ];

    $quickActions = [
        ['label' => 'Artikel Baru',      'route' => '#', 'icon' => 'plus-document', 'color' => 'indigo'],
        ['label' => 'Tambah User',       'route' => '#', 'icon' => 'user-plus',     'color' => 'green'],
        ['label' => 'Moderasi Komentar', 'route' => '#', 'icon' => 'chat-bubble',  'color' => 'yellow'],
        ['label' => 'Lihat Laporan',     'route' => '#', 'icon' => 'chart-bar',     'color' => 'purple'],
    ];

    $todoItems = [
        ['title' => 'Review 12 artikel yang menunggu persetujuan',      'done' => false, 'priority' => 'high'],
        ['title' => 'Balas 5 pertanyaan dari pengguna terdaftar',        'done' => false, 'priority' => 'medium'],
        ['title' => 'Update konten halaman "Tentang Kami"',              'done' => true,  'priority' => 'low'],
        ['title' => 'Publikasi newsletter edisi minggu ini',             'done' => false, 'priority' => 'high'],
        ['title' => 'Backup database sebelum update plugin',             'done' => true,  'priority' => 'medium'],
    ];

    // Data Dummy untuk Tab 3: System Analytics
    $systemStats = [
        ['label' => 'Total Kunjungan',    'value' => '58.420', 'change' => '+4.6%',  'icon' => 'globe',  'color' => 'blue'],
        ['label' => 'Sesi Aktif',         'value' => '284',    'change' => '+2.1%',  'icon' => 'cursor-click', 'color' => 'green'],
        ['label' => 'Bounce Rate',        'value' => '38.2%',  'change' => '-1.8%',  'icon' => 'trending-down',  'color' => 'yellow'],
        ['label' => 'Waktu Respons',      'value' => '142ms',  'change' => '-12ms',  'icon' => 'clock',  'color' => 'purple'],
    ];

    $serverResources = [
        ['label' => 'CPU Usage',    'value' => 68, 'color' => 'indigo'],
        ['label' => 'RAM Usage',    'value' => 82, 'color' => 'amber'],
        ['label' => 'Storage Disk', 'value' => 45, 'color' => 'emerald'],
        ['label' => 'Network I/O',  'value' => 31, 'color' => 'sky'],
    ];

    $colorMap = [
        'indigo'  => 'bg-indigo-500',
        'amber'   => 'bg-amber-500',
        'emerald' => 'bg-emerald-500',
        'sky'     => 'bg-sky-500',
    ];
    @endphp

    {{-- Global x-data wrapper for Tabbed Interface --}}
    <div x-data="{ activeTab: 'general' }" class="space-y-6">
        
        {{-- PAGE HEADER WITH GLOBAL FILTER --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Selamat datang kembali di panel administrasi Anda.</p>
            </div>
            <div>
                <select
                    class="px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-700 text-sm
                           bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300
                           focus:outline-none focus:ring-2 focus:ring-indigo-500/40 cursor-pointer transition-all"
                >
                    <option>Hari Ini</option>
                    <option selected>Bulan Ini</option>
                    <option>3 Bulan Terakhir</option>
                    <option>Tahun Ini</option>
                </select>
            </div>
        </div>

        {{-- TAB NAVIGATION BAR --}}
        <div class="border-b border-gray-200 dark:border-gray-800">
            <nav class="-mb-px flex gap-1 overflow-x-auto" aria-label="Dashboard Tabs">
                <button @click="activeTab = 'general'"
                        :class="activeTab === 'general'
                            ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400 font-semibold'
                            : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300'"
                        class="whitespace-nowrap border-b-2 pb-3 pt-1 px-4 text-sm transition-colors focus:outline-none">
                    General CMS
                </button>
                <button @click="activeTab = 'ecommerce'"
                        :class="activeTab === 'ecommerce'
                            ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400 font-semibold'
                            : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300'"
                        class="whitespace-nowrap border-b-2 pb-3 pt-1 px-4 text-sm transition-colors focus:outline-none">
                    E-Commerce
                </button>
                <button @click="activeTab = 'system'"
                        :class="activeTab === 'system'
                            ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400 font-semibold'
                            : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300'"
                        class="whitespace-nowrap border-b-2 pb-3 pt-1 px-4 text-sm transition-colors focus:outline-none">
                    System Analytics
                </button>
            </nav>
        </div>

        {{-- TAB PANEL 1: GENERAL CMS --}}
        <div x-show="activeTab === 'general'" x-transition class="space-y-6">
            {{-- 4 Stat Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach ($cmsStats as $stat)
                    <x-ui.stat-card
                        :label="$stat['label']"
                        :value="$stat['value']"
                        :change="$stat['change']"
                        trend="up"
                        :icon="$stat['icon']"
                        :color="$stat['color']"
                    />
                @endforeach
            </div>

            {{-- Grid layout: Quick Actions & To-Do List --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                {{-- Quick Actions Widget --}}
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-5">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-4">⚡ Quick Actions</h3>
                    <div class="grid grid-cols-2 gap-3">
                        {{-- Action 1: Artikel Baru --}}
                        <a href="#"
                           class="flex flex-col items-center gap-2 p-4 rounded-xl border border-gray-100 dark:border-gray-800
                                  hover:bg-indigo-50 dark:hover:bg-indigo-500/5 hover:border-indigo-200 dark:hover:border-indigo-800
                                  transition-all group text-center">
                            <div class="w-10 h-10 rounded-lg bg-indigo-100 dark:bg-indigo-500/10 flex items-center justify-center
                                        group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-medium text-gray-700 dark:text-gray-300">Artikel Baru</span>
                        </a>

                        {{-- Action 2: Tambah User --}}
                        <a href="#"
                           class="flex flex-col items-center gap-2 p-4 rounded-xl border border-gray-100 dark:border-gray-800
                                  hover:bg-green-50 dark:hover:bg-green-500/5 hover:border-green-200 dark:hover:border-green-800
                                  transition-all group text-center">
                            <div class="w-10 h-10 rounded-lg bg-green-100 dark:bg-green-500/10 flex items-center justify-center
                                        group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-medium text-gray-700 dark:text-gray-300">Tambah User</span>
                        </a>

                        {{-- Action 3: Moderasi Komentar --}}
                        <a href="#"
                           class="flex flex-col items-center gap-2 p-4 rounded-xl border border-gray-100 dark:border-gray-800
                                  hover:bg-yellow-50 dark:hover:bg-yellow-500/5 hover:border-yellow-200 dark:hover:border-yellow-800
                                  transition-all group text-center">
                            <div class="w-10 h-10 rounded-lg bg-yellow-100 dark:bg-yellow-500/10 flex items-center justify-center
                                        group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-medium text-gray-700 dark:text-gray-300">Moderasi Komentar</span>
                        </a>

                        {{-- Action 4: Lihat Laporan --}}
                        <a href="#"
                           class="flex flex-col items-center gap-2 p-4 rounded-xl border border-gray-100 dark:border-gray-800
                                  hover:bg-purple-50 dark:hover:bg-purple-500/5 hover:border-purple-200 dark:hover:border-purple-800
                                  transition-all group text-center">
                            <div class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-500/10 flex items-center justify-center
                                        group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-medium text-gray-700 dark:text-gray-300">Lihat Laporan</span>
                        </a>
                    </div>
                </div>

                {{-- Interactive To-Do List --}}
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-5"
                     x-data="{
                         todos: [
                             { title: 'Review 12 artikel yang menunggu persetujuan', done: false, priority: 'high' },
                             { title: 'Balas 5 pertanyaan dari pengguna terdaftar',   done: false, priority: 'medium' },
                             { title: 'Update konten halaman &quot;Tentang Kami&quot;',           done: true,  priority: 'low' },
                             { title: 'Publikasi newsletter edisi minggu ini',        done: false, priority: 'high' },
                             { title: 'Backup database sebelum update plugin',        done: true,  priority: 'medium' }
                         ]
                     }">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">📋 Tugas & Moderasi</h3>
                        <span class="text-xs text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 px-2.5 py-1 rounded-full font-medium" 
                              x-text="todos.filter(t => !t.done).length + ' tersisa'"></span>
                    </div>
                    <div class="space-y-3">
                        <template x-for="(todo, index) in todos" :key="index">
                            <div class="flex items-start gap-3 p-2.5 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors cursor-pointer select-none"
                                 @click="todo.done = !todo.done">
                                <div :class="todo.done ? 'bg-indigo-500 border-indigo-500 dark:bg-indigo-600 dark:border-indigo-600' : 'border-gray-300 dark:border-gray-600'"
                                     class="mt-0.5 w-4 h-4 rounded border-2 flex-shrink-0 flex items-center justify-center transition-colors">
                                    <svg x-show="todo.done" class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <span :class="todo.done ? 'line-through text-gray-400 dark:text-gray-500' : 'text-gray-700 dark:text-gray-300'"
                                          class="text-sm leading-snug break-words"
                                          x-text="todo.title"></span>
                                </div>
                                <template x-if="!todo.done">
                                    <span :class="{
                                        'bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-400 border-red-200 dark:border-red-800/30': todo.priority === 'high',
                                        'bg-yellow-50 text-yellow-700 dark:bg-yellow-900/20 dark:text-yellow-400 border-yellow-200 dark:border-yellow-800/30': todo.priority === 'medium',
                                        'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400 border-blue-200 dark:border-blue-800/30': todo.priority === 'low'
                                    }" class="text-[10px] font-semibold px-2 py-0.5 rounded border capitalize flex-shrink-0">
                                        <span x-text="todo.priority"></span>
                                    </span>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB PANEL 2: E-COMMERCE --}}
        <div x-show="activeTab === 'ecommerce'" 
             x-transition 
             @click.once="$dispatch('init-ecommerce-charts')"
             style="display:none;" 
             class="space-y-6">
            
            {{-- 4 Stat Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <x-ui.stat-card
                    label="Total Users"
                    value="1,284"
                    change="+12.5%"
                    trend="up"
                    icon="users"
                    color="blue"
                />

                <x-ui.stat-card
                    label="Total Orders"
                    value="843"
                    change="+8.2%"
                    trend="up"
                    icon="shopping-bag"
                    color="green"
                />

                <x-ui.stat-card
                    label="Revenue"
                    value="$24,780"
                    change="-3.1%"
                    trend="down"
                    icon="currency-dollar"
                    color="yellow"
                />

                <x-ui.stat-card
                    label="Growth Rate"
                    value="24.5%"
                    change="+4.6%"
                    trend="up"
                    icon="trending-up"
                    color="purple"
                />
            </div>

            {{-- Charts --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                {{-- Area Chart --}}
                <div class="lg:col-span-2 bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-5">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Revenue Overview</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Performa revenue & expenses sepanjang tahun</p>
                        </div>
                        <span class="px-2.5 py-1 text-xs font-medium bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400 rounded-full">
                            2024
                        </span>
                    </div>
                    <div id="chart-revenue"></div>
                </div>

                {{-- Donut Chart --}}
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-5">
                    <div class="mb-4">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">Traffic Source</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Sumber kunjungan bulan ini</p>
                    </div>
                    <div id="chart-traffic"></div>
                </div>
            </div>

            {{-- Recent Activity Table --}}
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200 dark:border-gray-800">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">Aktivitas Terbaru</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">8 aktivitas terakhir di sistem</p>
                    </div>
                    <a href="#" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">
                        Lihat semua →
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/30">
                                <th class="px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">User</th>
                                <th class="px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aktivitas</th>
                                <th class="px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden sm:table-cell">Waktu</th>
                                <th class="px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @php
                            $activities = [
                                ['name' => 'Budi Santoso',    'email' => 'budi@example.com',    'action' => 'Login ke sistem',         'time' => '2 menit lalu',    'status' => 'success'],
                                ['name' => 'Siti Rahayu',     'email' => 'siti@example.com',    'action' => 'Update profil',           'time' => '15 menit lalu',   'status' => 'success'],
                                ['name' => 'Ahmad Fauzi',     'email' => 'ahmad@example.com',   'action' => 'Buat order baru #1042',   'time' => '32 menit lalu',   'status' => 'pending'],
                                ['name' => 'Dewi Lestari',    'email' => 'dewi@example.com',    'action' => 'Upload dokumen',          'time' => '1 jam lalu',      'status' => 'success'],
                                ['name' => 'Rudi Hermawan',   'email' => 'rudi@example.com',    'action' => 'Gagal login (3x)',        'time' => '2 jam lalu',      'status' => 'danger'],
                                ['name' => 'Maya Putri',      'email' => 'maya@example.com',    'action' => 'Export laporan PDF',      'time' => '3 jam lalu',      'status' => 'success'],
                                ['name' => 'Eko Prasetyo',    'email' => 'eko@example.com',     'action' => 'Hapus data produk',       'time' => '5 jam lalu',      'status' => 'warning'],
                                ['name' => 'Fitri Handayani', 'email' => 'fitri@example.com',   'action' => 'Tambah user baru',        'time' => '6 jam lalu',      'status' => 'success'],
                            ];

                            $statusConfig = [
                                'success' => ['bg' => 'bg-green-50 dark:bg-green-900/20',   'text' => 'text-green-700 dark:text-green-400',   'dot' => 'bg-green-500',   'label' => 'Berhasil'],
                                'pending' => ['bg' => 'bg-yellow-50 dark:bg-yellow-900/20', 'text' => 'text-yellow-700 dark:text-yellow-400', 'dot' => 'bg-yellow-500',  'label' => 'Pending'],
                                'warning' => ['bg' => 'bg-orange-50 dark:bg-orange-900/20', 'text' => 'text-orange-700 dark:text-orange-400', 'dot' => 'bg-orange-500',  'label' => 'Peringatan'],
                                'danger'  => ['bg' => 'bg-red-50 dark:bg-red-900/20',       'text' => 'text-red-700 dark:text-red-400',       'dot' => 'bg-red-500',     'label' => 'Gagal'],
                            ];
                            @endphp

                            @foreach($activities as $activity)
                            @php $cfg = $statusConfig[$activity['status']]; @endphp
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition-colors">
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-xs font-semibold text-indigo-700 dark:text-indigo-400 flex-shrink-0">
                                            {{ strtoupper(substr($activity['name'], 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white text-sm">{{ $activity['name'] }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $activity['email'] }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 text-gray-700 dark:text-gray-300">
                                    {{ $activity['action'] }}
                                </td>
                                <td class="px-5 py-3.5 text-gray-500 dark:text-gray-400 hidden sm:table-cell">
                                    {{ $activity['time'] }}
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $cfg['bg'] }} {{ $cfg['text'] }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $cfg['dot'] }}"></span>
                                        {{ $cfg['label'] }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-5 py-3 border-t border-gray-100 dark:border-gray-800 text-center">
                    <p class="text-xs text-gray-400 dark:text-gray-500">
                        Menampilkan 8 dari 128 aktivitas
                    </p>
                </div>
            </div>
        </div>

        {{-- TAB PANEL 3: SYSTEM ANALYTICS --}}
        <div x-show="activeTab === 'system'" 
             x-transition 
             @click.once="$dispatch('init-system-charts')"
             style="display:none;" 
             class="space-y-6">
            
            {{-- 4 Stat Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach ($systemStats as $stat)
                    <x-ui.stat-card
                        :label="$stat['label']"
                        :value="$stat['value']"
                        :change="$stat['change']"
                        trend="up"
                        :icon="$stat['icon']"
                        :color="$stat['color']"
                    />
                @endforeach
            </div>

            {{-- Bar Chart and Server Resources Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                {{-- Bar Chart: Perbandingan Kunjungan Harian --}}
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-5">
                    <div class="mb-4">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">Perbandingan Kunjungan</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Statistik harian minggu ini vs minggu lalu</p>
                    </div>
                    <div id="chart-visits"></div>
                </div>

                {{-- Server Resources (Progress Bar) --}}
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-5">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-5">🖥️ Server Resources</h3>
                    <div class="space-y-5">
                        @foreach ($serverResources as $resource)
                            <div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $resource['label'] }}</span>
                                    <span class="text-sm font-semibold 
                                        {{ $resource['value'] >= 80 ? 'text-red-500 dark:text-red-400' : ($resource['value'] >= 60 ? 'text-amber-500 dark:text-amber-400' : 'text-gray-600 dark:text-gray-400') }}">
                                        {{ $resource['value'] }}%
                                    </span>
                                </div>
                                <div class="w-full h-2 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
                                    <div class="h-2 rounded-full transition-all duration-700 {{ $colorMap[$resource['color']] }} {{ $resource['value'] >= 80 ? '!bg-red-500' : '' }}"
                                         style="width: {{ $resource['value'] }}%">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const isDark = () => document.documentElement.classList.contains('dark');

        let lineChart = null;
        let donutChart = null;
        let barChart = null;

        const lineOptions = {
            chart: {
                type: 'area',
                height: 280,
                toolbar: { show: false },
                background: 'transparent',
                fontFamily: 'Inter, sans-serif',
            },
            theme: { mode: isDark() ? 'dark' : 'light' },
            colors: ['#6366f1', '#10b981'],
            series: [
                {
                    name: 'Revenue',
                    data: [31000, 40000, 28000, 51000, 42000, 60000, 55000, 72000, 65000, 80000, 75000, 91000],
                },
                {
                    name: 'Expenses',
                    data: [11000, 32000, 45000, 32000, 34000, 52000, 41000, 49000, 38000, 55000, 48000, 60000],
                },
            ],
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                labels: { style: { fontFamily: 'Inter, sans-serif', fontSize: '12px' } },
            },
            yaxis: {
                labels: {
                    formatter: (val) => '$' + (val / 1000).toFixed(0) + 'k',
                    style: { fontFamily: 'Inter, sans-serif', fontSize: '12px' },
                },
            },
            fill: {
                type: 'gradient',
                gradient: { shadeIntensity: 1, opacityFrom: 0.35, opacityTo: 0.05 },
            },
            stroke: { curve: 'smooth', width: 2.5 },
            legend: { position: 'top', horizontalAlign: 'right', fontFamily: 'Inter, sans-serif' },
            grid: { borderColor: isDark() ? '#374151' : '#e5e7eb' },
            dataLabels: { enabled: false },
            tooltip: { theme: isDark() ? 'dark' : 'light', x: { format: 'MMM' } },
        };

        const donutOptions = {
            chart: {
                type: 'donut',
                height: 280,
                background: 'transparent',
                fontFamily: 'Inter, sans-serif',
            },
            theme: { mode: isDark() ? 'dark' : 'light' },
            colors: ['#6366f1', '#10b981', '#f59e0b', '#ef4444'],
            series: [44, 27, 18, 11],
            labels: ['Organic', 'Direct', 'Social', 'Referral'],
            legend: {
                position: 'bottom',
                fontFamily: 'Inter, sans-serif',
                fontSize: '13px',
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total',
                                fontFamily: 'Inter, sans-serif',
                                fontSize: '14px',
                                formatter: () => '100%',
                            },
                        },
                    },
                },
            },
            dataLabels: { enabled: false },
            tooltip: { theme: isDark() ? 'dark' : 'light' },
        };

        const barOptions = {
            chart: {
                type: 'bar',
                height: 280,
                toolbar: { show: false },
                background: 'transparent',
                fontFamily: 'Inter, sans-serif',
            },
            theme: { mode: isDark() ? 'dark' : 'light' },
            colors: ['#6366f1', '#10b981'],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    borderRadius: 6,
                },
            },
            series: [
                { name: 'Minggu Ini',   data: [1200, 1900, 1500, 2200, 1800, 2500, 2100] },
                { name: 'Minggu Lalu',  data: [900,  1600, 1200, 1900, 1500, 2100, 1800] },
            ],
            xaxis: {
                categories: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                labels: { style: { fontFamily: 'Inter, sans-serif', fontSize: '12px' } },
            },
            yaxis: {
                labels: {
                    formatter: (val) => val >= 1000 ? (val / 1000).toFixed(1) + 'k' : val,
                    style: { fontFamily: 'Inter, sans-serif', fontSize: '12px' },
                },
            },
            legend: { position: 'top', horizontalAlign: 'right', fontFamily: 'Inter, sans-serif' },
            grid: { borderColor: isDark() ? '#374151' : '#e5e7eb' },
            dataLabels: { enabled: false },
            tooltip: { theme: isDark() ? 'dark' : 'light' },
        };

        // Initialize E-Commerce charts on tab click to prevent broken rendering in hidden tabs
        let ecommerceChartsInitialized = false;
        window.addEventListener('init-ecommerce-charts', () => {
            if (ecommerceChartsInitialized) return;
            ecommerceChartsInitialized = true;

            lineChart = new ApexCharts(document.querySelector('#chart-revenue'), lineOptions);
            lineChart.render();

            donutChart = new ApexCharts(document.querySelector('#chart-traffic'), donutOptions);
            donutChart.render();
        });

        // Initialize System Analytics charts on tab click
        let systemChartsInitialized = false;
        window.addEventListener('init-system-charts', () => {
            if (systemChartsInitialized) return;
            systemChartsInitialized = true;

            barChart = new ApexCharts(document.querySelector('#chart-visits'), barOptions);
            barChart.render();
        });

        // MutationObserver untuk auto-sync tema chart saat dark mode di-toggle tanpa refresh
        const observer = new MutationObserver(() => {
            const mode = isDark() ? 'dark' : 'light';
            const gridColor = isDark() ? '#374151' : '#e5e7eb';
            if (lineChart) {
                lineChart.updateOptions({ theme: { mode }, tooltip: { theme: mode }, grid: { borderColor: gridColor } });
            }
            if (donutChart) {
                donutChart.updateOptions({ theme: { mode }, tooltip: { theme: mode } });
            }
            if (barChart) {
                barChart.updateOptions({ theme: { mode }, tooltip: { theme: mode }, grid: { borderColor: gridColor } });
            }
        });
        observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
    });
    </script>
@endpush
