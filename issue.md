# Issue #4 — Desain Komponen Form & Input

**Status:** `Open`
**Priority:** 🔴 High
**Labels:** `feature`, `frontend`, `components`, `UI`
**Depends On:** Issue #3 ✅ (Desain Halaman Dashboard — sudah selesai)

---

## 🎯 Title & Objective

### Judul
**Membangun Design System untuk Form Elements: Fondasi UX yang Konsisten**

### Mengapa UI Consistency pada Form Sangat Krusial?

Coba bayangkan kamu menggunakan sebuah aplikasi: di halaman A, tombol "Simpan" berwarna biru dengan sudut membulat. Di halaman B, tombol yang sama berwarna hijau dengan sudut tajam. Di halaman C, ada tombol lain yang terlihat sama sekali berbeda. Apa yang kamu rasakan? **Bingung dan tidak profesional.**

Itulah yang dimaksud dengan **UI inconsistency** — dan form elements adalah tempat yang paling sering bermasalah karena tersebar di banyak halaman (login, tambah data, edit profil, filter, dll.).

Dengan membangun **form components yang reusable** sejak awal, kita mendapatkan:

- **Zero inconsistency:** Input di halaman mana pun selalu terlihat dan terasa sama.
- **Efisiensi Development:** Junior Programmer cukup memanggil `<x-form.input />` — tidak perlu mengingat class Tailwind yang panjang setiap saat.
- **Mudah Diupdate:** Ingin mengubah warna focus ring dari biru ke indigo? Cukup ubah di **satu file**, langsung berlaku di seluruh aplikasi.
- **Aksesibilitas Terjaga:** State `focus`, `error`, dan `disabled` didefinisikan satu kali dengan standar yang benar (ARIA attributes, contrast ratio).

> 💡 **Catatan untuk kamu:** Issue ini adalah tentang membangun **Design System** — bukan sekadar bikin "tombol cantik". Setiap keputusan desain yang kamu buat di sini akan menjadi standar seluruh tim. Kalau ragu soal pilihan warna atau ukuran, diskusikan dulu!

---

## 📂 Component & Folder Strategy

### Prinsip: Pisahkan `form/` dari `ui/`

Kita sudah punya `components/ui/` untuk elemen display seperti `stat-card`. Sekarang kita buat direktori terpisah khusus untuk elemen interaktif form:

```
resources/
└── views/
    ├── pages/
    │   └── forms.blade.php              # [NEW] Halaman demo semua form components
    │
    └── components/
        ├── ui/
        │   └── stat-card.blade.php      # (sudah ada dari Issue #3)
        │
        └── form/                        # [NEW] Khusus elemen form
            ├── input.blade.php          # Text input + label + error state
            ├── textarea.blade.php       # Multi-line text input
            ├── select.blade.php         # Dropdown select
            ├── checkbox.blade.php       # Custom styled checkbox
            ├── radio.blade.php          # Custom styled radio button
            └── button.blade.php         # Button dengan variasi warna & size
```

### Cara Pemanggilan (Blade Syntax)

Karena semua file ada di `components/form/`, mereka dipanggil dengan prefix `x-form.*`:

```html
{{-- Input biasa --}}
<x-form.input name="email" label="Email Address" type="email" placeholder="you@example.com" />

{{-- Input dengan error state --}}
<x-form.input name="email" label="Email Address" :error="$errors->first('email')" />

{{-- Button primary --}}
<x-form.button variant="primary">Simpan Data</x-form.button>

{{-- Button danger --}}
<x-form.button variant="danger" type="button">Hapus</x-form.button>
```

### Daftarkan Route untuk Halaman Demo

Halaman demo perlu route agar bisa diakses di browser:
```php
// routes/web.php
Route::get('/forms', fn() => view('pages.forms'))->name('forms.demo');
```

---

## ✅ Step-by-Step Tasks

Ikuti checklist ini secara berurutan.

---

### 🗂️ Task 1: Siapkan Folder & Halaman Demo

- [ ] **1.1** Buat direktori `resources/views/components/form/`:
  ```bash
  mkdir resources/views/components/form
  ```

- [ ] **1.2** Buat file halaman demo `resources/views/pages/forms.blade.php` dengan struktur awal:

  ```html
  @extends('layouts.app')

  @section('title', 'Form Components Demo')
  @section('page-title', 'Form Components')

  @section('content')
      <div class="max-w-4xl space-y-8">

          {{-- Section akan ditambahkan per task --}}

          <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6 shadow-sm">
              <h2 class="text-base font-semibold text-gray-900 dark:text-white mb-1">📋 Halaman Demo</h2>
              <p class="text-sm text-gray-500 dark:text-gray-400">
                  Halaman ini menampilkan semua form components yang tersedia. Isi saat task dikerjakan.
              </p>
          </div>

      </div>
  @endsection
  ```

- [ ] **1.3** Tambahkan route di `routes/web.php`:
  ```php
  Route::get('/forms', fn() => view('pages.forms'))->name('forms.demo');
  ```

- [ ] **1.4** Verifikasi: Buka `http://127.0.0.1:8000/forms` — halaman kosong tapi tidak ada error.

---

### 📝 Task 2: Komponen `input.blade.php` — Text Input dengan 3 States

Ini adalah komponen yang paling sering digunakan. Harus mendukung state: **normal**, **focus**, dan **error**.

- [ ] **2.1** Buat file `resources/views/components/form/input.blade.php`:

  ```html
  {{--
      Text Input Component
      Props:
        - $name        : string  — Atribut name & id pada input (wajib)
        - $label       : string  — Label teks di atas input
        - $type        : string  — "text" | "email" | "password" | "number" | "tel" (default: "text")
        - $placeholder : string  — Placeholder text
        - $value       : mixed   — Nilai awal input (opsional)
        - $error       : string  — Pesan error (jika ada, input berubah ke state merah)
        - $hint        : string  — Teks bantuan kecil di bawah input
        - $required    : bool    — Tampilkan tanda * merah di label
        - $disabled    : bool    — State disabled
  --}}

  @props([
      'name'        => '',
      'label'       => '',
      'type'        => 'text',
      'placeholder' => '',
      'value'       => null,
      'error'       => null,
      'hint'        => null,
      'required'    => false,
      'disabled'    => false,
  ])

  <div class="w-full">

      {{-- Label --}}
      @if($label)
      <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
          {{ $label }}
          @if($required)
              <span class="text-red-500 ml-0.5">*</span>
          @endif
      </label>
      @endif

      {{-- Input Field --}}
      <input
          type="{{ $type }}"
          id="{{ $name }}"
          name="{{ $name }}"
          value="{{ old($name, $value) }}"
          placeholder="{{ $placeholder }}"
          {{ $required ? 'required' : '' }}
          {{ $disabled ? 'disabled' : '' }}
          {{ $attributes->merge([
              'class' => '
                  w-full px-3.5 py-2.5 rounded-lg text-sm
                  bg-white dark:bg-gray-800
                  border transition-colors duration-150
                  text-gray-900 dark:text-white
                  placeholder-gray-400 dark:placeholder-gray-500
                  focus:outline-none focus:ring-2 focus:ring-offset-0
                  disabled:opacity-50 disabled:cursor-not-allowed disabled:bg-gray-50 dark:disabled:bg-gray-900
                  ' . ($error
                      ? 'border-red-400 dark:border-red-500 focus:border-red-400 focus:ring-red-300 dark:focus:ring-red-500/30'
                      : 'border-gray-300 dark:border-gray-700 focus:border-indigo-500 focus:ring-indigo-300 dark:focus:ring-indigo-500/30'
                  )
          ]) }}
      />

      {{-- Hint Text --}}
      @if($hint && !$error)
      <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">{{ $hint }}</p>
      @endif

      {{-- Error Message --}}
      @if($error)
      <p class="mt-1.5 text-xs text-red-600 dark:text-red-400 flex items-center gap-1">
          <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
          </svg>
          {{ $error }}
      </p>
      @endif

  </div>
  ```

- [ ] **2.2** Tambahkan demo di `forms.blade.php` untuk menampilkan semua state:

  ```html
  {{-- Demo: Text Input --}}
  <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6 shadow-sm">
      <h2 class="text-base font-semibold text-gray-900 dark:text-white mb-4">Text Input</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          {{-- Normal state --}}
          <x-form.input
              name="normal_input"
              label="Normal State"
              placeholder="Ketik sesuatu..."
              hint="Ini adalah hint text untuk user."
          />
          {{-- Focus state (otomatis saat diklik) --}}
          <x-form.input
              name="focus_input"
              label="Focus State (klik input)"
              placeholder="Klik untuk lihat focus ring..."
          />
          {{-- Error state --}}
          <x-form.input
              name="error_input"
              label="Error State"
              placeholder="Ada yang salah..."
              error="Email tidak valid. Gunakan format yang benar."
          />
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
          {{-- Required --}}
          <x-form.input
              name="required_input"
              label="Required Field"
              placeholder="Wajib diisi"
              :required="true"
          />
          {{-- Disabled --}}
          <x-form.input
              name="disabled_input"
              label="Disabled State"
              value="Tidak bisa diubah"
              :disabled="true"
          />
          {{-- Password --}}
          <x-form.input
              name="password_input"
              type="password"
              label="Password Field"
              placeholder="••••••••"
          />
      </div>
  </div>
  ```

- [ ] **2.3** Verifikasi di browser: 3 state (normal, focus saat diklik, error) tampil dengan benar dalam dark dan light mode.

---

### 📝 Task 3: Komponen `textarea.blade.php`

- [ ] **3.1** Buat file `resources/views/components/form/textarea.blade.php`:

  ```html
  @props([
      'name'        => '',
      'label'       => '',
      'placeholder' => '',
      'value'       => null,
      'error'       => null,
      'hint'        => null,
      'required'    => false,
      'disabled'    => false,
      'rows'        => 4,
  ])

  <div class="w-full">
      @if($label)
      <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
          {{ $label }}
          @if($required) <span class="text-red-500 ml-0.5">*</span> @endif
      </label>
      @endif

      <textarea
          id="{{ $name }}"
          name="{{ $name }}"
          rows="{{ $rows }}"
          placeholder="{{ $placeholder }}"
          {{ $required ? 'required' : '' }}
          {{ $disabled ? 'disabled' : '' }}
          {{ $attributes->merge([
              'class' => '
                  w-full px-3.5 py-2.5 rounded-lg text-sm resize-y
                  bg-white dark:bg-gray-800
                  border transition-colors duration-150
                  text-gray-900 dark:text-white
                  placeholder-gray-400 dark:placeholder-gray-500
                  focus:outline-none focus:ring-2 focus:ring-offset-0
                  disabled:opacity-50 disabled:cursor-not-allowed
                  ' . ($error
                      ? 'border-red-400 dark:border-red-500 focus:border-red-400 focus:ring-red-300'
                      : 'border-gray-300 dark:border-gray-700 focus:border-indigo-500 focus:ring-indigo-300 dark:focus:ring-indigo-500/30'
                  )
          ]) }}
      >{{ old($name, $value) }}</textarea>

      @if($hint && !$error)
      <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">{{ $hint }}</p>
      @endif

      @if($error)
      <p class="mt-1.5 text-xs text-red-600 dark:text-red-400 flex items-center gap-1">
          <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
          </svg>
          {{ $error }}
      </p>
      @endif
  </div>
  ```

- [ ] **3.2** Tambahkan demo di `forms.blade.php`:
  ```html
  <x-form.textarea name="bio" label="Bio / Deskripsi" placeholder="Tulis sesuatu..." hint="Maks. 500 karakter." />
  ```

---

### 🔽 Task 4: Komponen `select.blade.php` — Dropdown Modern

- [ ] **4.1** Buat file `resources/views/components/form/select.blade.php`:

  ```html
  @props([
      'name'     => '',
      'label'    => '',
      'options'  => [],
      'selected' => null,
      'error'    => null,
      'hint'     => null,
      'required' => false,
      'disabled' => false,
      'placeholder' => 'Pilih salah satu...',
  ])

  <div class="w-full">
      @if($label)
      <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
          {{ $label }}
          @if($required) <span class="text-red-500 ml-0.5">*</span> @endif
      </label>
      @endif

      <div class="relative">
          <select
              id="{{ $name }}"
              name="{{ $name }}"
              {{ $required ? 'required' : '' }}
              {{ $disabled ? 'disabled' : '' }}
              {{ $attributes->merge([
                  'class' => '
                      w-full px-3.5 py-2.5 pr-10 rounded-lg text-sm appearance-none
                      bg-white dark:bg-gray-800
                      border transition-colors duration-150
                      text-gray-900 dark:text-white
                      focus:outline-none focus:ring-2 focus:ring-offset-0
                      disabled:opacity-50 disabled:cursor-not-allowed
                      ' . ($error
                          ? 'border-red-400 focus:border-red-400 focus:ring-red-300'
                          : 'border-gray-300 dark:border-gray-700 focus:border-indigo-500 focus:ring-indigo-300 dark:focus:ring-indigo-500/30'
                      )
              ]) }}
          >
              <option value="" disabled {{ !$selected ? 'selected' : '' }}>
                  {{ $placeholder }}
              </option>
              @foreach($options as $value => $label)
              <option value="{{ $value }}" {{ old($name, $selected) == $value ? 'selected' : '' }}>
                  {{ $label }}
              </option>
              @endforeach
          </select>

          {{-- Custom chevron icon --}}
          <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
              <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
              </svg>
          </div>
      </div>

      @if($hint && !$error)
      <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">{{ $hint }}</p>
      @endif

      @if($error)
      <p class="mt-1.5 text-xs text-red-600 dark:text-red-400 flex items-center gap-1">
          <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
          </svg>
          {{ $error }}
      </p>
      @endif
  </div>
  ```

- [ ] **4.2** Tambahkan demo di `forms.blade.php`:
  ```html
  <x-form.select
      name="role"
      label="Role Pengguna"
      :options="['admin' => 'Administrator', 'editor' => 'Editor', 'viewer' => 'Viewer (Read Only)']"
      hint="Pilih peran yang sesuai."
  />
  ```

- [ ] **4.3** Verifikasi: Ikon chevron custom muncul (bukan chevron default browser) dan select dapat mengambil nilai yang dipilih.

---

### ☑️ Task 5: Komponen `checkbox.blade.php` — Custom Styled

Plugin `@tailwindcss/forms` sudah kita install di Issue #1 — plugin ini mereset style default browser pada checkbox agar mudah di-custom dengan Tailwind.

- [ ] **5.1** Buat file `resources/views/components/form/checkbox.blade.php`:

  ```html
  @props([
      'name'     => '',
      'label'    => '',
      'value'    => '1',
      'checked'  => false,
      'disabled' => false,
      'hint'     => null,
  ])

  <div class="flex items-start gap-3">
      <div class="flex items-center h-5 mt-0.5">
          <input
              type="checkbox"
              id="{{ $name }}"
              name="{{ $name }}"
              value="{{ $value }}"
              {{ old($name, $checked) ? 'checked' : '' }}
              {{ $disabled ? 'disabled' : '' }}
              class="
                  w-4 h-4 rounded
                  text-indigo-600 dark:text-indigo-500
                  bg-white dark:bg-gray-800
                  border-gray-300 dark:border-gray-600
                  focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:ring-2 focus:ring-offset-1
                  disabled:opacity-50 disabled:cursor-not-allowed
                  transition-colors duration-150
                  cursor-pointer
              "
          />
      </div>
      <div>
          @if($label)
          <label for="{{ $name }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 cursor-pointer {{ $disabled ? 'opacity-50' : '' }}">
              {{ $label }}
          </label>
          @endif
          @if($hint)
          <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $hint }}</p>
          @endif
      </div>
  </div>
  ```

- [ ] **5.2** Buat file `resources/views/components/form/radio.blade.php`:

  ```html
  @props([
      'name'     => '',
      'label'    => '',
      'value'    => '',
      'checked'  => false,
      'disabled' => false,
      'hint'     => null,
  ])

  <div class="flex items-start gap-3">
      <div class="flex items-center h-5 mt-0.5">
          <input
              type="radio"
              id="{{ $name }}_{{ $value }}"
              name="{{ $name }}"
              value="{{ $value }}"
              {{ old($name) == $value || $checked ? 'checked' : '' }}
              {{ $disabled ? 'disabled' : '' }}
              class="
                  w-4 h-4
                  text-indigo-600 dark:text-indigo-500
                  bg-white dark:bg-gray-800
                  border-gray-300 dark:border-gray-600
                  focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:ring-2 focus:ring-offset-1
                  disabled:opacity-50 disabled:cursor-not-allowed
                  cursor-pointer
              "
          />
      </div>
      <div>
          @if($label)
          <label for="{{ $name }}_{{ $value }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 cursor-pointer {{ $disabled ? 'opacity-50' : '' }}">
              {{ $label }}
          </label>
          @endif
          @if($hint)
          <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $hint }}</p>
          @endif
      </div>
  </div>
  ```

- [ ] **5.3** Tambahkan demo di `forms.blade.php`:

  ```html
  {{-- Checkbox Demo --}}
  <div class="space-y-3">
      <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Checkbox</h3>
      <x-form.checkbox name="terms" label="Saya setuju dengan syarat & ketentuan yang berlaku." hint="Wajib disetujui sebelum melanjutkan." :checked="true" />
      <x-form.checkbox name="newsletter" label="Kirimkan saya newsletter mingguan." />
      <x-form.checkbox name="disabled_check" label="Checkbox (disabled)" :disabled="true" :checked="true" />
  </div>

  {{-- Radio Demo --}}
  <div class="space-y-3">
      <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Radio Button</h3>
      <x-form.radio name="gender" value="male"   label="Laki-laki" :checked="true" />
      <x-form.radio name="gender" value="female" label="Perempuan" />
      <x-form.radio name="gender" value="other"  label="Tidak ingin menyebutkan" />
  </div>
  ```

---

### 🔘 Task 6: Komponen `button.blade.php` — Multi-Variant

- [ ] **6.1** Buat file `resources/views/components/form/button.blade.php`:

  ```html
  {{--
      Button Component
      Props:
        - $variant : "primary" | "secondary" | "danger" | "ghost" | "success" (default: "primary")
        - $size    : "sm" | "md" | "lg" (default: "md")
        - $type    : "button" | "submit" | "reset" (default: "button")
        - $disabled: bool
        - $loading : bool — Tampilkan spinner dan disable button
  --}}

  @props([
      'variant'  => 'primary',
      'size'     => 'md',
      'type'     => 'button',
      'disabled' => false,
      'loading'  => false,
  ])

  @php
  $variants = [
      'primary'   => 'bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white shadow-sm focus:ring-indigo-400',
      'secondary' => 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 active:bg-gray-100 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 shadow-sm focus:ring-gray-300',
      'danger'    => 'bg-red-600 hover:bg-red-700 active:bg-red-800 text-white shadow-sm focus:ring-red-400',
      'success'   => 'bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white shadow-sm focus:ring-emerald-400',
      'ghost'     => 'bg-transparent hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-400 focus:ring-gray-300',
  ];

  $sizes = [
      'sm' => 'px-3 py-1.5 text-xs rounded-lg',
      'md' => 'px-4 py-2.5 text-sm rounded-lg',
      'lg' => 'px-6 py-3 text-base rounded-xl',
  ];

  $variantClass = $variants[$variant] ?? $variants['primary'];
  $sizeClass    = $sizes[$size] ?? $sizes['md'];
  $isDisabled   = $disabled || $loading;
  @endphp

  <button
      type="{{ $type }}"
      {{ $isDisabled ? 'disabled' : '' }}
      {{ $attributes->merge([
          'class' => "
              inline-flex items-center justify-center gap-2 font-medium
              transition-all duration-150
              focus:outline-none focus:ring-2 focus:ring-offset-2
              disabled:opacity-50 disabled:cursor-not-allowed
              {$variantClass} {$sizeClass}
          "
      ]) }}
  >
      {{-- Loading Spinner --}}
      @if($loading)
      <svg class="animate-spin w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
      </svg>
      @endif

      {{-- Slot: konten tombol (teks / ikon) --}}
      {{ $slot }}
  </button>
  ```

- [ ] **6.2** Tambahkan demo di `forms.blade.php`:

  ```html
  {{-- Demo: Button Variants --}}
  <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6 shadow-sm">
      <h2 class="text-base font-semibold text-gray-900 dark:text-white mb-4">Button Variants</h2>

      {{-- By Variant --}}
      <div class="flex flex-wrap gap-3 mb-4">
          <x-form.button variant="primary">Primary</x-form.button>
          <x-form.button variant="secondary">Secondary</x-form.button>
          <x-form.button variant="danger">Danger</x-form.button>
          <x-form.button variant="success">Success</x-form.button>
          <x-form.button variant="ghost">Ghost</x-form.button>
      </div>

      {{-- By Size --}}
      <div class="flex flex-wrap items-center gap-3 mb-4">
          <x-form.button size="sm">Small</x-form.button>
          <x-form.button size="md">Medium</x-form.button>
          <x-form.button size="lg">Large</x-form.button>
      </div>

      {{-- States --}}
      <div class="flex flex-wrap items-center gap-3">
          <x-form.button :disabled="true">Disabled</x-form.button>
          <x-form.button :loading="true">Loading...</x-form.button>
          <x-form.button type="submit" variant="primary">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
              </svg>
              Simpan Perubahan
          </x-form.button>
      </div>
  </div>
  ```

- [ ] **6.3** Verifikasi semua variant dan size tampil dengan benar. Test state `loading` — spinner harus berputar.

---

### 🧩 Task 7: Rakit Semua Komponen dalam Form Demo Lengkap

Setelah semua komponen selesai, buat satu section demo "form nyata" untuk membuktikan semua komponen bisa bekerja bersama.

- [ ] **7.1** Tambahkan section "Contoh Form Nyata" di bagian bawah `forms.blade.php`:

  ```html
  {{-- Demo: Contoh Form Nyata --}}
  <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">

      <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800">
          <h2 class="text-base font-semibold text-gray-900 dark:text-white">Contoh Form: Tambah User Baru</h2>
          <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Semua form components digunakan bersama.</p>
      </div>

      <form action="#" method="POST" class="p-6 space-y-5">
          @csrf
          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
              <x-form.input name="first_name" label="Nama Depan" placeholder="Budi" :required="true" />
              <x-form.input name="last_name"  label="Nama Belakang" placeholder="Santoso" />
          </div>

          <x-form.input
              name="email"
              type="email"
              label="Alamat Email"
              placeholder="budi@example.com"
              :required="true"
              hint="Email akan digunakan untuk login."
          />

          <x-form.input
              name="password"
              type="password"
              label="Password"
              placeholder="Minimal 8 karakter"
              :required="true"
              error="Password minimal 8 karakter dan harus mengandung angka."
          />

          <x-form.select
              name="role"
              label="Role"
              :options="['admin' => 'Administrator', 'editor' => 'Editor', 'viewer' => 'Viewer']"
              :required="true"
          />

          <x-form.textarea
              name="bio"
              label="Bio (Opsional)"
              placeholder="Ceritakan sedikit tentang user ini..."
              :rows="3"
          />

          <div class="space-y-2">
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Notifikasi</p>
              <x-form.checkbox name="notif_email"  label="Kirim notifikasi via Email" :checked="true" />
              <x-form.checkbox name="notif_system" label="Tampilkan notifikasi di sistem" :checked="true" />
          </div>

          <div class="flex items-center justify-end gap-3 pt-2 border-t border-gray-100 dark:border-gray-800">
              <x-form.button type="button" variant="secondary">Batal</x-form.button>
              <x-form.button type="submit" variant="primary">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                  </svg>
                  Tambah User
              </x-form.button>
          </div>
      </form>
  </div>
  ```

- [ ] **7.2** Verifikasi form terlihat kohesif dan semua komponen bekerja bersama tanpa ada yang aneh tampilannya.

---

### 🔀 Task 8: Commit & Push ke Branch Baru

- [ ] **8.1** Buat branch baru dari `main`:
  ```bash
  git checkout -b feature/form-components
  ```

- [ ] **8.2** Staging semua file baru:
  ```bash
  git add resources/views/pages/forms.blade.php
  git add resources/views/components/form/
  git add routes/web.php
  ```

- [ ] **8.3** Commit:
  ```bash
  git commit -m "feat: add reusable form components (input, textarea, select, checkbox, radio, button)"
  ```

- [ ] **8.4** Push ke remote:
  ```bash
  git push origin feature/form-components
  ```

---

## 🏁 Acceptance Criteria

Issue ini dinyatakan **Done** jika dan hanya jika **semua** kriteria berikut terpenuhi:

| # | Kriteria | Cara Verifikasi |
|---|----------|-----------------|
| **AC-1** | ✅ Halaman demo `/forms` bisa diakses | Buka `http://127.0.0.1:8000/forms` — tidak ada error |
| **AC-2** | ✅ Input `normal state` tampil benar | Border abu-abu, tidak ada focus ring |
| **AC-3** | ✅ Input `focus state` tampil benar | Klik input → border biru + indigo ring muncul |
| **AC-4** | ✅ Input `error state` tampil benar | Prop `error` terisi → border merah + ikon + pesan error |
| **AC-5** | ✅ Input `disabled state` tampil benar | Opacity berkurang, cursor not-allowed, tidak bisa diklik |
| **AC-6** | ✅ Textarea berfungsi dan bisa di-resize | Bisa diketik, bisa di-drag untuk resize secara vertikal |
| **AC-7** | ✅ Select dropdown berfungsi | Pilihan tersedia, chevron custom muncul, nilai terpilih tersimpan |
| **AC-8** | ✅ Checkbox custom styling aktif | Centang berwarna indigo (bukan biru default browser) |
| **AC-9** | ✅ Radio button custom styling aktif | Pilihan berwarna indigo, hanya 1 yang bisa dipilih per grup |
| **AC-10** | ✅ Button semua variant tampil berbeda | Primary biru, Secondary abu outline, Danger merah, dll. |
| **AC-11** | ✅ Button `loading` state aktif | Spinner berputar + button tidak bisa diklik |
| **AC-12** | ✅ Semua komponen konsisten di Dark Mode | Latar gelap, teks terang, border gelap — tidak ada elemen yang "ghost"/tak terlihat |
| **AC-13** | ✅ Semua komponen dipanggil via `<x-form.*>` | Tidak ada komponen yang di-hardcode langsung sebagai HTML di `forms.blade.php` |
| **AC-14** | ✅ Form demo lengkap terlihat kohesif | Section "Tambah User Baru" tampil rapi, semua komponen berjalan bersama |

---

## 📎 Referensi & Resources

- 🎨 [Tailwind CSS Forms Plugin](https://github.com/tailwindlabs/tailwindcss-forms) — Plugin reset form style yang sudah kita install
- 📖 [Blade Components - `@props`](https://laravel.com/docs/blade#component-attributes) — Cara menggunakan props di Blade Component
- 📖 [Blade `$attributes->merge()`](https://laravel.com/docs/blade#merging-attributes) — Cara merge class dari luar dengan class default component
- 🎨 [Tailwind Focus Ring](https://tailwindcss.com/docs/ring-width) — Konfigurasi focus ring (ring, ring-offset, ring-color)
- ♿ [Web Accessibility - Form Labels](https://www.w3.org/WAI/tutorials/forms/labels/) — Standar aksesibilitas untuk form elements

---

> 💬 **Ada pertanyaan atau menemukan kendala?** Jangan ragu untuk langsung mention di thread issue ini atau hubungi Tech Lead. Tidak ada pertanyaan yang terlalu "basic" — lebih baik bertanya di awal daripada stuck berlama-lama! 🙌
