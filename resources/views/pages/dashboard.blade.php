@extends('layouts.app')
@section('title', 'Dashboard — ' . config('app.name'))
@section('page-title', 'Dashboard')

@section('content')
    {{-- SECTION 1: Stats Overview (Task 3) --}}
    <div class="grid grid-cols-1 gap-4 sm:gap-5 mb-6 sm:grid-cols-2 lg:grid-cols-4">
        <x-ui.stat-card label="Total Users"  value="1,284"  change="+12.5%" trend="up"   icon="users"           color="blue"   />
        <x-ui.stat-card label="Total Orders" value="843"    change="+8.2%"  trend="up"   icon="shopping-bag"    color="green"  />
        <x-ui.stat-card label="Revenue"      value="$24,780" change="-3.1%" trend="down" icon="currency-dollar" color="yellow" />
        <x-ui.stat-card label="Growth Rate"  value="24.5%"  change="+4.6%"  trend="up"   icon="trending-up"     color="purple" />
    </div>

    {{-- SECTION 2: Charts (Task 4) --}}
    <div class="grid grid-cols-1 gap-4 sm:gap-5 mb-6 lg:grid-cols-3">
        {{-- Area Chart: Revenue Overview --}}
        <div class="p-5 bg-white border border-gray-200 rounded-2xl shadow-sm lg:col-span-2 dark:bg-gray-900 dark:border-gray-800">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">Revenue Overview</h3>
                <span class="text-xs font-medium text-gray-400 dark:text-gray-500">Jan – Dec {{ date('Y') }}</span>
            </div>
            <div id="chart-revenue"></div>
        </div>

        {{-- Donut Chart: Traffic Source --}}
        <div class="p-5 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-gray-900 dark:border-gray-800">
            <h3 class="mb-4 text-base font-semibold text-gray-900 dark:text-white">Traffic Source</h3>
            <div id="chart-traffic"></div>
        </div>
    </div>

    {{-- SECTION 3: Recent Activity Table (Task 5) --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-gray-900 dark:border-gray-800 overflow-hidden">
        <div class="flex items-center justify-between p-5 border-b border-gray-200 dark:border-gray-800">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Aktivitas Terbaru</h3>
            <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors">
                Lihat semua &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50/80 dark:bg-gray-800/50 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 font-medium tracking-wide">User</th>
                        <th scope="col" class="px-6 py-3 font-medium tracking-wide">Aktivitas</th>
                        <th scope="col" class="px-6 py-3 font-medium tracking-wide hidden sm:table-cell">Waktu</th>
                        <th scope="col" class="px-6 py-3 font-medium tracking-wide">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @php
                        // Dummy Data untuk tabel (8 baris)
                        $activities = [
                            ['name' => 'Alice Johnson', 'email' => 'alice@example.com', 'action' => 'Membuat pesanan baru', 'time' => '5 menit lalu', 'status' => 'success', 'color' => 'green'],
                            ['name' => 'Bob Smith', 'email' => 'bob@example.com', 'action' => 'Mendaftar akun', 'time' => '15 menit lalu', 'status' => 'pending', 'color' => 'yellow'],
                            ['name' => 'Charlie Davis', 'email' => 'charlie@example.com', 'action' => 'Gagal login (3x)', 'time' => '1 jam lalu', 'status' => 'danger', 'color' => 'red'],
                            ['name' => 'Diana Rose', 'email' => 'diana@example.com', 'action' => 'Update profil', 'time' => '2 jam lalu', 'status' => 'success', 'color' => 'green'],
                            ['name' => 'Evan Wright', 'email' => 'evan@example.com', 'action' => 'Membatalkan pesanan', 'time' => '3 jam lalu', 'status' => 'warning', 'color' => 'orange'],
                            ['name' => 'Fiona Gallagher', 'email' => 'fiona@example.com', 'action' => 'Membayar tagihan', 'time' => '5 jam lalu', 'status' => 'success', 'color' => 'green'],
                            ['name' => 'George Miller', 'email' => 'george@example.com', 'action' => 'Menghapus data', 'time' => '1 hari lalu', 'status' => 'danger', 'color' => 'red'],
                            ['name' => 'Hannah Abbott', 'email' => 'hannah@example.com', 'action' => 'Membuka tiket support', 'time' => '1 hari lalu', 'status' => 'pending', 'color' => 'yellow'],
                        ];
                    @endphp

                    @foreach($activities as $activity)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                        <td class="px-6 py-3.5 flex items-center gap-3 whitespace-nowrap">
                            <img class="w-8 h-8 rounded-full ring-2 ring-gray-100 dark:ring-gray-800" src="https://ui-avatars.com/api/?name={{ urlencode($activity['name']) }}&background=random" alt="Avatar">
                            <div class="min-w-0">
                                <div class="font-medium text-gray-900 dark:text-white truncate">{{ $activity['name'] }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $activity['email'] }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-3.5">{{ $activity['action'] }}</td>
                        <td class="px-6 py-3.5 hidden sm:table-cell whitespace-nowrap">{{ $activity['time'] }}</td>
                        <td class="px-6 py-3.5">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium rounded-full bg-{{ $activity['color'] }}-100 text-{{ $activity['color'] }}-800 dark:bg-{{ $activity['color'] }}-900/30 dark:text-{{ $activity['color'] }}-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-{{ $activity['color'] }}-500"></span>
                                {{ ucfirst($activity['status']) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4 text-sm text-gray-500 dark:text-gray-400 border-t border-gray-200 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/20">
            Menampilkan <span class="font-medium text-gray-700 dark:text-gray-300">8</span> dari <span class="font-medium text-gray-700 dark:text-gray-300">128</span> aktivitas
        </div>
    </div>
@endsection

@push('scripts')
    {{-- ApexCharts CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Cek apakah Dark Mode aktif di Tailwind (biasanya ada class 'dark' di <html>)
            const isDark = () => document.documentElement.classList.contains('dark');
            const getThemeMode = () => isDark() ? 'dark' : 'light';

            // 1. Konfigurasi Area Chart (Revenue)
            const revenueOptions = {
                series: [{
                    name: 'Revenue',
                    data: [3100, 4000, 2800, 5100, 4200, 10900, 10000, 11000, 9500, 12000, 11500, 14000]
                }, {
                    name: 'Expenses',
                    data: [2100, 2600, 2200, 3400, 2800, 5200, 4800, 6000, 5500, 7000, 6800, 8000]
                }],
                chart: {
                    height: 350,
                    type: 'area',
                    fontFamily: 'inherit',
                    toolbar: { show: false },
                    background: 'transparent'
                },
                theme: { mode: getThemeMode() },
                colors: ['#4f46e5', '#f43f5e'],
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 2.5 },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.35,
                        opacityTo: 0.05,
                        stops: [0, 90, 100]
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    fontFamily: 'inherit'
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: { labels: { formatter: (value) => "$" + value } },
                grid: {
                    borderColor: isDark() ? '#1f2937' : '#f3f4f6',
                    strokeDashArray: 4,
                }
            };

            // 2. Konfigurasi Donut Chart (Traffic)
            const trafficOptions = {
                series: [44, 27, 18, 11],
                labels: ['Organic', 'Direct', 'Social', 'Referral'],
                chart: {
                    type: 'donut',
                    height: 350,
                    fontFamily: 'inherit',
                    background: 'transparent'
                },
                theme: { mode: getThemeMode() },
                colors: ['#10b981', '#4f46e5', '#8b5cf6', '#f59e0b'],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '72%',
                            labels: {
                                show: true,
                                name: { show: true },
                                value: { show: true, fontWeight: 600 },
                                total: {
                                    show: true,
                                    showAlways: true,
                                    label: 'Total Visits',
                                    fontSize: '13px',
                                    color: isDark() ? '#9ca3af' : '#6b7280'
                                }
                            }
                        }
                    }
                },
                dataLabels: { enabled: false },
                legend: {
                    position: 'bottom',
                    fontFamily: 'inherit'
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: [isDark() ? '#111827' : '#ffffff']
                }
            };

            // Render Charts
            const revenueChart = new ApexCharts(document.querySelector("#chart-revenue"), revenueOptions);
            const trafficChart = new ApexCharts(document.querySelector("#chart-traffic"), trafficOptions);

            revenueChart.render();
            trafficChart.render();

            // 3. Auto-sync Dark Mode tanpa Refresh
            const observer = new MutationObserver(() => {
                const mode = getThemeMode();
                const gridColor = mode === 'dark' ? '#1f2937' : '#f3f4f6';
                const labelColor = mode === 'dark' ? '#9ca3af' : '#6b7280';
                const strokeColor = mode === 'dark' ? '#111827' : '#ffffff';

                revenueChart.updateOptions({
                    theme: { mode },
                    grid: { borderColor: gridColor }
                });

                trafficChart.updateOptions({
                    theme: { mode },
                    stroke: { colors: [strokeColor] },
                    plotOptions: { pie: { donut: { labels: { total: { color: labelColor } } } } }
                });
            });

            // Pantau perubahan atribut 'class' pada tag <html>
            observer.observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['class']
            });
        });
    </script>
@endpush