@extends('layouts.app')

@section('title', 'Form Components')

@section('content')
<div class="mx-auto max-w-5xl space-y-12 px-4 py-8">

    <div>
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Form Components</h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Demo semua elemen form yang reusable — input, textarea, select, checkbox, radio, dan button.
        </p>
    </div>

    {{-- ================= SECTION 1: INPUT & TEXTAREA ================= --}}
    <section>
        <h2 class="mb-4 text-lg font-semibold text-gray-800 dark:text-gray-100">1. Input &amp; Textarea</h2>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <x-form.input
                name="normal_field"
                label="Normal State"
                placeholder="Ketik sesuatu..."
            />

            <x-form.input
                name="focus_field"
                label="Focus State (klik untuk lihat)"
                placeholder="Klik di sini"
            />

            <x-form.input
                name="error_field"
                label="Error State"
                placeholder="you@example.com"
                error="Format email tidak valid."
            />

            <x-form.input
                name="required_field"
                label="Required Field"
                placeholder="Wajib diisi"
                :required="true"
            />

            <x-form.input
                name="disabled_field"
                label="Disabled State"
                placeholder="Tidak bisa diedit"
                value="Nilai terkunci"
                :disabled="true"
            />

            <x-form.input
                name="password_field"
                label="Password"
                type="password"
                placeholder="••••••••"
                hint="Minimal 8 karakter."
            />
        </div>

        <div class="mt-6">
            <x-form.textarea
                name="bio_demo"
                label="Textarea (bisa di-resize vertikal)"
                placeholder="Tulis deskripsi singkat..."
                rows="4"
                hint="Tarik sudut kanan bawah untuk mengubah tinggi."
            />
        </div>

        <div class="mt-8 border-t border-gray-100 pt-8 dark:border-gray-800">
            <h3 class="mb-4 text-md font-semibold text-gray-700 dark:text-gray-300">1.1. Input Add-ons &amp; Custom File Upload (New)</h3>
            
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                {{-- Input dengan Prefix --}}
                <x-form.input 
                    name="price_demo" 
                    label="Harga Produk (Prefix)" 
                    placeholder="0" 
                    prefix="Rp" 
                />

                {{-- Input dengan Suffix --}}
                <x-form.input 
                    name="website_demo" 
                    label="Website (Suffix)" 
                    placeholder="nama-toko" 
                    suffix=".com" 
                />

                {{-- Input Password dengan Toggle Visibility (Alpine.js) --}}
                <div x-data="{ show: false }">
                    <x-form.input
                        name="password_toggle_demo"
                        label="Password dengan Toggle Icon"
                        ::type="show ? 'text' : 'password'"
                        placeholder="••••••••"
                        :suffix-icon="true"
                    >
                        <x-slot name="suffixIcon">
                            <button type="button" @click="show = !show" class="focus:outline-none text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                                <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                </svg>
                                <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </x-slot>
                    </x-form.input>
                </div>
            </div>

            <div class="mt-6">
                {{-- Custom File Upload --}}
                <x-form.file-upload
                    name="laporan_pdf"
                    label="Unggah Laporan Keuangan"
                    accept=".pdf"
                    maxSize="10MB"
                    hint="Hanya file PDF yang diizinkan."
                />
            </div>
        </div>
    </section>

    {{-- ================= SECTION 2: SELECT, CHECKBOX, RADIO ================= --}}
    <section>
        <h2 class="mb-4 text-lg font-semibold text-gray-800 dark:text-gray-100">2. Select, Checkbox &amp; Radio</h2>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <x-form.select
                name="role_demo"
                label="Role Pengguna"
                placeholder="Pilih role"
                :options="['admin' => 'Administrator', 'editor' => 'Editor', 'viewer' => 'Viewer']"
            />

            <x-form.select
                name="role_error_demo"
                label="Select dengan Error"
                placeholder="Pilih role"
                :options="['admin' => 'Administrator', 'editor' => 'Editor']"
                error="Role wajib dipilih."
            />
        </div>

        <div class="mt-6 space-y-3">
            <x-form.checkbox name="terms" label="Saya setuju dengan syarat &amp; ketentuan." :checked="true" />
            <x-form.checkbox name="newsletter" label="Kirimi saya newsletter mingguan." />
            <x-form.checkbox name="marketing" label="Izinkan email promosi." :disabled="true" />
        </div>

        <div class="mt-6 space-y-3">
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Kelamin</p>
            <x-form.radio name="gender" value="male" label="Laki-laki" :checked="true" />
            <x-form.radio name="gender" value="female" label="Perempuan" />
        </div>

        <div class="mt-6 space-y-4">
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Toggle Switch</p>
            <div class="space-y-3">
                <x-form.toggle name="notifications" label="Aktifkan notifikasi email" :checked="true" />
                <x-form.toggle
                    name="maintenance"
                    label="Mode Maintenance"
                    hint="Saat diaktifkan, hanya admin yang bisa mengakses aplikasi."
                    :checked="false"
                />
                <x-form.toggle name="feature_beta" label="Fitur Beta (Segera Hadir)" :disabled="true" />
            </div>
        </div>

        <div class="mt-8 border-t border-gray-100 pt-8 dark:border-gray-800">
            <h3 class="mb-4 text-md font-semibold text-gray-700 dark:text-gray-300">2.1. Datepicker &amp; Advanced Select (New)</h3>
            
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                {{-- Datepicker Component --}}
                <x-form.datepicker
                    name="birth_date_demo"
                    label="Tanggal Lahir (Datepicker)"
                    placeholder="Pilih tanggal"
                    hint="Pilih tanggal lahir Anda sesuai KTP."
                />

                {{-- Searchable Select Component --}}
                @php
                    $provinces = [
                        'jawa_barat'   => 'Jawa Barat',
                        'jawa_tengah'  => 'Jawa Tengah',
                        'jawa_timur'   => 'Jawa Timur',
                        'dki_jakarta'  => 'DKI Jakarta',
                        'banten'       => 'Banten',
                        'bali'         => 'Bali',
                    ];
                @endphp
                <x-form.select-search
                    name="province_demo"
                    label="Provinsi (Searchable Select)"
                    placeholder="Cari & pilih provinsi..."
                    :options="$provinces"
                    selected="jawa_tengah"
                />
            </div>
        </div>
    </section>

    {{-- ================= SECTION 3: BUTTONS ================= --}}
    <section>
        <h2 class="mb-4 text-lg font-semibold text-gray-800 dark:text-gray-100">3. Buttons</h2>

        <div class="space-y-4">
            <div class="flex flex-wrap gap-3">
                <x-form.button variant="primary">Primary</x-form.button>
                <x-form.button variant="secondary">Secondary</x-form.button>
                <x-form.button variant="danger">Danger</x-form.button>
                <x-form.button variant="success">Success</x-form.button>
                <x-form.button variant="ghost">Ghost</x-form.button>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <x-form.button variant="primary" size="sm">Small</x-form.button>
                <x-form.button variant="primary" size="md">Medium</x-form.button>
                <x-form.button variant="primary" size="lg">Large</x-form.button>
            </div>

            <div class="flex flex-wrap gap-3">
                <x-form.button variant="primary" :disabled="true">Disabled</x-form.button>
                <x-form.button variant="primary" :loading="true">Menyimpan...</x-form.button>
            </div>
        </div>
    </section>

    {{-- ================= SECTION 4: DEMO FORM LENGKAP ================= --}}
    <section>
        <h2 class="mb-4 text-lg font-semibold text-gray-800 dark:text-gray-100">4. Demo Form Lengkap — Tambah User Baru</h2>

        <form method="POST" action="{{ url('/forms') }}" class="space-y-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            @csrf

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-form.input name="nama_depan" label="Nama Depan" placeholder="Budi" :required="true" />
                <x-form.input name="nama_belakang" label="Nama Belakang" placeholder="Santoso" :required="true" />
            </div>

            <x-form.input
                name="email"
                type="email"
                label="Email"
                placeholder="budi@example.com"
                :required="true"
                :error="$errors->first('email') ?: null"
            />

            <x-form.input
                name="password"
                type="password"
                label="Password"
                placeholder="••••••••"
                :required="true"
                :error="$errors->first('password') ?: null"
            />

            <x-form.select
                name="role"
                label="Role"
                placeholder="Pilih role pengguna"
                :options="['admin' => 'Administrator', 'editor' => 'Editor', 'viewer' => 'Viewer']"
                :required="true"
            />

            <x-form.textarea
                name="bio"
                label="Bio Singkat"
                placeholder="Ceritakan sedikit tentang user ini..."
                rows="3"
            />

            <div class="space-y-3">
                <x-form.checkbox name="notify_email" label="Kirim notifikasi via email" :checked="true" />
                <x-form.checkbox name="notify_system" label="Kirim notifikasi sistem" />
            </div>

            <div class="flex justify-end gap-3 border-t border-gray-100 pt-5 dark:border-gray-800">
                <x-form.button variant="secondary" type="button" onclick="history.back()">
                    Batal
                </x-form.button>
                <x-form.button variant="primary" type="submit">
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" clip-rule="evenodd" />
                    </svg>
                    Tambah User
                </x-form.button>
            </div>
        </form>
    </section>

</div>
@endsection