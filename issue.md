# Issue #3 — Desain Halaman Dashboard

**Status:** `Open`
**Priority:** 🔴 High
**Labels:** `feature`, `frontend`, `dashboard`, `UI`
**Depends On:** Issue #2 ✅ (Master Layout — sudah selesai)

---

## 🎯 Title & Objective

### Judul
**Implementasi Halaman Dashboard: Wajah Utama Admin Panel**

### Mengapa Issue Ini Penting?

Halaman Dashboard adalah **halaman pertama yang dilihat user setelah login**. Ini adalah "wajah" dari seluruh aplikasi admin panel kita. Kesan pertama sangat menentukan — jika dashboard terasa lambat, berantakan, atau membingungkan, user akan kehilangan kepercayaan pada seluruh sistem.

Dashboard yang baik punya satu tugas utama: **menyajikan ringkasan data (overview) yang relevan secara visual dan cepat dipahami.** User tidak perlu masuk ke halaman detail hanya untuk tahu kondisi umum sistem.

Berikut yang akan kita bangun dalam issue ini:

```
┌─────────────────────────────────────────────────────────┐
│  📊 Dashboard Overview                                   │
│                                                         │
│  ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌──────────┐  │
│  │ 👥 Users │ │ 📦 Orders│ │ 💰 Revenue│ │ 📈 Growth│  │  ← Stat Cards
│  │  1,234   │ │   567    │ │ $12,450  │ │  +24.5%  │  │
│  └──────────┘ └──────────┘ └──────────┘ └──────────┘  │
│                                                         │
│  ┌───────────────────────────┐ ┌─────────────────────┐ │
│  │  📉 Revenue Overview Chart│ │  🍩 Traffic Source  │ │  ← Charts
│  │  (Line Chart)             │ │  (Donut Chart)      │ │
│  └───────────────────────────┘ └─────────────────────┘ │
│                                                         │
│  ┌─────────────────────────────────────────────────┐   │
│  │  📋 Aktivitas Terbaru                            │   │  ← Recent Table
│  │  ───────────────────────────────────────────    │   │
│  │  User A | Login   | 2 menit lalu | ● Online    │   │
│  └─────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────┘
```

> 💡 **Catatan untuk kamu:** Issue ini banyak menggunakan dummy data (data palsu untuk testing tampilan). Fokus dulu pada **tampilan dan struktur** — data sesungguhnya akan diisi di issue-issue berikutnya saat kita membangun fitur backend.

---

## 📂 Component & Folder Strategy

### Struktur yang Harus Dibangun

```
resources/
└── views/
    ├── pages/
    │   └── dashboard.blade.php          # Halaman utama dashboard (UPDATE dari placeholder)
    │
    └── components/
        └── ui/
            ├── stat-card.blade.php      # [NEW] Reusable card statistik
            └── (file lain menyusul di issue berikutnya)
```

### Mengapa `stat-card` Harus Jadi Reusable Component?

Kita membutuhkan **4 stat card** di bagian atas, dan setiap card pada dasarnya punya struktur yang sama: ikon, label, nilai, dan perubahan (naik/turun). Kalau ditulis 4 kali secara manual, kamu akan melanggar prinsip **DRY (Don't Repeat Yourself)**.

Dengan menjadikannya Blade Component, kamu cukup tulis satu kali:

```html
{{-- Dipanggil seperti ini — bersih dan mudah dibaca --}}
<x-ui.stat-card
    label="Total Users"
    value="1,234"
    change="+12.5%"
    trend="up"
    icon="users"
    color="blue"
/>
```

### Cara Registrasi Blade Component

Laravel secara otomatis mendeteksi component di `resources/views/components/`. File `stat-card.blade.php` di dalam subfolder `ui/` akan dipanggil dengan tag `<x-ui.stat-card>` — tidak perlu registrasi manual!

---

## ✅ Step-by-Step Tasks

Ikuti checklist ini secara berurutan.

---

### 📋 Task 1: Update `dashboard.blade.php` — Struktur Dasar Halaman

File ini sudah ada sebagai placeholder dari Issue #1. Sekarang kita beri "nyawa" sesungguhnya.

- [ ] **1.1** Buka `resources/views/pages/dashboard.blade.php` dan **ganti seluruh isinya** dengan struktur halaman yang sudah menggunakan section dengan benar:

  ```html
  @extends('layouts.app')

  @section('title', 'Dashboard — ' . config('app.name'))
  @section('page-title', 'Dashboard')

  @push('styles')
      {{-- Style tambahan khusus halaman dashboard jika diperlukan --}}
  @endpush

  @section('content')

      {{-- ============================= --}}
      {{-- SECTION 1: Stats Overview    --}}
      {{-- ============================= --}}
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
          {{-- Stat cards akan diisi di Task 3 --}}
      </div>

      {{-- ============================= --}}
      {{-- SECTION 2: Charts Row        --}}
      {{-- ============================= --}}
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-6">
          {{-- Charts akan diisi di Task 4 --}}
      </div>

      {{-- ============================= --}}
      {{-- SECTION 3: Recent Activity   --}}
      {{-- ============================= --}}
      <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm">
          {{-- Tabel akan diisi di Task 5 --}}
      </div>

  @endsection

  @push('scripts')
      {{-- Script chart akan diisi di Task 4 --}}
  @endpush
  ```

- [ ] **1.2** Pastikan halaman bisa di-akses tanpa error di browser (`http://127.0.0.1:8000`) — halamannya boleh kosong dulu, yang penting tidak ada error.

---

### 🃏 Task 2: Buat Reusable Component `stat-card.blade.php`

- [ ] **2.1** Buat file baru di `resources/views/components/ui/stat-card.blade.php`:

  ```html
  {{--
      Reusable Stat Card Component
      Props:
        - $label   : string  — Nama metrik (contoh: "Total Users")
        - $value   : string  — Nilai utama (contoh: "1,234")
        - $change  : string  — Perubahan dalam persen (contoh: "+12.5%")
        - $trend   : string  — "up" atau "down" (menentukan warna dan ikon arah)
        - $icon    : string  — Nama ikon: "users" | "shopping-bag" | "currency-dollar" | "trending-up"
        - $color   : string  — "blue" | "green" | "yellow" | "purple"
  --}}

  @props([
      'label'  => 'Metric',
      'value'  => '0',
      'change' => '0%',
      'trend'  => 'up',
      'icon'   => 'users',
      'color'  => 'blue',
  ])

  @php
      $colors = [
          'blue'   => 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400',
          'green'  => 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400',
          'yellow' => 'bg-yellow-50 dark:bg-yellow-900/20 text-yellow-600 dark:text-yellow-400',
          'purple' => 'bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400',
      ];

      $icons = [
          'users'            => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v2h5M7 20v-2a3 3 0 015.356-1.857M7 20v2m5-10a3 3 0 100-6 3 3 0 000 6zm6 0a3 3 0 100-6 3 3 0 000 6z',
          'shopping-bag'     => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z',
          'currency-dollar'  => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
          'trending-up'      => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6',
      ];

      $colorClass = $colors[$color] ?? $colors['blue'];
      $iconPath   = $icons[$icon] ?? $icons['users'];
      $trendUp    = $trend === 'up';
  @endphp

  <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-5 flex items-start gap-4 hover:shadow-md transition-shadow">

      {{-- Icon Badge --}}
      <div class="flex-shrink-0 w-12 h-12 rounded-xl {{ $colorClass }} flex items-center justify-center">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
              <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPath }}"/>
          </svg>
      </div>

      {{-- Content --}}
      <div class="flex-1 min-w-0">
          <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider truncate">
              {{ $label }}
          </p>
          <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">
              {{ $value }}
          </p>
          <div class="mt-1 flex items-center gap-1">
              <svg class="w-3.5 h-3.5 {{ $trendUp ? 'text-green-500' : 'text-red-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  @if($trendUp)
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/>
                  @else
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                  @endif
              </svg>
              <span class="text-xs font-medium {{ $trendUp ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                  {{ $change }}
              </span>
              <span class="text-xs text-gray-400 dark:text-gray-500">vs bulan lalu</span>
          </div>
      </div>
  </div>
  ```

- [ ] **2.2** Verifikasi: Tidak ada syntax error PHP atau tag yang tidak tertutup.

---

### 📊 Task 3: Integrasikan Stat Cards ke Dashboard

Sekarang kita gunakan component yang baru dibuat.

- [ ] **3.1** Buka kembali `dashboard.blade.php` dan isi bagian **SECTION 1** dengan 4 stat card menggunakan dummy data:

  ```html
  {{-- SECTION 1: Stats Overview --}}
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
  ```

- [ ] **3.2** Buka browser dan verifikasi 4 card muncul dalam grid yang rapi. Coba resize browser untuk memastikan grid responsive bekerja:
  - Mobile (< 640px): 1 kolom
  - Tablet (≥ 640px): 2 kolom
  - Desktop (≥ 1024px): 4 kolom

---

### 📈 Task 4: Integrasi ApexCharts — Line Chart & Donut Chart

Kita akan menggunakan **ApexCharts** via CDN karena:
- Dokumentasi lengkap dan mudah dipahami
- Animasi bawaan yang indah
- Mendukung dark mode dengan mudah via opsi `theme`
- Tidak perlu build step tambahan

- [ ] **4.1** Tambahkan script ApexCharts via CDN di `@push('scripts')` di bawah halaman dashboard:

  ```html
  @push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script>
  document.addEventListener('DOMContentLoaded', function () {

      // ─── Deteksi Dark Mode ──────────────────────────────────────────
      const isDark = () => document.documentElement.classList.contains('dark');

      // ─── LINE CHART: Revenue Overview ──────────────────────────────
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

      // ─── DONUT CHART: Traffic Source ───────────────────────────────
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

      // ─── Sync chart theme saat dark mode di-toggle ─────────────────
      // (Observasi perubahan class 'dark' pada elemen <html>)
      const observer = new MutationObserver(() => {
          const mode = isDark() ? 'dark' : 'light';
          lineChart.updateOptions({ theme: { mode }, tooltip: { theme: mode }, grid: { borderColor: isDark() ? '#374151' : '#e5e7eb' } });
          donutChart.updateOptions({ theme: { mode }, tooltip: { theme: mode } });
      });
      observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });

  });
  </script>
  @endpush
  ```

  > 💡 **Penjelasan MutationObserver:** Karena dark mode di-toggle dengan menambahkan/menghapus class `dark` di tag `<html>`, kita menggunakan `MutationObserver` untuk mendeteksi perubahan itu secara real-time dan mengupdate tema chart secara otomatis. Tidak perlu refresh!

- [ ] **4.2** Isi bagian **SECTION 2** di `dashboard.blade.php` dengan container chart:

  ```html
  {{-- SECTION 2: Charts Row --}}
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-6">

      {{-- Line Chart (mengambil 2/3 lebar di desktop) --}}
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

      {{-- Donut Chart (mengambil 1/3 lebar di desktop) --}}
      <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-5">
          <div class="mb-4">
              <h3 class="text-base font-semibold text-gray-900 dark:text-white">Traffic Source</h3>
              <p class="text-sm text-gray-500 dark:text-gray-400">Sumber kunjungan bulan ini</p>
          </div>
          <div id="chart-traffic"></div>
      </div>

  </div>
  ```

- [ ] **4.3** Verifikasi kedua chart berhasil di-render di browser. Coba toggle dark mode — chart harus berubah tema secara otomatis tanpa refresh.

---

### 📋 Task 5: Buat Tabel "Aktivitas Terbaru"

- [ ] **5.1** Isi bagian **SECTION 3** di `dashboard.blade.php` dengan tabel aktivitas menggunakan dummy data:

  ```html
  {{-- SECTION 3: Recent Activity Table --}}
  <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm">

      {{-- Table Header --}}
      <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200 dark:border-gray-800">
          <div>
              <h3 class="text-base font-semibold text-gray-900 dark:text-white">Aktivitas Terbaru</h3>
              <p class="text-sm text-gray-500 dark:text-gray-400">10 aktivitas terakhir di sistem</p>
          </div>
          <a href="#" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">
              Lihat semua →
          </a>
      </div>

      {{-- Table --}}
      <div class="overflow-x-auto">
          <table class="w-full text-sm">
              <thead>
                  <tr class="border-b border-gray-100 dark:border-gray-800">
                      <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">User</th>
                      <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aktivitas</th>
                      <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden sm:table-cell">Waktu</th>
                      <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
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
                  <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">

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
  ```

- [ ] **5.2** Verifikasi: Tabel muncul dengan rapi dan badge status berwarna sesuai.

---

### 🔀 Task 6: Commit & Push ke Branch Baru

- [ ] **6.1** Buat branch baru dari `main`:
  ```bash
  git checkout -b feature/dashboard-ui
  ```

- [ ] **6.2** Staging semua file yang berubah:
  ```bash
  git add resources/views/pages/dashboard.blade.php
  git add resources/views/components/ui/stat-card.blade.php
  ```

- [ ] **6.3** Commit:
  ```bash
  git commit -m "feat: implement dashboard UI with stat cards, charts, and activity table"
  ```

- [ ] **6.4** Push ke remote:
  ```bash
  git push origin feature/dashboard-ui
  ```

---

## 🏁 Acceptance Criteria

Issue ini dinyatakan **Done** jika dan hanya jika **semua** kriteria berikut terpenuhi:

| # | Kriteria | Cara Verifikasi |
|---|----------|-----------------|
| **AC-1** | ✅ 4 Stat Cards tampil dalam grid responsive | Desktop: 4 kolom → Tablet: 2 kolom → Mobile: 1 kolom |
| **AC-2** | ✅ Stat Card menggunakan reusable Blade Component | Cek bahwa `<x-ui.stat-card>` dipanggil di dashboard, bukan HTML manual |
| **AC-3** | ✅ Icon trend naik hijau, turun merah | Card "Revenue" (trend: down) tampil merah, sisanya hijau |
| **AC-4** | ✅ Line Chart (Revenue Overview) berhasil di-render | Chart muncul dengan 2 seri data dan animasi smooth |
| **AC-5** | ✅ Donut Chart (Traffic Source) berhasil di-render | Chart muncul dengan 4 segment dan legend di bawah |
| **AC-6** | ✅ Kedua chart berubah tema saat Dark Mode di-toggle | Toggle dark mode → chart otomatis ganti warna tanpa refresh |
| **AC-7** | ✅ Tabel Aktivitas Terbaru muncul dengan benar | 8 baris data, badge status berwarna sesuai kategori |
| **AC-8** | ✅ Tabel responsive di mobile | Kolom "Waktu" tersembunyi di layar kecil (`hidden sm:table-cell`) |
| **AC-9** | ✅ Dark Mode berfungsi pada semua elemen | Card, chart, tabel, dan badge semuanya berubah tema |
| **AC-10** | ✅ Tidak ada error di browser console | DevTools → Console tab bersih tanpa error JavaScript |

---

## 📎 Referensi & Resources

- 📈 [ApexCharts Documentation](https://apexcharts.com/docs/installation/) — Panduan lengkap konfigurasi chart
- 📈 [ApexCharts React Examples](https://apexcharts.com/javascript-chart-demos/) — Gallery contoh chart untuk inspirasi
- 🎨 [Tailwind Grid System](https://tailwindcss.com/docs/grid-template-columns) — Panduan penggunaan CSS Grid
- 🔧 [Blade Components Documentation](https://laravel.com/docs/blade#components) — Cara membuat dan menggunakan Blade Component
- 🎭 [Tailwind Dark Mode Classes](https://tailwindcss.com/docs/dark-mode) — Referensi kelas `dark:` untuk setiap elemen

---

> 💬 **Ada pertanyaan atau menemukan kendala?** Jangan ragu untuk langsung mention di thread issue ini atau hubungi Tech Lead. Tidak ada pertanyaan yang terlalu "basic" — lebih baik bertanya di awal daripada stuck berlama-lama! 🙌
