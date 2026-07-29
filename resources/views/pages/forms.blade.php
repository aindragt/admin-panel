@extends('layouts.app')

@section('title', 'Form Components Demo')
@section('page-title', 'Form Components')

@section('content')
    <div class="max-w-4xl space-y-8">

        {{-- Section 1: Text Input --}}
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6 shadow-sm">
            <h2 class="text-base font-semibold text-gray-900 dark:text-white mb-4">Text Input</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Normal State --}}
                <x-form.input
                    name="normal_input"
                    label="Normal State"
                    placeholder="Ketik sesuatu..."
                    hint="Ini adalah hint text untuk user."
                />
                {{-- Focus State --}}
                <x-form.input
                    name="focus_input"
                    label="Focus State (klik input)"
                    placeholder="Klik untuk lihat focus ring..."
                />
                {{-- Error State --}}
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

        {{-- Section 2: Textarea --}}
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6 shadow-sm">
            <h2 class="text-base font-semibold text-gray-900 dark:text-white mb-4">Textarea</h2>
            <div class="space-y-4">
                <x-form.textarea
                    name="bio"
                    label="Bio / Deskripsi"
                    placeholder="Tulis biografi singkat Anda di sini..."
                    hint="Maksimal 500 karakter."
                />
                <x-form.textarea
                    name="address_error"
                    label="Alamat Pengiriman (Error)"
                    placeholder="Tulis alamat lengkap..."
                    error="Alamat pengiriman wajib diisi lengkap dengan kode pos."
                />
            </div>
        </div>

        {{-- Section 3: Select Dropdown --}}
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6 shadow-sm">
            <h2 class="text-base font-semibold text-gray-900 dark:text-white mb-4">Select Dropdown</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-form.select
                    name="role"
                    label="Role Pengguna"
                    :options="['admin' => 'Administrator', 'editor' => 'Editor', 'viewer' => 'Viewer (Read Only)']"
                    hint="Pilih peran yang sesuai."
                />
                <x-form.select
                    name="status_error"
                    label="Status Akun (Error)"
                    :options="['active' => 'Aktif', 'pending' => 'Tertunda', 'suspended' => 'Ditangguhkan']"
                    error="Silakan pilih status akun."
                />
            </div>
        </div>

        {{-- Section 4: Checkbox & Radio --}}
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6 shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Checkbox Demo --}}
                <div class="space-y-4">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">Checkbox</h3>
                    <div class="space-y-3">
                        <x-form.checkbox name="terms" label="Saya setuju dengan syarat & ketentuan yang berlaku." hint="Wajib disetujui sebelum melanjutkan." :checked="true" />
                        <x-form.checkbox name="newsletter" label="Kirimkan saya newsletter mingguan." />
                        <x-form.checkbox name="disabled_check" label="Checkbox (disabled)" :disabled="true" :checked="true" />
                    </div>
                </div>

                {{-- Radio Demo --}}
                <div class="space-y-4">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">Radio Button</h3>
                    <div class="space-y-3">
                        <x-form.radio name="gender" value="male"   label="Laki-laki" :checked="true" />
                        <x-form.radio name="gender" value="female" label="Perempuan" />
                        <x-form.radio name="gender" value="other"  label="Tidak ingin menyebutkan" />
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 5: Button Variants --}}
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6 shadow-sm">
            <h2 class="text-base font-semibold text-gray-900 dark:text-white mb-4">Button Variants</h2>

            {{-- By Variant --}}
            <div class="flex flex-wrap gap-3 mb-5">
                <x-form.button variant="primary">Primary</x-form.button>
                <x-form.button variant="secondary">Secondary</x-form.button>
                <x-form.button variant="danger">Danger</x-form.button>
                <x-form.button variant="success">Success</x-form.button>
                <x-form.button variant="ghost">Ghost</x-form.button>
            </div>

            {{-- By Size --}}
            <div class="flex flex-wrap items-center gap-3 mb-5">
                <x-form.button size="sm">Small Button</x-form.button>
                <x-form.button size="md">Medium Button</x-form.button>
                <x-form.button size="lg">Large Button</x-form.button>
            </div>

            {{-- States & Icons --}}
            <div class="flex flex-wrap items-center gap-3">
                <x-form.button :disabled="true">Disabled State</x-form.button>
                <x-form.button :loading="true">Loading State</x-form.button>
                <x-form.button type="submit" variant="primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Perubahan
                </x-form.button>
            </div>
        </div>

        {{-- Section 6: Real Form Demo --}}
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/30">
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">Contoh Form: Tambah User Baru</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Semua form components digunakan bersama.</p>
            </div>

            <form action="#" method="POST" class="p-6 space-y-5" onsubmit="event.preventDefault(); alert('Form submitted!');">
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
                    name="bio_form"
                    label="Bio (Opsional)"
                    placeholder="Ceritakan sedikit tentang user ini..."
                    :rows="3"
                />

                <div class="space-y-2">
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Notifikasi</p>
                    <x-form.checkbox name="notif_email"  label="Kirim notifikasi via Email" :checked="true" />
                    <x-form.checkbox name="notif_system" label="Tampilkan notifikasi di sistem" :checked="true" />
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-800">
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

    </div>
@endsection
