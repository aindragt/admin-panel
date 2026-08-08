@extends('layouts.app')

@section('title', isset($isEditMode) && $isEditMode ? 'Edit Role - Admin Panel' : 'Tambah Role Baru - Admin Panel')

@section('content')
@php
// Simulasi pendeteksian mode edit/tambah berdasarkan segment route
$isEditMode = request()->is('roles/*/edit');

// Data dummy untuk mode edit
$role = [
    'id'          => 2,
    'name'        => 'Administrator',
    'description' => 'Mengelola konten dan pengguna, namun tidak dapat mengubah konfigurasi sistem.',
];

// Data untuk Permission Matrix
$modules = [
    ['key' => 'users',          'label' => 'Kelola Pengguna',     'icon' => '👥'],
    ['key' => 'roles',          'label' => 'Role & Permission',    'icon' => '🔐'],
    ['key' => 'articles',       'label' => 'Artikel & Konten',     'icon' => '📝'],
    ['key' => 'comments',       'label' => 'Moderasi Komentar',    'icon' => '💬'],
    ['key' => 'activity_logs',  'label' => 'Log Aktivitas',        'icon' => '📋'],
    ['key' => 'reports',        'label' => 'Laporan & Analitik',   'icon' => '📊'],
    ['key' => 'settings',       'label' => 'Pengaturan Sistem',    'icon' => '⚙️'],
    ['key' => 'media',          'label' => 'Manajemen Media',      'icon' => '🖼️'],
];

$actions = [
    ['key' => 'view',   'label' => 'View'],
    ['key' => 'create', 'label' => 'Create'],
    ['key' => 'edit',   'label' => 'Edit'],
    ['key' => 'delete', 'label' => 'Delete'],
];

// Permissions yang sudah dimiliki role jika dalam mode edit
$currentPermissions = $isEditMode ? [
    'users.view', 'users.create', 'users.edit',
    'articles.view', 'articles.create', 'articles.edit', 'articles.delete',
    'comments.view', 'comments.edit',
    'reports.view',
] : [];
@endphp

<div x-data="{
    permissions: {{ Js::from($currentPermissions) }},
    modules: {{ Js::from($modules) }},
    actions: {{ Js::from($actions) }},

    hasPermission(moduleKey, actionKey) {
        return this.permissions.includes(moduleKey + '.' + actionKey);
    },

    togglePermission(moduleKey, actionKey) {
        const key = moduleKey + '.' + actionKey;
        if (this.permissions.includes(key)) {
            this.permissions = this.permissions.filter(p => p !== key);
        } else {
            this.permissions.push(key);
        }
    },

    isModuleFullySelected(moduleKey) {
        return this.actions.every(a => this.permissions.includes(moduleKey + '.' + a.key));
    },

    toggleModule(moduleKey) {
        const allKeys = this.actions.map(a => moduleKey + '.' + a.key);
        const isAll = this.isModuleFullySelected(moduleKey);
        if (isAll) {
            this.permissions = this.permissions.filter(p => !allKeys.includes(p));
        } else {
            allKeys.forEach(k => {
                if (!this.permissions.includes(k)) this.permissions.push(k);
            });
        }
    },

    isAllSelected() {
        const allKeys = this.modules.flatMap(m => this.actions.map(a => m.key + '.' + a.key));
        return allKeys.every(k => this.permissions.includes(k));
    },

    toggleAll() {
        const allKeys = this.modules.flatMap(m => this.actions.map(a => m.key + '.' + a.key));
        if (this.isAllSelected()) {
            this.permissions = [];
        } else {
            this.permissions = [...allKeys];
        }
    }
}" class="space-y-6">
    {{-- Header & Breadcrumbs --}}
    <div>
        <nav class="flex text-sm text-gray-500 dark:text-gray-400 mb-1" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="hover:text-gray-700 dark:hover:text-gray-200">Home</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <a href="{{ route('roles.index') }}" class="ml-1 md:ml-2 hover:text-gray-700 dark:hover:text-gray-200">Role & Permission</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="ml-1 md:ml-2 font-medium text-gray-700 dark:text-gray-300">
                            {{ $isEditMode ? 'Edit Role: ' . $role['name'] : 'Tambah Role Baru' }}
                        </span>
                    </div>
                </li>
            </ol>
        </nav>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
            {{ $isEditMode ? 'Edit Role: ' . $role['name'] : 'Tambah Role Baru' }}
        </h1>
    </div>

    <form action="#" method="POST" class="space-y-6" @submit.prevent="alert('Demo: Form submit handler!')">
        @csrf
        
        {{-- Card 1: Identitas Role --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-6 shadow-sm space-y-4">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-800 pb-3">
                Identitas Role
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-form.input 
                        name="name" 
                        label="Nama Role" 
                        placeholder="Masukkan nama role, misal: Editor" 
                        required="true"
                        :value="$isEditMode ? $role['name'] : ''"
                    />
                </div>
                <div>
                    <x-form.textarea 
                        name="description" 
                        label="Deskripsi Singkat" 
                        placeholder="Jelaskan fungsi dan batasan role ini..." 
                        :value="$isEditMode ? $role['description'] : ''"
                    />
                </div>
            </div>
        </div>

        {{-- Card 2: Permission Matrix --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-6 shadow-sm space-y-4">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-b border-gray-100 dark:border-gray-800 pb-4">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">Hak Akses & Otorisasi</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Tentukan izin akses untuk setiap modul.</p>
                </div>
                <div>
                    <x-form.button 
                        variant="secondary" 
                        size="sm" 
                        @click="toggleAll()"
                    >
                        <span x-text="isAllSelected() ? '☐ Lepas Semua' : '☑ Pilih Semua (Global)'"></span>
                    </x-form.button>
                </div>
            </div>

            {{-- Table Matrix container with overflow protection --}}
            <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-800">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/30 text-gray-500 dark:text-gray-400 text-xs font-semibold uppercase tracking-wider">
                            <th class="px-6 py-4 w-64">Modul</th>
                            <template x-for="action in actions" :key="action.key">
                                <th class="px-4 py-4 text-center w-24">
                                    <span x-text="action.label"></span>
                                </th>
                            </template>
                            <th class="px-6 py-4 text-center w-28">Pilih Semua</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        <template x-for="module in modules" :key="module.key">
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2.5">
                                        <span x-text="module.icon" class="text-base"></span>
                                        <span class="font-semibold text-gray-800 dark:text-gray-200" x-text="module.label"></span>
                                    </div>
                                </td>
                                <template x-for="action in actions" :key="action.key">
                                    <td class="px-4 py-4 text-center">
                                        <input
                                            type="checkbox"
                                            :name="'permissions[]'"
                                            :value="module.key + '.' + action.key"
                                            :checked="hasPermission(module.key, action.key)"
                                            @change="togglePermission(module.key, action.key)"
                                            class="h-4 w-4 rounded border-gray-300 dark:border-gray-600 text-indigo-600
                                                   focus:ring-2 focus:ring-indigo-500 focus:ring-offset-0 cursor-pointer bg-white dark:bg-gray-900"
                                        />
                                    </td>
                                </template>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <button
                                        type="button"
                                        @click="toggleModule(module.key)"
                                        :class="isModuleFullySelected(module.key)
                                            ? 'bg-indigo-100 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300 border-indigo-300 dark:border-indigo-700'
                                            : 'bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400 border-gray-300 dark:border-gray-700'"
                                        class="text-xs font-medium px-2.5 py-1 rounded-lg border transition-colors whitespace-nowrap"
                                        x-text="isModuleFullySelected(module.key) ? '✓ Semua' : 'Pilih'"
                                    ></button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Separator & Form Footer --}}
        <div class="pt-4 border-t border-gray-200 dark:border-gray-800 flex items-center justify-end gap-3">
            <a href="{{ route('roles.index') }}">
                <x-form.button variant="secondary">
                    Batal
                </x-form.button>
            </a>
            <x-form.button type="submit" variant="primary">
                {{ $isEditMode ? 'Simpan & Perbarui Role ✓' : 'Simpan Role Baru ✓' }}
            </x-form.button>
        </div>
    </form>
</div>
@endsection
