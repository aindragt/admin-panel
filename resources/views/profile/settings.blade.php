@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<div class="mx-auto max-w-3xl px-4 py-8" x-data="{ activeTab: 'general' }">

    <div class="mb-6 flex items-center gap-2">
        <a
            href="{{ url()->previous() }}"
            class="rounded-lg p-1.5 text-gray-400 transition-colors duration-150 hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-800 dark:hover:text-gray-300"
        >
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M11.03 3.97a.75.75 0 010 1.06l-6.22 6.22H21a.75.75 0 010 1.5H4.81l6.22 6.22a.75.75 0 11-1.06 1.06l-7.5-7.5a.75.75 0 010-1.06l7.5-7.5a.75.75 0 011.06 0z" clip-rule="evenodd" />
            </svg>
        </a>
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Settings</h1>
    </div>

    <div class="settings-fade-in overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm transition-shadow duration-300 hover:shadow-md dark:border-gray-800 dark:bg-gray-900">

        {{-- ============== TABS NAVIGATION ============== --}}
        <nav class="-mb-px flex gap-1 overflow-x-auto border-b border-gray-100 px-4 dark:border-gray-800" aria-label="Tabs">
            <button
                type="button"
                @click="activeTab = 'general'"
                :class="activeTab === 'general'
                    ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400'
                    : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 hover:border-gray-300 dark:hover:text-gray-300'"
                class="whitespace-nowrap border-b-2 px-3 py-4 text-sm font-medium transition-all duration-200 active:scale-95"
            >
                Informasi Umum
            </button>
            <button
                type="button"
                @click="activeTab = 'security'"
                :class="activeTab === 'security'
                    ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400'
                    : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 hover:border-gray-300 dark:hover:text-gray-300'"
                class="whitespace-nowrap border-b-2 px-3 py-4 text-sm font-medium transition-all duration-200 active:scale-95"
            >
                Keamanan
            </button>
        </nav>

        {{-- ============== PANEL: INFORMASI UMUM ============== --}}
        <div
            x-show="activeTab === 'general'"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-1"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="space-y-8 p-5 sm:p-6"
        >
            {{-- Avatar Section --}}
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center" x-data="{ avatarPreview: null }">
                <div class="relative shrink-0 self-start sm:self-auto">
                    <div class="flex h-20 w-20 items-center justify-center overflow-hidden rounded-full bg-indigo-500 text-xl font-semibold text-white shadow-sm transition-transform duration-200 hover:scale-105">
                        <img x-show="avatarPreview" :src="avatarPreview" class="h-full w-full object-cover" alt="Pratinjau avatar">
                        <span x-show="!avatarPreview">BS</span>
                    </div>

                    <label
                        for="avatar_upload"
                        class="absolute -bottom-1 -right-1 flex h-7 w-7 cursor-pointer items-center justify-center rounded-full border-2 border-white bg-indigo-600 text-white shadow-sm transition-transform duration-150 hover:scale-110 hover:bg-indigo-700 active:scale-95 dark:border-gray-900"
                        title="Ganti foto"
                    >
                        <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M1 8a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 018.07 3h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0016.07 6H17a2 2 0 012 2v7a2 2 0 01-2 2H3a2 2 0 01-2-2V8zm13.5 3a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z" clip-rule="evenodd" />
                        </svg>
                        <input
                            id="avatar_upload"
                            type="file"
                            accept="image/png, image/jpeg, image/gif"
                            class="sr-only"
                            @change="avatarPreview = $event.target.files.length ? URL.createObjectURL($event.target.files[0]) : avatarPreview"
                        />
                    </label>
                </div>

                <div class="min-w-0 flex-1">
                    <p class="font-medium text-gray-900 dark:text-white">Budi Santoso</p>
                    <p class="truncate text-sm text-gray-500 dark:text-gray-400">budi@example.com</p>

                    <div class="mt-2 flex items-center gap-3 text-sm">
                        <label for="avatar_upload" class="cursor-pointer font-medium text-indigo-600 transition-colors hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300">
                            Ganti Foto
                        </label>
                        <span class="text-gray-300 dark:text-gray-700">|</span>
                        <button
                            type="button"
                            x-show="avatarPreview"
                            x-transition.opacity
                            @click="avatarPreview = null; document.getElementById('avatar_upload').value = ''"
                            class="font-medium text-red-500 transition-colors hover:text-red-600"
                        >
                            Hapus Foto
                        </button>
                    </div>
                    <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">JPG, PNG, atau GIF. Maksimal 2MB.</p>
                </div>
            </div>

            {{-- Form Profil --}}
            <div class="space-y-5 border-t border-gray-100 pt-6 dark:border-gray-800">
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <x-form.input name="first_name" label="Nama Depan" value="Budi" />
                    <x-form.input name="last_name" label="Nama Belakang" value="Santoso" />
                </div>

                <x-form.input name="email" type="email" label="Alamat Email" value="budi@example.com" />
                <x-form.input name="phone" type="tel" label="Nomor Telepon" value="+62 812-3456-7890" />

                <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-5 dark:border-gray-800 sm:flex-row sm:justify-end">
                    <x-form.button variant="secondary" type="button">Batal</x-form.button>
                    <x-form.button variant="primary" type="submit">Simpan Perubahan</x-form.button>
                </div>
            </div>
        </div>

        {{-- ============== PANEL: KEAMANAN ============== --}}
        <div
            x-show="activeTab === 'security'"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-1"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            style="display: none;"
            class="space-y-6 p-5 sm:p-6"
            x-data="{ password: '', confirmation: '' }"
        >
            <div class="flex items-start gap-3">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-medium text-gray-900 dark:text-white">Ubah Password</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Gunakan kombinasi huruf besar, huruf kecil, angka, dan simbol untuk keamanan maksimal.
                    </p>
                </div>
            </div>

            <div class="space-y-5">
                <x-form.input name="current_password" type="password" label="Password Saat Ini" />

                <x-form.input
                    name="password"
                    type="password"
                    label="Password Baru"
                    hint="Minimal 8 karakter, kombinasikan huruf dan angka."
                    x-model="password"
                />

                <div>
                    <x-form.input
                        name="password_confirmation"
                        type="password"
                        label="Konfirmasi Password Baru"
                        x-model="confirmation"
                    />
                    <p
                        class="mt-1.5 flex items-center gap-1 text-xs font-medium transition-colors duration-150"
                        x-show="confirmation.length > 0"
                        x-transition.opacity
                        :class="password === confirmation ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-500'"
                        x-text="password === confirmation ? '✓ Password cocok' : '✕ Password tidak cocok'"
                    ></p>
                </div>
            </div>

            {{-- Info box peringatan --}}
            <div class="flex gap-3 rounded-lg border border-amber-200 bg-amber-50 p-4 dark:border-amber-500/20 dark:bg-amber-500/10">
                <svg class="h-5 w-5 shrink-0 text-amber-500" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                </svg>
                <p class="text-sm text-amber-800 dark:text-amber-300">
                    Setelah password diubah, kamu akan diminta untuk <strong>login ulang</strong> di semua perangkat aktif.
                </p>
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-5 dark:border-gray-800 sm:flex-row sm:justify-end">
                <x-form.button variant="secondary" type="button">Batal</x-form.button>
                <x-form.button variant="primary" type="submit">
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                    </svg>
                    Ubah Password
                </x-form.button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Fade-in halus untuk card settings saat halaman dimuat */
    @keyframes settingsFadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .settings-fade-in {
        animation: settingsFadeIn 0.4s ease-out both;
    }

    @media (prefers-reduced-motion: reduce) {
        .settings-fade-in {
            animation: none;
        }
    }
</style>
@endsection