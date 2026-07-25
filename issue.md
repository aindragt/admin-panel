# Issue #2 — Membuat Master Layout (MVC - View)

**Status:** `Open`
**Priority:** 🔴 High
**Labels:** `feature`, `frontend`, `layout`
**Depends On:** Issue #1 ✅ (Setup Project & Konfigurasi Awal — sudah selesai)

---

## 🎯 Title & Objective

### Judul
**Implementasi Master Layout: Kerangka Visual Utama Admin Panel**

### Mengapa Issue Ini Sangat Penting?

Bayangkan membangun sebuah gedung kantor. Sebelum bisa mengisi setiap ruangan dengan furnitur dan peralatan, kamu perlu membangun dulu **kerangka bangunannya** — atap, dinding luar, koridor utama, dan lift. Itulah peran **master layout** dalam sebuah admin panel.

`app.blade.php` adalah **satu-satunya file** yang mendefinisikan struktur visual seluruh aplikasi. Setiap halaman — dashboard, manajemen user, laporan, settings — semuanya akan "mengisi" master layout ini. Inilah kenapa kamu harus mengerjakannya dengan sangat rapi dan teliti:

- **Konsistensi Mutlak:** Jika kamu mengubah navbar atau sidebar di satu tempat, perubahan itu otomatis berlaku di seluruh halaman. Tidak perlu menyentuh puluhan file sekaligus.
- **Foundation untuk Semua Tim:** Setelah layout selesai, developer lain bisa langsung fokus membuat konten halaman tanpa perlu memikirkan lagi soal struktur header atau sidebar.
- **Kesan Pertama User:** Layout yang responsive dan animasinya mulus adalah hal pertama yang dirasakan user. Ini membentuk persepsi kualitas keseluruhan aplikasi.
- **Dark Mode adalah Standar Modern:** Implementasi yang benar di level layout memastikan *semua* elemen di seluruh aplikasi otomatis mendukung dark mode tanpa effort tambahan.

> 💡 **Catatan untuk kamu:** Issue ini adalah yang paling "terlihat" hasilnya secara visual. Nikmati prosesnya! Kalau ada desain yang kamu rasa bisa lebih bagus dari panduan ini, diskusikan dulu dengan Tech Lead sebelum mengimplementasikan.

---

## 📂 Component & Folder Strategy

### Prinsip Utama: "Layout bukan monolith"

File `app.blade.php` **tidak boleh** berisi ratusan baris kode HTML sekaligus. Kita akan memecahnya menjadi beberapa **partial file** yang masing-masing punya satu tanggung jawab.

### Struktur yang Harus Dibangun

```
resources/
└── views/
    ├── layouts/
    │   ├── app.blade.php                 # Kerangka induk (wrapper HTML penuh)
    │   └── partials/                     # Bagian-bagian kecil dari layout utama
    │       ├── sidebar.blade.php         # Sidebar navigasi vertikal
    │       ├── navbar.blade.php          # Header bar atas (dengan dark mode toggle)
    │       └── footer.blade.php          # Footer aplikasi
    │
    └── components/
        └── ui/                           # (Untuk issue berikutnya — kosongkan dulu)
            ├── button.blade.php
            └── ...
```

### Mengapa Menggunakan `partials/` di Dalam `layouts/`?

Ini adalah pertanyaan yang bagus! Ada dua pendekatan yang sering digunakan:

| Pendekatan | Cara Penggunaan | Cocok Untuk |
|------------|-----------------|-------------|
| **`layouts/partials/`** + `@include` | `@include('layouts.partials.sidebar')` | File yang hanya dipakai di dalam layout (sidebar, navbar, footer) |
| **`components/`** + `<x-tag>` | `<x-sidebar />` | Elemen UI reusable yang dipakai di banyak halaman (button, card, badge) |

Untuk issue ini, kita pakai **pendekatan `partials/`** karena sidebar, navbar, dan footer adalah bagian internal dari layout — mereka tidak akan dipanggil dari halaman konten lain. Ini membuat `components/` tetap bersih hanya untuk elemen UI reusable.

---

## ✅ Step-by-Step Tasks

Ikuti checklist ini secara berurutan. Setiap task memiliki **verifikasi mandiri** yang harus kamu lakukan sebelum lanjut ke task berikutnya.

---

### 🗂️ Task 1: Siapkan Struktur Folder Baru

- [ ] **1.1** Buat direktori `resources/views/layouts/partials/`:
  ```bash
  mkdir resources/views/layouts/partials
  ```

- [ ] **1.2** Pindahkan (atau buat ulang) file-file yang sudah ada sebagai placeholder dari `resources/views/components/layout/` ke lokasi baru:
  ```bash
  # Jika file sudah ada di components/layout/, kamu bisa copy isinya nanti
  # Buat file baru di lokasi yang benar:
  New-Item resources/views/layouts/partials/sidebar.blade.php
  New-Item resources/views/layouts/partials/navbar.blade.php
  New-Item resources/views/layouts/partials/footer.blade.php
  ```
  > ⚠️ Jangan hapus dulu file lama di `components/layout/`. Kita akan update referensinya di `app.blade.php` pada Task 5 nanti.

- [ ] **1.3** Verifikasi struktur folder sudah terbentuk dengan benar sebelum melanjutkan.

---

### 🏗️ Task 2: Update Master Layout `app.blade.php`

File ini sudah ada dari Issue #1 sebagai boilerplate. Sekarang kita sempurnakan strukturnya.

- [ ] **2.1** Buka file `resources/views/layouts/app.blade.php` dan **ganti seluruh isinya** dengan versi final berikut:

  ```html
  <!DOCTYPE html>
  <html
      lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ darkMode: localStorage.getItem('color-theme') === 'dark' || (!localStorage.getItem('color-theme') && window.matchMedia('(prefers-color-scheme: dark)').matches) }"
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
  ```

  > 💡 **Perhatikan perubahan penting:**
  > - Dark mode sekarang di-manage langsung di tag `<html>` menggunakan Alpine.js `x-data` + `x-watch`. Ini adalah cara yang lebih clean dibanding script terpisah di `app.js`.
  > - Struktur layout berubah menjadi `flex h-screen` untuk aplikasi "full-height" yang lebih modern.
  > - Path `@include` diubah ke `layouts.partials.*` agar sesuai folder baru.

- [ ] **2.2** Verifikasi: Simpan file dan pastikan tidak ada syntax error yang terlihat di editor kamu.

---

### 📌 Task 3: Membuat Sidebar

Sidebar adalah navigasi vertikal di sisi kiri. Di layar mobile, sidebar harus **bisa disembunyikan** (toggled) menggunakan Alpine.js.

- [ ] **3.1** Buka file `resources/views/layouts/partials/sidebar.blade.php` dan isi dengan kode berikut:

  ```html
  {{--
      Sidebar Partial
      State: dikontrol oleh `sidebarOpen` dari parent Alpine scope (layouts/app.blade.php)
      Hint untuk Issue berikutnya: tambahkan x-data jika sidebar butuh state lokal sendiri
  --}}

  {{-- Mobile Overlay --}}
  <div
      x-show="sidebarOpen"
      x-transition:enter="transition-opacity ease-linear duration-300"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition-opacity ease-linear duration-300"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
      @click="sidebarOpen = false"
      class="fixed inset-0 z-20 bg-black/50 lg:hidden"
  ></div>

  {{-- Sidebar Panel --}}
  <aside
      :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
      class="fixed inset-y-0 left-0 z-30 flex flex-col w-64 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 transform transition-transform duration-300 ease-in-out lg:static lg:translate-x-0"
  >
      {{-- Logo / Brand --}}
      <div class="flex items-center justify-between h-16 px-6 border-b border-gray-200 dark:border-gray-800 flex-shrink-0">
          <a href="{{ url('/') }}" class="flex items-center gap-2">
              <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                  <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                  </svg>
              </div>
              <span class="text-lg font-bold text-gray-900 dark:text-white">AdminPanel</span>
          </a>
          {{-- Close button (mobile only) --}}
          <button @click="sidebarOpen = false" class="lg:hidden text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
          </button>
      </div>

      {{-- Navigation --}}
      <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">

          {{-- Label Section --}}
          <p class="px-3 mb-2 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">
              Main Menu
          </p>

          <a href="{{ url('/') }}"
             class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                    {{ request()->is('/') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400' : 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800' }}">
              <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
              </svg>
              <span>Dashboard</span>
          </a>

          {{-- Tambahkan menu lain di sini pada issue berikutnya --}}

      </nav>

      {{-- Sidebar Footer --}}
      <div class="flex-shrink-0 px-4 py-4 border-t border-gray-200 dark:border-gray-800">
          <div class="flex items-center gap-3 px-3 py-2">
              <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-sm font-medium text-indigo-700 dark:text-indigo-300">
                  {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
              </div>
              <div class="flex-1 min-w-0">
                  <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                      {{ auth()->user()->name ?? 'Guest' }}
                  </p>
                  <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                      {{ auth()->user()->email ?? 'guest@example.com' }}
                  </p>
              </div>
          </div>
      </div>
  </aside>
  ```

  > ⚠️ **Perhatikan:** Sidebar menggunakan state `sidebarOpen` yang perlu didefinisikan di parent `x-data` di `app.blade.php`. Kamu akan update ini di Task 5.

- [ ] **3.2** Verifikasi: Pastikan semua tag SVG dan attribut Alpine sudah tertutup dengan benar.

---

### 🔝 Task 4: Membuat Navbar dengan Dark Mode Toggle

Navbar adalah header bar di bagian atas konten utama. Fungsinya: toggle sidebar (mobile), judul halaman, dan kontrol user (dark mode toggle, notifikasi, profile).

- [ ] **4.1** Buka file `resources/views/layouts/partials/navbar.blade.php` dan isi dengan kode berikut:

  ```html
  {{-- Navbar Partial --}}
  <header class="flex-shrink-0 h-16 flex items-center justify-between px-6 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800">

      {{-- Left side: Hamburger (mobile) + Page Title --}}
      <div class="flex items-center gap-4">
          {{-- Hamburger button — hanya muncul di mobile --}}
          <button
              @click="sidebarOpen = !sidebarOpen"
              class="lg:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
              aria-label="Toggle Sidebar"
          >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
              </svg>
          </button>

          {{-- Dynamic Page Title --}}
          <h1 class="text-lg font-semibold text-gray-800 dark:text-white">
              @yield('page-title', 'Dashboard')
          </h1>
      </div>

      {{-- Right side: Actions --}}
      <div class="flex items-center gap-2">

          {{-- ☀️🌙 Dark Mode Toggle --}}
          <button
              @click="darkMode = !darkMode"
              class="relative p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
              :aria-label="darkMode ? 'Switch to Light Mode' : 'Switch to Dark Mode'"
              title="Toggle Dark Mode"
          >
              {{-- Sun icon (tampil saat dark mode aktif) --}}
              <svg x-show="darkMode" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"/>
              </svg>
              {{-- Moon icon (tampil saat light mode aktif) --}}
              <svg x-show="!darkMode" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
              </svg>
          </button>

          {{-- Notification Bell (placeholder) --}}
          <button class="relative p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors" title="Notifikasi">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
              </svg>
              {{-- Badge notifikasi --}}
              <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
          </button>

          {{-- User Avatar Dropdown (placeholder) --}}
          <div x-data="{ open: false }" class="relative">
              <button @click="open = !open" @click.outside="open = false"
                  class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                  <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-sm font-medium text-indigo-700 dark:text-indigo-300">
                      {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                  </div>
                  <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                  </svg>
              </button>

              {{-- Dropdown Menu --}}
              <div
                  x-show="open"
                  x-transition:enter="transition ease-out duration-100"
                  x-transition:enter-start="opacity-0 scale-95"
                  x-transition:enter-end="opacity-100 scale-100"
                  x-transition:leave="transition ease-in duration-75"
                  x-transition:leave-start="opacity-100 scale-100"
                  x-transition:leave-end="opacity-0 scale-95"
                  class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 py-1 z-50"
              >
                  <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-700">
                      <p class="text-sm font-medium text-gray-900 dark:text-white">{{ auth()->user()->name ?? 'Guest' }}</p>
                      <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email ?? 'guest@example.com' }}</p>
                  </div>
                  <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                      </svg>
                      Profile
                  </a>
                  <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                      </svg>
                      Settings
                  </a>
              </div>
          </div>

      </div>
  </header>
  ```

- [ ] **4.2** Verifikasi: Simpan file dan review ulang — pastikan ikon matahari dan bulan sudah benar posisinya (`x-show="darkMode"` untuk matahari, `x-show="!darkMode"` untuk bulan).

---

### 📄 Task 5: Membuat Footer

Footer sederhana yang menampilkan informasi copyright.

- [ ] **5.1** Buka file `resources/views/layouts/partials/footer.blade.php` dan isi dengan kode berikut:

  ```html
  {{-- Footer Partial --}}
  <footer class="flex-shrink-0 h-12 flex items-center justify-between px-6 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800">
      <p class="text-xs text-gray-500 dark:text-gray-400">
          &copy; {{ date('Y') }} <span class="font-medium">{{ config('app.name') }}</span>. All rights reserved.
      </p>
      <p class="text-xs text-gray-400 dark:text-gray-600">
          Built with Laravel & Tailwind CSS
      </p>
  </footer>
  ```

---

### 🔧 Task 6: Update `app.blade.php` — Tambahkan Alpine State untuk Sidebar

Karena sidebar butuh state `sidebarOpen`, kita perlu menambahkannya ke `x-data` di `<html>` tag. Ini memastikan sidebar dan navbar bisa saling "berkomunikasi" lewat Alpine.

- [ ] **6.1** Buka kembali `resources/views/layouts/app.blade.php` dan pastikan tag `<html>` sudah memiliki `sidebarOpen` di dalam `x-data`:

  ```html
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
  ```
  > 💡 `sidebarOpen: window.innerWidth >= 1024` berarti sidebar otomatis terbuka di layar besar (desktop) dan tertutup di layar kecil (mobile). Sangat praktis!

- [ ] **6.2** Verifikasi referensi `@include` di `app.blade.php` sudah mengarah ke `layouts.partials.*`:
  ```html
  @include('layouts.partials.sidebar')
  @include('layouts.partials.navbar')
  @include('layouts.partials.footer')
  ```

---

### 🧪 Task 7: Update Halaman Dashboard & Verifikasi Visual

- [ ] **7.1** Buka `resources/views/pages/dashboard.blade.php` dan update isinya untuk memanfaatkan layout baru:

  ```html
  @extends('layouts.app')

  @section('title', 'Dashboard — Admin Panel')
  @section('page-title', 'Dashboard')

  @section('content')
      {{-- Welcome Card --}}
      <div class="mb-6">
          <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
              Selamat Datang! 👋
          </h2>
          <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
              Master layout sudah siap. Saatnya mulai membangun fitur.
          </p>
      </div>

      {{-- Stats Grid (placeholder) --}}
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
          @foreach(['Total Users', 'Active Sessions', 'Revenue', 'Pending Tasks'] as $stat)
          <div class="bg-white dark:bg-gray-800 rounded-xl p-5 border border-gray-200 dark:border-gray-700 shadow-sm">
              <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ $stat }}</p>
              <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">—</p>
          </div>
          @endforeach
      </div>

      {{-- Alpine.js Test --}}
      <div x-data="{ open: false }" class="bg-white dark:bg-gray-800 rounded-xl p-5 border border-gray-200 dark:border-gray-700 shadow-sm">
          <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Alpine.js Verification</h3>
          <button
              @click="open = !open"
              class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors"
          >
              Toggle Test
          </button>
          <div x-show="open" x-transition class="mt-3 p-3 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
              <p class="text-sm text-green-700 dark:text-green-400 font-medium">✅ Alpine.js bekerja dengan baik!</p>
          </div>
      </div>
  @endsection
  ```

- [ ] **7.2** Jalankan Vite dan server Laravel secara bersamaan di dua terminal terpisah:
  ```bash
  # Terminal 1
  npm run dev

  # Terminal 2
  php artisan serve
  ```

- [ ] **7.3** Buka browser dan akses `http://127.0.0.1:8000`. Lakukan pengujian visual berikut:
  - [ ] Sidebar muncul di sisi kiri (di layar ≥ 1024px)
  - [ ] Navbar muncul di bagian atas dengan judul "Dashboard"
  - [ ] Footer muncul di bagian bawah
  - [ ] Tombol Dark Mode toggle di navbar berfungsi (ikon berubah, latar berubah)
  - [ ] Segarkan halaman setelah toggle dark mode — preferensi tersimpan di `localStorage`
  - [ ] Di layar mobile (gunakan DevTools), hamburger button muncul dan bisa toggle sidebar

---

### 🔀 Task 8: Commit & Push ke Branch Baru

- [ ] **8.1** Buat branch baru dari `main`:
  ```bash
  git checkout -b feature/master-layout
  ```

- [ ] **8.2** Tambahkan semua perubahan ke staging:
  ```bash
  git add resources/views/layouts/
  git add resources/views/pages/dashboard.blade.php
  ```

- [ ] **8.3** Buat commit dengan pesan yang deskriptif:
  ```bash
  git commit -m "feat: implement master layout with sidebar, navbar, dark mode toggle, and footer"
  ```

- [ ] **8.4** Push ke remote:
  ```bash
  git push origin feature/master-layout
  ```

---

## 🏁 Acceptance Criteria

Issue ini dinyatakan **Done** jika dan hanya jika **semua** kriteria berikut terpenuhi:

| # | Kriteria | Cara Verifikasi |
|---|----------|-----------------|
| **AC-1** | ✅ Layout tidak *broken* di desktop (≥1024px) | Sidebar, navbar, konten, dan footer tertata rapi tanpa overlap |
| **AC-2** | ✅ Layout responsive di mobile (<1024px) | Sidebar tersembunyi secara default; hamburger button muncul di navbar |
| **AC-3** | ✅ Sidebar bisa di-toggle di mobile | Klik hamburger → sidebar slide in; klik overlay → sidebar slide out |
| **AC-4** | ✅ Dark Mode toggle berfungsi | Klik ikon bulan/matahari → seluruh halaman berubah tema |
| **AC-5** | ✅ Dark Mode tersimpan di `localStorage` | Refresh halaman setelah toggle → tema tetap sesuai pilihan terakhir |
| **AC-6** | ✅ Judul halaman dinamis | `@yield('page-title')` menampilkan judul yang berbeda per halaman |
| **AC-7** | ✅ User dropdown berfungsi | Klik avatar → dropdown muncul; klik di luar → dropdown tertutup |
| **AC-8** | ✅ File tidak monolithic | Sidebar, navbar, footer masing-masing ada di file partial tersendiri di `layouts/partials/` |
| **AC-9** | ✅ Tidak ada error di browser console | DevTools → Console tab tidak menampilkan error JavaScript |
| **AC-10** | ✅ `npm run dev` berjalan tanpa error | Terminal Vite tidak menampilkan error kompilasi |

---

## 📎 Referensi & Resources

- 🏔️ [Alpine.js x-data Documentation](https://alpinejs.dev/directives/data) — Memahami scope dan state management
- 🔀 [Alpine.js x-transition](https://alpinejs.dev/directives/transition) — Animasi smooth untuk sidebar dan dropdown
- 🎨 [Tailwind CSS Flexbox](https://tailwindcss.com/docs/flex) — Panduan layouting dengan flexbox
- 📱 [Tailwind Responsive Design](https://tailwindcss.com/docs/responsive-design) — Breakpoints `sm`, `md`, `lg`, `xl`
- 🌙 [Tailwind Dark Mode](https://tailwindcss.com/docs/dark-mode) — Penggunaan class `dark:` untuk theming

---

> 💬 **Ada pertanyaan atau menemukan kendala?** Jangan ragu untuk langsung mention di thread issue ini atau hubungi Tech Lead. Tidak ada pertanyaan yang terlalu "basic" — lebih baik bertanya di awal daripada stuck berlama-lama! 🙌
