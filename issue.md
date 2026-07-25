# Issue #1 — Setup Project & Konfigurasi Awal

**Status:** `Open`
**Priority:** 🔴 High
**Labels:** `setup`, `infrastructure`, `foundation`
**Assignee:** Junior Programmer

---

## 🎯 Title & Objective

### Judul
**Setup Fondasi Project Laravel: Struktur, Styling, dan JavaScript Layer**

### Mengapa Issue Ini Sangat Krusial?

Sebelum kita menulis satu baris kode fitur pun, kita perlu memastikan **fondasi project sudah kokoh dan konsisten**. Bayangkan fondasi ini seperti pondasi sebuah gedung — semakin rapi dan kuat sejak awal, semakin mudah dan aman kita membangun lantai-lantai berikutnya.

Berikut adalah alasan konkretnya:

- **Konsistensi Visual:** Dengan mengkonfigurasi Tailwind CSS, Dark Mode, dan font di sini, seluruh tim akan menggunakan design system yang sama. Tidak ada lagi "tiap halaman beda style-nya."
- **Reusability & Maintainability:** Dengan mendefinisikan folder structure sejak awal, setiap komponen UI (tombol, input, card, dll.) dibuat sekali dan dipakai di mana saja. Kalau ada perubahan desain, cukup ubah di satu tempat.
- **Developer Experience (DX) yang Baik:** Alpine.js disetup di sini agar interaksi UI kecil (dropdown, modal, toggle) bisa langsung diimplementasikan tanpa perlu setup tambahan di kemudian hari.
- **Menghindari Technical Debt:** Struktur yang kacau di awal akan menyebabkan refactoring besar di tengah development, yang membuang waktu dan rentan memperkenalkan bug baru.

> 💡 **Catatan untuk kamu:** Jangan terburu-buru di issue ini. Waktu yang kamu investasikan untuk setup yang rapi di sini akan menghemat waktu berkali-kali lipat di issue-issue berikutnya. Tanyakan jika ada yang belum jelas!

---

## 📁 Folder Structure Guideline

Setelah project Laravel berhasil diinisialisasi, kita akan menegakkan **satu aturan paling penting dalam project ini:**

> **"Tidak ada UI yang ditulis lebih dari sekali."**

Untuk itu, kita memisahkan semua file tampilan ke dalam beberapa direktori dengan tanggung jawab yang jelas. Berikut adalah struktur `resources/views/` yang harus kamu buat dan patuhi selama development:

```
resources/
└── views/
    ├── layouts/
    │   ├── app.blade.php          # Master layout utama (wrapper HTML penuh)
    │   └── guest.blade.php        # Layout untuk halaman publik (login, register)
    │
    ├── components/
    │   ├── ui/
    │   │   ├── button.blade.php   # Komponen tombol yang reusable
    │   │   ├── input.blade.php    # Komponen input field
    │   │   ├── card.blade.php     # Komponen card/panel
    │   │   ├── badge.blade.php    # Komponen badge/label status
    │   │   └── alert.blade.php    # Komponen notifikasi/alert
    │   │
    │   └── layout/
    │       ├── sidebar.blade.php  # Komponen sidebar navigasi
    │       ├── navbar.blade.php   # Komponen top navigation bar
    │       └── footer.blade.php   # Komponen footer
    │
    └── pages/
        └── dashboard.blade.php    # Contoh halaman (akan diisi di issue berikutnya)
```

### Aturan Main yang Wajib Diikuti

| Aturan | Penjelasan |
|--------|------------|
| **1 file = 1 tanggung jawab** | `app.blade.php` hanya mengurus wrapper HTML. Konten masuk via `@yield`. |
| **Gunakan `components/ui/` untuk elemen atom** | Tombol, input, badge adalah elemen terkecil yang berdiri sendiri. |
| **Gunakan `components/layout/` untuk elemen struktural** | Sidebar dan navbar adalah bagian dari *chrome* aplikasi, bukan konten. |
| **Halaman diletakkan di `pages/`** | Setiap halaman yang di-render oleh controller masuk ke subfolder `pages/`. |
| **Jangan hardcode style di dalam halaman** | Pakai komponen. Jika komponen belum ada, buat dulu di folder yang sesuai. |

---

## ✅ Step-by-Step Tasks

Ikuti checklist ini secara berurutan. Jangan loncat ke step berikutnya sebelum step yang sedang dikerjakan selesai dan berhasil diverifikasi.

---

### 📦 Task 1: Inisialisasi Project Laravel

- [ ] **1.1** Pastikan environment lokalmu siap. Verifikasi dengan menjalankan perintah berikut di terminal dan pastikan versinya sesuai:
  ```bash
  php --version    # Minimal PHP 8.2
  composer --version
  node --version   # Minimal Node 18.x
  npm --version
  ```

- [ ] **1.2** Buat project Laravel baru di dalam direktori `admin-panel`. Jalankan perintah berikut **satu level di atas** folder `admin-panel`:
  ```bash
  composer create-project laravel/laravel admin-panel
  ```
  > ⚠️ Jika folder `admin-panel` sudah ada dan kamu berada di dalamnya, gunakan `.` sebagai target:
  > ```bash
  > composer create-project laravel/laravel .
  > ```

- [ ] **1.3** Masuk ke direktori project dan verifikasi instalasi berhasil:
  ```bash
  cd admin-panel
  php artisan --version
  # Output yang diharapkan: Laravel Framework x.x.x
  ```

- [ ] **1.4** Salin file environment dan generate application key:
  ```bash
  cp .env.example .env
  php artisan key:generate
  ```

- [ ] **1.5** Sesuaikan konfigurasi database di file `.env`. Buka file tersebut dan ubah bagian berikut sesuai database lokalmu:
  ```dotenv
  APP_NAME="Admin Panel"
  APP_URL=http://admin-panel.test

  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=admin_panel_db
  DB_USERNAME=root
  DB_PASSWORD=
  ```

- [ ] **1.6** Buat database `admin_panel_db` di MySQL (via phpMyAdmin, TablePlus, atau terminal), lalu jalankan migration awal:
  ```bash
  php artisan migrate
  ```

- [ ] **1.7** Jalankan development server dan pastikan halaman welcome Laravel muncul di browser:
  ```bash
  php artisan serve
  # Buka http://127.0.0.1:8000 di browser
  ```

---

### 🎨 Task 2: Instalasi & Konfigurasi Tailwind CSS

- [ ] **2.1** Install Tailwind CSS beserta plugin-plugin yang dibutuhkan menggunakan npm:
  ```bash
  npm install -D tailwindcss @tailwindcss/forms @tailwindcss/typography
  ```
  > 📖 **Mengapa plugin ini?**
  > - `@tailwindcss/forms`: Mereset style default browser pada elemen form agar mudah di-style ulang.
  > - `@tailwindcss/typography`: Menyediakan kelas `prose` untuk konten teks yang kaya (artikel, deskripsi panjang).

- [ ] **2.2** Inisialisasi konfigurasi Tailwind:
  ```bash
  npx tailwindcss init -p
  ```
  Perintah ini akan membuat dua file baru: `tailwind.config.js` dan `postcss.config.js`.

- [ ] **2.3** Buka `tailwind.config.js` dan konfigurasikan `content` paths agar Tailwind tahu file mana yang perlu di-scan untuk class detection:
  ```javascript
  // tailwind.config.js
  /** @type {import('tailwindcss').Config} */
  export default {
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
    ],
    // ... (akan kita isi di task berikutnya)
    plugins: [
      require('@tailwindcss/forms'),
      require('@tailwindcss/typography'),
    ],
  }
  ```

- [ ] **2.4** Buka file `resources/css/app.css` dan ganti seluruh isinya dengan directive Tailwind berikut:
  ```css
  @tailwind base;
  @tailwind components;
  @tailwind utilities;
  ```

- [ ] **2.5** Buka `vite.config.js` dan pastikan konfigurasinya sudah benar (biasanya sudah ter-setup oleh Laravel, tapi verifikasi):
  ```javascript
  // vite.config.js
  import { defineConfig } from 'vite';
  import laravel from 'laravel-vite-plugin';

  export default defineConfig({
      plugins: [
          laravel({
              input: ['resources/css/app.css', 'resources/js/app.js'],
              refresh: true,
          }),
      ],
  });
  ```

- [ ] **2.6** Jalankan Vite development server untuk memverifikasi tidak ada error kompilasi:
  ```bash
  npm run dev
  ```

---

### 🌙 Task 3: Konfigurasi Dark Mode

- [ ] **3.1** Buka kembali `tailwind.config.js` dan tambahkan konfigurasi `darkMode` dengan strategi `class`. Ini berarti Dark Mode akan aktif ketika elemen `<html>` memiliki class `dark`.
  ```javascript
  // tailwind.config.js
  /** @type {import('tailwindcss').Config} */
  export default {
    darkMode: 'class', // 👈 Tambahkan baris ini
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
    ],
    plugins: [
      require('@tailwindcss/forms'),
      require('@tailwindcss/typography'),
    ],
  }
  ```
  > 💡 **Mengapa strategi `class` dan bukan `media`?**
  > Strategi `media` mengikuti preferensi sistem operasi user secara otomatis, tetapi kita tidak bisa mengendalikannya via JavaScript.
  > Strategi `class` memberi kita **kontrol penuh** — user bisa toggle Dark Mode kapan saja melalui tombol di UI, dan pilihannya bisa kita simpan di `localStorage`. Ini adalah standar di hampir semua aplikasi web modern.

- [ ] **3.2** Siapkan logic toggle Dark Mode di `resources/js/app.js`. Tambahkan script berikut untuk membaca preferensi yang tersimpan saat halaman dimuat:
  ```javascript
  // resources/js/app.js

  // Dark Mode Initialization
  // Cek apakah user sebelumnya sudah memilih dark mode, atau ikuti preferensi sistem
  if (
    localStorage.getItem('color-theme') === 'dark' ||
    (!localStorage.getItem('color-theme') &&
      window.matchMedia('(prefers-color-scheme: dark)').matches)
  ) {
    document.documentElement.classList.add('dark');
  } else {
    document.documentElement.classList.remove('dark');
  }
  ```

- [ ] **3.3** Verifikasi: Buka browser DevTools (F12), lalu pergi ke tab **Console** dan ketik:
  ```javascript
  document.documentElement.classList.add('dark')
  ```
  Jika kamu sudah menerapkan class `dark:` di beberapa elemen, kamu seharusnya melihat perubahannya secara langsung. Kita akan membuat tombol toggle-nya sebagai bagian dari komponen `navbar` di issue berikutnya.

---

### 🖋️ Task 4: Setup Font "Inter" dari Google Fonts

- [ ] **4.1** Buka file master layout `resources/views/layouts/app.blade.php` (yang akan kamu buat di Task 6). Tambahkan tag `<link>` berikut di dalam `<head>` untuk memuat font Inter dari Google Fonts:
  ```html
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  ```
  > 💡 Tag `preconnect` pertama-tama membangun koneksi ke server Google Fonts lebih awal, sehingga font dimuat lebih cepat. Ini adalah best practice untuk performa.

- [ ] **4.2** Daftarkan font Inter sebagai font default di `tailwind.config.js`. Kita akan meng-extend `fontFamily` di dalam `theme`:
  ```javascript
  // tailwind.config.js
  import defaultTheme from 'tailwindcss/defaultTheme';

  /** @type {import('tailwindcss').Config} */
  export default {
    darkMode: 'class',
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
    ],
    theme: {
      extend: {
        fontFamily: {
          // Menjadikan Inter sebagai font sans-serif default,
          // dengan fallback ke font default Tailwind jika Inter gagal dimuat
          sans: ['Inter', ...defaultTheme.fontFamily.sans],
        },
      },
    },
    plugins: [
      require('@tailwindcss/forms'),
      require('@tailwindcss/typography'),
    ],
  }
  ```

- [ ] **4.3** Verifikasi: Buka halaman di browser, klik kanan pada teks apapun, pilih "Inspect", lalu lihat di panel **Computed Styles**. Pastikan `font-family` sudah menunjukkan `Inter`.

---

### ⚡ Task 5: Instalasi & Integrasi Alpine.js

- [ ] **5.1** Install Alpine.js melalui npm (cara yang direkomendasikan untuk project dengan build tool):
  ```bash
  npm install alpinejs
  ```

- [ ] **5.2** Inisialisasi Alpine.js di `resources/js/app.js`. Buka file tersebut dan tambahkan kode berikut setelah kode Dark Mode di Task 3.2:
  ```javascript
  // resources/js/app.js

  // --- [Bagian Dark Mode dari Task 3.2 ada di sini] ---

  // Alpine.js Initialization
  import Alpine from 'alpinejs';

  window.Alpine = Alpine; // Expose ke window agar bisa diakses dari DevTools

  Alpine.start();
  ```

- [ ] **5.3** Pastikan `resources/js/app.js` ter-import dengan benar di `app.blade.php` menggunakan directive Vite (akan dikerjakan di Task 6):
  ```html
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  ```

- [ ] **5.4** Verifikasi Alpine.js berfungsi dengan membuat test kecil di halaman mana saja. Tambahkan snippet berikut sementara, lalu hapus setelah berhasil:
  ```html
  <div x-data="{ count: 0 }">
    <button @click="count++" class="px-4 py-2 bg-blue-500 text-white rounded">
      Klik: <span x-text="count"></span>
    </button>
  </div>
  ```
  Jika tombol merespons klik dan angka bertambah, Alpine.js sudah berhasil diintegrasikan. ✅

---

### 🗂️ Task 6: Buat Struktur Folder & File Dasar

- [ ] **6.1** Buat struktur direktori yang sudah didefinisikan di bagian [Folder Structure Guideline](#-folder-structure-guideline) di atas. Kamu bisa menggunakan perintah berikut di terminal (jalankan dari root project):
  ```bash
  mkdir -p resources/views/layouts
  mkdir -p resources/views/components/ui
  mkdir -p resources/views/components/layout
  mkdir -p resources/views/pages
  ```

- [ ] **6.2** Buat file `resources/views/layouts/app.blade.php` sebagai master layout. Berikut adalah boilerplate awalnya:
  ```html
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
  ```

- [ ] **6.3** Buat file placeholder untuk komponen layout agar tidak terjadi error saat `@include` dipanggil. Isi masing-masing dengan komentar HTML sementara:

  **`resources/views/components/layout/sidebar.blade.php`:**
  ```html
  {{-- TODO: Implementasi Sidebar (Issue #2) --}}
  ```

  **`resources/views/components/layout/navbar.blade.php`:**
  ```html
  {{-- TODO: Implementasi Navbar dengan Dark Mode Toggle (Issue #2) --}}
  ```

  **`resources/views/components/layout/footer.blade.php`:**
  ```html
  {{-- TODO: Implementasi Footer (Issue #2) --}}
  ```

- [ ] **6.4** Buat halaman dashboard sementara untuk menguji layout:

  **`resources/views/pages/dashboard.blade.php`:**
  ```html
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
  ```

- [ ] **6.5** Daftarkan route untuk halaman dashboard di `routes/web.php`:
  ```php
  Route::get('/', function () {
      return view('pages.dashboard');
  });
  ```

---

## 🏁 Acceptance Criteria

Issue ini dinyatakan **Done** dan siap untuk fase development berikutnya jika dan hanya jika **semua** kriteria di bawah ini terpenuhi:

| # | Kriteria | Cara Verifikasi |
|---|----------|-----------------|
| **AC-1** | ✅ Project Laravel berhasil diinisialisasi | Perintah `php artisan --version` berhasil dijalankan tanpa error |
| **AC-2** | ✅ Tidak ada error saat menjalankan `npm run dev` | Terminal tidak menampilkan error, Vite HMR server aktif |
| **AC-3** | ✅ Tailwind CSS berfungsi | Menambahkan class Tailwind (misal `bg-red-500`) pada elemen di browser mengubah tampilannya |
| **AC-4** | ✅ Dark Mode dapat diaktifkan via `class` | Menjalankan `document.documentElement.classList.toggle('dark')` di browser console mengubah tampilan halaman |
| **AC-5** | ✅ Font Inter termuat | Browser DevTools → Computed Styles pada elemen teks menampilkan `font-family: Inter, ...` |
| **AC-6** | ✅ Alpine.js berfungsi | Tombol Alpine.js test di halaman dashboard merespons klik |
| **AC-7** | ✅ Struktur folder terbentuk | Direktori `resources/views/layouts/`, `resources/views/components/ui/`, dan `resources/views/components/layout/` sudah ada |
| **AC-8** | ✅ Master layout `app.blade.php` bisa digunakan | Halaman `/` (dashboard) berhasil di-render tanpa error di browser |
| **AC-9** | ✅ Tidak ada error di `php artisan migrate` | Semua migration default Laravel berhasil dijalankan |
| **AC-10** | ✅ File `.env` sudah dikonfigurasi | `APP_KEY` sudah tergenerate (nilai `APP_KEY` di `.env` tidak kosong) |

---

## 📎 Referensi & Resources

- 📖 [Laravel Documentation](https://laravel.com/docs) — Dokumentasi resmi Laravel
- 🎨 [Tailwind CSS Documentation](https://tailwindcss.com/docs) — Semua class Tailwind ada di sini
- 🌙 [Tailwind Dark Mode Guide](https://tailwindcss.com/docs/dark-mode) — Panduan konfigurasi Dark Mode
- ⚡ [Alpine.js Documentation](https://alpinejs.dev/) — Referensi directive dan magic properties Alpine.js
- 🖋️ [Google Fonts: Inter](https://fonts.google.com/specimen/Inter) — Halaman font Inter

---

> 💬 **Ada pertanyaan atau menemukan kendala?** Jangan ragu untuk langsung mention di thread issue ini atau hubungi Tech Lead. Tidak ada pertanyaan yang terlalu "basic" — lebih baik bertanya di awal daripada stuck berlama-lama! 🙌
