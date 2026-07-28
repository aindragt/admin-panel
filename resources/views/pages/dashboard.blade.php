@extends('layouts.app')

@section('title', 'Dashboard — ' . config('app.name'))
@section('page-title', 'Dashboard')

@section('content')
    {{-- SECTION 1: Stats Overview (4 Stat Cards) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
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

    {{-- SECTION 2: Charts (2/3 Line + 1/3 Donut) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-6">
        {{-- Area Chart: lg:col-span-2 --}}
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

        {{-- Donut Chart: 1 kolom --}}
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-5">
            <div class="mb-4">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">Traffic Source</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Sumber kunjungan bulan ini</p>
            </div>
            <div id="chart-traffic"></div>
        </div>
    </div>

    {{-- SECTION 3: Recent Activity Table --}}
    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
        {{-- Table Header --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200 dark:border-gray-800">
            <div>
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">Aktivitas Terbaru</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">8 aktivitas terakhir di sistem</p>
            </div>
            <a href="#" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">
                Lihat semua →
            </a>
        </div>

        {{-- Table Wrapper for Responsiveness --}}
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
                        {{-- User Info --}}
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

                        {{-- Action --}}
                        <td class="px-5 py-3.5 text-gray-700 dark:text-gray-300">
                            {{ $activity['action'] }}
                        </td>

                        {{-- Time (hidden on mobile) --}}
                        <td class="px-5 py-3.5 text-gray-500 dark:text-gray-400 hidden sm:table-cell">
                            {{ $activity['time'] }}
                        </td>

                        {{-- Status Badge --}}
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

        {{-- Table Footer --}}
        <div class="px-5 py-3 border-t border-gray-100 dark:border-gray-800 text-center">
            <p class="text-xs text-gray-400 dark:text-gray-500">
                Menampilkan 8 dari 128 aktivitas
            </p>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Deteksi Dark Mode
        const isDark = () => document.documentElement.classList.contains('dark');

        // LINE/AREA CHART: Revenue Overview
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

        const lineChart = new ApexCharts(document.querySelector('#chart-revenue'), lineOptions);
        lineChart.render();

        // DONUT CHART: Traffic Source
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

        const donutChart = new ApexCharts(document.querySelector('#chart-traffic'), donutOptions);
        donutChart.render();

        // MutationObserver untuk auto-sync tema chart saat dark mode di-toggle tanpa refresh
        const observer = new MutationObserver(() => {
            const mode = isDark() ? 'dark' : 'light';
            lineChart.updateOptions({ theme: { mode }, tooltip: { theme: mode }, grid: { borderColor: isDark() ? '#374151' : '#e5e7eb' } });
            donutChart.updateOptions({ theme: { mode }, tooltip: { theme: mode } });
        });
        observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
    });
    </script>
@endpush
